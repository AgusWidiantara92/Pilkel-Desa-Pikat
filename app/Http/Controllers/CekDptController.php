<?php

namespace App\Http\Controllers;

use App\Models\Voter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Throwable;

class CekDptController extends Controller
{
    /**
     * Tampilkan halaman utama Cek DPT untuk masyarakat.
     *
     * Route: GET /
     */
    public function index(): View
    {
        return view('welcome');
    }

    /**
     * Proses pencarian data DPT berdasarkan NIK.
     *
     * Route: POST /cek-dpt
     *
     * Alur:
     * 1. Validasi & sanitasi input NIK (wajib 16 digit angka)
     * 2. Query Eloquent ke tabel voters + eager load relasi tps
     * 3. Jika ditemukan → tampilkan data ter-masking (NIK & Nama)
     * 4. Jika tidak ditemukan → tampilkan tombol WhatsApp ke Panitia
     * 5. Jika terjadi error sistem → log error & tampilkan pesan ramah
     */
    public function search(Request $request): View|\Illuminate\Http\RedirectResponse
    {
        // ──────────────────────────────────────────────
        // 1. VALIDASI INPUT NIK
        // ──────────────────────────────────────────────
        $request->validate([
            'nik' => ['required', 'digits:16', 'numeric'],
        ], [
            'nik.required' => 'Nomor Induk Kependudukan (NIK) wajib diisi.',
            'nik.digits'   => 'NIK harus tepat 16 digit angka.',
            'nik.numeric'  => 'NIK hanya boleh berisi karakter angka.',
        ]);

        // 2. SANITASI INPUT (Cegah XSS)
        $inputNik = trim(strip_tags($request->input('nik')));

        try {
            // ──────────────────────────────────────────
            // 3. QUERY ELOQUENT — Optimasi Performa
            // ──────────────────────────────────────────
            // - select() : Ambil hanya kolom yang dibutuhkan (hemat memori)
            // - with()   : Eager load relasi tps dengan kolom spesifik
            //              (mencegah N+1 Query Problem)
            // - where()  : Pencarian exact-match berdasarkan NIK
            //              (memanfaatkan UNIQUE INDEX pada kolom nik)
            $voter = Voter::select([
                    'id',
                    'nik',
                    'nama',
                    'dusun',
                    'tps_id',
                    'status',
                    'keterangan',
                ])
                ->with(['tps' => function ($query) {
                    $query->select(['id', 'nomor_tps', 'nama_lokasi']);
                }])
                ->where('nik', $inputNik)
                ->first();

            // ──────────────────────────────────────────
            // 4. HASIL: PEMILIH DITEMUKAN
            // ──────────────────────────────────────────
            if ($voter) {
                // Tampilkan data pemilih tanpa sensor
                $maskedVoter = [
                    'nik_masked'       => $voter->nik,
                    'nama_masked'      => $voter->nama,
                    'dusun'            => $voter->dusun ?? 'Desa Pikat',
                    'nomor_tps'        => $voter->tps->nomor_tps ?? 'TPS -',
                    'nama_lokasi_tps'  => $voter->tps->nama_lokasi ?? 'Lokasi TPS',
                    'status'           => $voter->status,
                    'keterangan'       => $voter->keterangan ?? 'Terdaftar dalam DPT',
                ];

                return view('welcome', [
                    'voter'       => $maskedVoter,
                    'searchedNik' => $inputNik,
                ]);
            }

            // ──────────────────────────────────────────
            // 5. HASIL: PEMILIH TIDAK DITEMUKAN
            // ──────────────────────────────────────────
            // Siapkan link WhatsApp otomatis ke Panitia Pilkel
            $whatsappMessage = rawurlencode(
                "Halo Panitia Pilkel Desa Pikat, NIK saya ({$inputNik}) "
                . "belum terdaftar dalam DPT. Mohon dibantu pengecekannya."
            );
            $whatsappUrl = "https://wa.me/6281234567890?text={$whatsappMessage}";

            return view('welcome', [
                'notFound'    => true,
                'searchedNik' => $inputNik,
                'whatsappUrl' => $whatsappUrl,
            ]);

        } catch (Throwable $e) {
            // ──────────────────────────────────────────
            // 6. ERROR HANDLING — Catat & Tampilkan Pesan Ramah
            // ──────────────────────────────────────────
            Log::error('Error pada pencarian DPT: ' . $e->getMessage(), [
                'nik'   => $inputNik,
                'trace' => $e->getTraceAsString(),
            ]);

            return back()->with(
                'error',
                'Terjadi kendala teknis pada sistem pencarian. Silakan coba beberapa saat lagi.'
            );
        }
    }

    // ══════════════════════════════════════════════════
    // HELPER METHODS (Private)
    // ══════════════════════════════════════════════════

    /**
     * Masking NIK: Tampilkan 6 digit awal & 4 digit akhir.
     *
     * Contoh: 5105011508900001 → 510501******0001
     */
    private function maskNik(string $nik): string
    {
        if (strlen($nik) !== 16) {
            return $nik;
        }

        return substr($nik, 0, 6) . '******' . substr($nik, 12, 4);
    }

    /**
     * Masking Nama: Tampilkan semua kata kecuali kata terakhir yang di-mask.
     *
     * Contoh: I Wayan Sudiarta → I Wayan S***
     * Contoh: Ni Luh Putu Sari → Ni Luh Putu S***
     * Jika nama hanya 1 kata: Sudiarta → S***
     */
    private function maskName(string $name): string
    {
        $words = explode(' ', trim($name));
        $count = count($words);

        // Jika hanya 1 kata, mask langsung
        if ($count === 1) {
            return mb_substr($words[0], 0, 1) . '***';
        }

        // Tampilkan semua kata kecuali kata terakhir
        // Kata terakhir: tampilkan huruf pertama + ***
        $lastWord = array_pop($words);
        $maskedLast = mb_substr($lastWord, 0, 1) . '***';

        $words[] = $maskedLast;

        return implode(' ', $words);
    }
}
