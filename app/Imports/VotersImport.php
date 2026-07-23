<?php

namespace App\Imports;

use App\Models\Tps;
use App\Models\Voter;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use PhpOffice\PhpSpreadsheet\Shared\Date as ExcelDate;
use Throwable;

class VotersImport implements 
    ToCollection, 
    WithHeadingRow, 
    WithValidation, 
    SkipsOnError, 
    SkipsOnFailure,
    WithChunkReading,
    WithBatchInserts
{
    use SkipsErrors, SkipsFailures;

    /**
     * Proses pengolahan koleksi data dari sheet Excel
     */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            // 1. Mengambil NKK & NIK pertama
            // CATATAN: Dengan WithHeadingRow, $row['nkk'] & $row['nik'] mengambil kolom pertama.
            // Kolom NKK kedua (misal 'nkk_2' / 'nkk_duplikat') dan NIK kedua ('nik_2') otomatis diabaikan.
            $nkk = trim((string) ($row['nkk'] ?? $row[0] ?? ''));
            $nik = trim((string) ($row['nik'] ?? $row[1] ?? ''));

            if (empty($nik)) {
                continue; // Lewati jika NIK kosong
            }

            // 2. Parsing Tanggal Lahir (Mendukung format DD|MM|YYYY, DD-MM-YYYY, DD/MM/YYYY, & Excel Date)
            $tanggalLahir = $this->parseTanggalLahir($row['tanggal_lahir'] ?? $row['tgl_lahir'] ?? null);

            // 3. Normalisasi Jenis Kelamin (L / P)
            $jenisKelamin = strtoupper(trim((string) ($row['jenis_kelamin'] ?? $row['jk'] ?? 'L')));
            $jenisKelamin = in_array($jenisKelamin, ['L', 'P']) ? $jenisKelamin : 'L';

            // 4. Normalisasi Status Perkawinan (B / S / P)
            $statusPerkawinan = $this->parseStatusPerkawinan($row['status_perkawinan'] ?? $row['status_kawin'] ?? 'B');

            // 5. Lookup & Auto-Create TPS berdasarkan nomor TPS (misal: "TPS 001" atau "1")
            $nomorTps = trim((string) ($row['nomor_tps'] ?? $row['tps'] ?? '1'));
            if (!str_starts_with(strtoupper($nomorTps), 'TPS')) {
                $nomorTps = 'TPS ' . str_pad($nomorTps, 3, '0', STR_PAD_LEFT);
            }

            $tps = Tps::firstOrCreate(
                ['nomor_tps' => $nomorTps],
                [
                    'nama_lokasi' => 'Lokasi ' . $nomorTps,
                    'dusun' => $row['dusun'] ?? 'Desa Pikat',
                ]
            );

            // 6. Normalisasi Status Pemilih (aktif / tms)
            $statusRaw = strtolower(trim((string) ($row['status'] ?? 'aktif')));
            $status = in_array($statusRaw, ['aktif', 'tms']) ? $statusRaw : 'aktif';

            // 7. Upsert ke Tabel Voters (Update jika NIK sudah ada, Insert jika baru)
            Voter::updateOrCreate(
                ['nik' => $nik],
                [
                    'nkk' => $nkk,
                    'nama' => trim((string) ($row['nama'] ?? '')),
                    'tempat_lahir' => trim((string) ($row['tempat_lahir'] ?? '')),
                    'tanggal_lahir' => $tanggalLahir,
                    'jenis_kelamin' => $jenisKelamin,
                    'status_perkawinan' => $statusPerkawinan,
                    'alamat' => trim((string) ($row['alamat'] ?? '')),
                    'dusun' => trim((string) ($row['dusun'] ?? '')),
                    'tps_id' => $tps->id,
                    'status' => $status,
                    'keterangan' => trim((string) ($row['keterangan'] ?? 'Imported via Excel')),
                ]
            );
        }
    }

    /**
     * Helper Parsing Tanggal Lahir (DD|MM|YYYY, DD-MM-YYYY, DD/MM/YYYY, & Excel Date)
     */
    private function parseTanggalLahir($rawDate): ?string
    {
        if (empty($rawDate)) {
            return null;
        }

        try {
            // A. Jika tanggal berupa format angka bawaan Excel (contoh: 33100)
            if (is_numeric($rawDate)) {
                return Carbon::instance(ExcelDate::excelToDateTimeObject($rawDate))->format('Y-m-d');
            }

            // B. Ganti karakter pemisah '|', '/', atau '.' menjadi '-'
            $cleanDate = str_replace(['|', '/', '.'], '-', trim((string) $rawDate));

            // C. Parsing format DD-MM-YYYY / D-M-YYYY
            if (preg_match('/^\d{1,2}-\d{1,2}-\d{4}$/', $cleanDate)) {
                return Carbon::createFromFormat('d-m-Y', $cleanDate)->format('Y-m-d');
            }

            // D. Parsing format YYYY-MM-DD (ISO)
            if (preg_match('/^\d{4}-\d{1,2}-\d{1,2}$/', $cleanDate)) {
                return Carbon::parse($cleanDate)->format('Y-m-d');
            }

            // E. Fallback parsing umum dengan Carbon
            return Carbon::parse($cleanDate)->format('Y-m-d');
        } catch (Throwable $e) {
            Log::warning("Gagal parsing tanggal lahir: {$rawDate}. Error: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Helper Normalisasi Status Perkawinan (B / S / P)
     */
    private function parseStatusPerkawinan($val): string
    {
        $val = strtoupper(trim((string) $val));
        if (in_array($val, ['S', 'SUDAH', 'SUDAH KAWIN', 'KAWIN'])) return 'S';
        if (in_array($val, ['P', 'PERNAH', 'PERNAH KAWIN', 'DUDA', 'JANDA'])) return 'P';
        return 'B'; // Belum Kawin
    }

    /**
     * Rule Validasi Kolom Excel
     */
    public function rules(): array
    {
        return [
            '*.nik' => ['required'],
            '*.nama' => ['required', 'string'],
        ];
    }

    /**
     * Custom Pesan Validasi Error
     */
    public function customValidationMessages(): array
    {
        return [
            '*.nik.required' => 'Baris data wajib memiliki NIK.',
            '*.nama.required' => 'Baris data wajib memiliki Nama.',
        ];
    }

    /**
     * Membaca file Excel dalam chunk (mencegah memory limit pada file besar)
     */
    public function chunkSize(): int
    {
        return 500;
    }

    /**
     * Ukuran Batch Inserts ke Database
     */
    public function batchSize(): int
    {
        return 500;
    }
}
