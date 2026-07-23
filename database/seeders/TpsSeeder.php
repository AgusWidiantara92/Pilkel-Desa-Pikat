<?php

namespace Database\Seeders;

use App\Models\Tps;
use Illuminate\Database\Seeder;

class TpsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tpsData = [
            [
                'nomor_tps' => 'TPS 001',
                'nama_lokasi' => 'SD Negeri 1 Pikat',
                'dusun' => 'Banjar Pikat',
                'kuota_pemilih' => 350,
                'keterangan' => 'TPS Wilayah Utara Desa Pikat',
            ],
            [
                'nomor_tps' => 'TPS 002',
                'nama_lokasi' => 'Balai Banjar Gelgel',
                'dusun' => 'Banjar Gelgel',
                'kuota_pemilih' => 400,
                'keterangan' => 'TPS Wilayah Tengah Desa Pikat',
            ],
            [
                'nomor_tps' => 'TPS 003',
                'nama_lokasi' => 'Balai Desa Pikat',
                'dusun' => 'Banjar Tengah',
                'kuota_pemilih' => 380,
                'keterangan' => 'TPS Wilayah Selatan Desa Pikat',
            ],
        ];

        foreach ($tpsData as $data) {
            Tps::updateOrCreate(['nomor_tps' => $data['nomor_tps']], $data);
        }
    }
}
