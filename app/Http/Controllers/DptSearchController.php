<?php

namespace App\Http\Controllers;

use App\Models\Voter;
use Illuminate\Http\Request;

class DptSearchController extends Controller
{
    /**
     * Tampilan Halaman Utama
     */
    public function index()
    {
        return view('welcome');
    }

    /**
     * Logic Pencarian DPT berdasarkan NIK
     */
    public function search(Request $request)
    {
        // 1. Validasi NIK 16 digit angka
        $request->validate([
            'nik' => ['required', 'digits:16', 'numeric'],
        ], [
            'nik.required' => 'Nomor Induk Kependudukan (NIK) wajib diisi.',
            'nik.digits' => 'NIK harus tepat 16 digit angka.',
            'nik.numeric' => 'NIK hanya boleh berisi karakter angka.',
        ]);

        $inputNik = trim($request->input('nik'));

        // 2. Query Database Voter dengan Relasi TPS
        $voter = Voter::with('tps')->where('nik', $inputNik)->first();

        // 3. Jika Pemilih Ditemukan
        if ($voter) {
            $maskedVoter = [
                'nik_masked' => $this->maskNik($voter->nik),
                'nama_masked' => $this->maskName($voter->nama),
                'dusun' => $voter->dusun ?? 'Desa Pikat',
                'nomor_tps' => $voter->tps->nomor_tps ?? 'TPS -',
                'nama_lokasi_tps' => $voter->tps->nama_lokasi ?? 'Lokasi TPS',
                'status' => $voter->status,
                'keterangan' => $voter->keterangan ?? 'Terdaftar dalam DPT',
            ];

            return view('welcome', [
                'voter' => $maskedVoter,
                'searchedNik' => $inputNik,
            ]);
        }

        // 4. Jika Pemilih Tidak Ditemukan -> Siapkan Tombol WhatsApp Panitia
        $whatsappMessage = rawurlencode("Halo Panitia Pilkel Desa Pikat, NIK saya ({$inputNik}) belum terdaftar dalam DPT. Mohon dibantu pengecekannya.");
        $whatsappUrl = "https://wa.me/6281234567890?text={$whatsappMessage}";

        return view('welcome', [
            'notFound' => true,
            'searchedNik' => $inputNik,
            'whatsappUrl' => $whatsappUrl,
        ]);
    }

    /**
     * Helper Masking NIK: 510501******0001
     */
    private function maskNik(string $nik): string
    {
        if (strlen($nik) !== 16) {
            return $nik;
        }

        return substr($nik, 0, 6) . '******' . substr($nik, 12, 4);
    }

    /**
     * Helper Masking Nama: I Wayan Sudiarta -> I W**** S*******
     */
    private function maskName(string $name): string
    {
        $words = explode(' ', trim($name));
        $maskedWords = array_map(function ($word) {
            $length = mb_strlen($word);
            if ($length <= 2) {
                return $word;
            }

            return mb_substr($word, 0, 1) . str_repeat('*', $length - 1);
        }, $words);

        return implode(' ', $maskedWords);
    }
}
