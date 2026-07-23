<?php

namespace App\Filament\Widgets;

use App\Models\Tps;
use App\Models\Voter;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverviewWidget extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $totalPemilih = Voter::count();
        $pemilihAktif = Voter::where('status', 'aktif')->count();
        $pemilihTms = Voter::where('status', 'tms')->count();
        $totalTps = Tps::count();

        return [
            Stat::make('Total DPT Terdaftar', number_format($totalPemilih, 0, ',', '.'))
                ->description('Jumlah seluruh pemilih')
                ->descriptionIcon('heroicon-m-users')
                ->color('primary'),

            Stat::make('Pemilih Aktif', number_format($pemilihAktif, 0, ',', '.'))
                ->description('Memenuhi syarat memilih')
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('success'),

            Stat::make('Tidak Memenuhi Syarat (TMS)', number_format($pemilihTms, 0, ',', '.'))
                ->description('Meninggal / Pindah / Ganda')
                ->descriptionIcon('heroicon-m-x-circle')
                ->color('danger'),

            Stat::make('Total TPS', number_format($totalTps, 0, ',', '.'))
                ->description('TPS di Desa Pikat')
                ->descriptionIcon('heroicon-m-building-office-2')
                ->color('info'),
        ];
    }
}
