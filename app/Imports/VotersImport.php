<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

/**
 * Import Data DPT dari File Excel Multi-Sheet (TPS 01 - TPS 07)
 *
 * Setiap sheet mewakili satu TPS. Nama sheet digunakan sebagai nomor TPS.
 * Import membaca SEMUA sheet dan otomatis membuat TPS jika belum ada.
 */
class VotersImport implements WithMultipleSheets
{
    /**
     * Mapping setiap sheet ke importer per-TPS berdasarkan nama sheet
     */
    public function sheets(): array
    {
        return [
            'TPS 01' => new VoterSheetImport('TPS 01'),
            'TPS 02' => new VoterSheetImport('TPS 02'),
            'TPS 03' => new VoterSheetImport('TPS 03'),
            'TPS 04' => new VoterSheetImport('TPS 04'),
            'TPS 05' => new VoterSheetImport('TPS 05'),
            'TPS 06' => new VoterSheetImport('TPS 06'),
            'TPS 07' => new VoterSheetImport('TPS 07'),
        ];
    }
}
