<?php

namespace App\Imports;

use App\Models\Tps;
use App\Models\Voter;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use PhpOffice\PhpSpreadsheet\Shared\Date as ExcelDate;
use Throwable;

/**
 * Import per-Sheet: Membaca data pemilih dari satu sheet TPS
 *
 * Mapping kolom Excel (berdasarkan posisi indeks):
 *  A (0): KELURAHAN
 *  B (1): NKK        ← Lengkap (DIGUNAKAN)
 *  C (2): NKK        ← Disensor **** (DIABAIKAN)
 *  D (3): NIK        ← Lengkap (DIGUNAKAN)
 *  E (4): NIK        ← Disensor **** (DIABAIKAN)
 *  F (5): NAMA
 *  G (6): TEMPAT LAHIR
 *  H (7): TANGGAL LAHIR
 *  I (8): STS KAWIN
 *  J (9): KELAMIN
 *  K (10): ALAMAT
 *  L (11): DISABILITAS
 *  M (12): EKTP
 */
class VoterSheetImport implements
    ToCollection,
    SkipsOnError,
    SkipsOnFailure,
    WithChunkReading,
    WithBatchInserts
{
    use SkipsErrors, SkipsFailures;

    private string $sheetName;

    public function __construct(string $sheetName = 'TPS 001')
    {
        $this->sheetName = $sheetName;
    }

    /**
     * Proses pengolahan koleksi data dari satu sheet Excel.
     */
    public function collection(Collection $rows)
    {
        // Normalisasi nama sheet menjadi format TPS (misal: "TPS 01" → "TPS 001")
        $nomorTps = $this->normalizeSheetToTps($this->sheetName);

        // Auto-create TPS jika belum ada
        $tps = Tps::firstOrCreate(
            ['nomor_tps' => $nomorTps],
            [
                'nama_lokasi' => 'Lokasi ' . $nomorTps,
                'dusun' => 'Desa Pikat',
            ]
        );

        foreach ($rows as $row) {
            // Deteksi dan lewati baris header
            $colB = trim((string) ($row[1] ?? ''));
            $colD = trim((string) ($row[3] ?? ''));

            if (
                strtoupper($colB) === 'NKK' ||
                strtoupper($colD) === 'NIK' ||
                strtoupper(trim((string) ($row[5] ?? ''))) === 'NAMA' ||
                strtoupper(trim((string) ($row[0] ?? ''))) === 'KELURAHAN'
            ) {
                continue; // Lewati baris header
            }

            // Kolom B (index 1) = NKK lengkap
            $nkk = $colB;

            // Kolom D (index 3) = NIK lengkap
            $nik = $colD;

            if (empty($nik) || !is_numeric($nik)) {
                continue;
            }

            // Kolom F (index 5) = NAMA
            $nama = trim((string) ($row[5] ?? ''));
            if (empty($nama)) {
                continue;
            }

            // Kolom G (index 6) = TEMPAT LAHIR
            $tempatLahir = trim((string) ($row[6] ?? ''));

            // Kolom H (index 7) = TANGGAL LAHIR
            $tanggalLahir = $this->parseTanggalLahir($row[7] ?? null);

            // Kolom I (index 8) = STATUS KAWIN
            $statusPerkawinan = $this->parseStatusPerkawinan($row[8] ?? 'B');

            // Kolom J (index 9) = JENIS KELAMIN
            $jenisKelamin = strtoupper(trim((string) ($row[9] ?? 'L')));
            $jenisKelamin = in_array($jenisKelamin, ['L', 'P']) ? $jenisKelamin : 'L';

            // Kolom K (index 10) = ALAMAT → digunakan juga untuk Dusun/Banjar
            $alamat = trim((string) ($row[10] ?? ''));

            // Upsert ke Tabel Voters
            Voter::updateOrCreate(
                ['nik' => $nik],
                [
                    'nkk' => $nkk,
                    'nama' => $nama,
                    'tempat_lahir' => $tempatLahir,
                    'tanggal_lahir' => $tanggalLahir,
                    'jenis_kelamin' => $jenisKelamin,
                    'status_perkawinan' => $statusPerkawinan,
                    'alamat' => $alamat,
                    'dusun' => $alamat,
                    'tps_id' => $tps->id,
                    'status' => 'aktif',
                    'keterangan' => null,
                ]
            );
        }
    }

    /**
     * Normalisasi nama sheet ke format TPS standar
     * "TPS 01" → "TPS 001", "TPS 1" → "TPS 001", "1" → "TPS 001"
     */
    private function normalizeSheetToTps(string $sheetName): string
    {
        // Ambil angka dari nama sheet
        preg_match('/\d+/', $sheetName, $matches);
        $number = $matches[0] ?? '1';

        return 'TPS ' . str_pad($number, 3, '0', STR_PAD_LEFT);
    }

    /**
     * Helper Parsing Tanggal Lahir
     */
    private function parseTanggalLahir($rawDate): ?string
    {
        if (empty($rawDate)) {
            return null;
        }

        try {
            if (is_numeric($rawDate)) {
                return Carbon::instance(ExcelDate::excelToDateTimeObject($rawDate))->format('Y-m-d');
            }

            $cleanDate = str_replace(['|', '/', '.'], '-', trim((string) $rawDate));

            if (preg_match('/^\d{1,2}-\d{1,2}-\d{4}$/', $cleanDate)) {
                return Carbon::createFromFormat('d-m-Y', $cleanDate)->format('Y-m-d');
            }

            if (preg_match('/^\d{4}-\d{1,2}-\d{1,2}$/', $cleanDate)) {
                return Carbon::parse($cleanDate)->format('Y-m-d');
            }

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
        return 'B';
    }

    public function chunkSize(): int
    {
        return 500;
    }

    public function batchSize(): int
    {
        return 500;
    }
}
