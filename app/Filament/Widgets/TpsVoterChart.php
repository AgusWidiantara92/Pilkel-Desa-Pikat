<?php

namespace App\Filament\Widgets;

use App\Models\Tps;
use Filament\Widgets\ChartWidget;

class TpsVoterChart extends ChartWidget
{
    protected static ?string $heading = 'Sebaran Pemilih per TPS';

    protected static ?int $sort = 3;

    protected static string $type = 'bar';

    protected function getData(): array
    {
        $tpsData = Tps::withCount('voters')->get();

        $labels = $tpsData->map(fn ($tps) => "TPS {$tps->nomor_tps}")->toArray();
        $counts = $tpsData->map(fn ($tps) => $tps->voters_count)->toArray();

        return [
            'datasets' => [
                [
                    'label' => 'Jumlah DPT Terdaftar',
                    'data' => $counts,
                    'backgroundColor' => '#10b981', // Emerald / Success
                    'borderColor' => '#059669',
                    'borderWidth' => 1,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
