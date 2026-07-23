<?php

namespace Database\Seeders;

use App\Models\Tps;
use App\Models\Voter;
use Illuminate\Database\Seeder;

class VoterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tps1 = Tps::where('nomor_tps', 'TPS 001')->first();
        $tps2 = Tps::where('nomor_tps', 'TPS 002')->first();
        $tps3 = Tps::where('nomor_tps', 'TPS 003')->first();

        if (!$tps1 || !$tps2 || !$tps3) {
            return;
        }

        $voters = [
            [
                'nkk' => '5105011203040001',
                'nik' => '5105011508900001',
                'nama' => 'I Wayan Sudiarta',
                'tempat_lahir' => 'Klungkung',
                'tanggal_lahir' => '1990-08-15',
                'jenis_kelamin' => 'L',
                'status_perkawinan' => 'S',
                'alamat' => 'Jl. Perbekel Pikat No. 12',
                'dusun' => 'Banjar Pikat',
                'tps_id' => $tps1->id,
                'status' => 'aktif',
                'keterangan' => 'Pemilih Terdaftar',
            ],
            [
                'nkk' => '5105011203040001',
                'nik' => '5105015005920002',
                'nama' => 'Ni Made Astini',
                'tempat_lahir' => 'Klungkung',
                'tanggal_lahir' => '1992-05-10',
                'jenis_kelamin' => 'P',
                'status_perkawinan' => 'S',
                'alamat' => 'Jl. Perbekel Pikat No. 12',
                'dusun' => 'Banjar Pikat',
                'tps_id' => $tps1->id,
                'status' => 'aktif',
                'keterangan' => 'Pemilih Terdaftar',
            ],
            [
                'nkk' => '5105011203040002',
                'nik' => '5105012011850003',
                'nama' => 'I Nyoman Suardana',
                'tempat_lahir' => 'Pikat',
                'tanggal_lahir' => '1985-11-20',
                'jenis_kelamin' => 'L',
                'status_perkawinan' => 'S',
                'alamat' => 'Banjar Gelgel RT 02/RW 01',
                'dusun' => 'Banjar Gelgel',
                'tps_id' => $tps2->id,
                'status' => 'aktif',
                'keterangan' => 'Pemilih Terdaftar',
            ],
            [
                'nkk' => '5105011203040003',
                'nik' => '5105016501980004',
                'nama' => 'Ni Ketut Putrini',
                'tempat_lahir' => 'Klungkung',
                'tanggal_lahir' => '1998-01-25',
                'jenis_kelamin' => 'P',
                'status_perkawinan' => 'B',
                'alamat' => 'Jl. Raya Desa Pikat No. 45',
                'dusun' => 'Banjar Tengah',
                'tps_id' => $tps3->id,
                'status' => 'aktif',
                'keterangan' => 'Pemilih Pemula',
            ],
        ];

        foreach ($voters as $voter) {
            Voter::updateOrCreate(['nik' => $voter['nik']], $voter);
        }
    }
}
