<?php

namespace App\Filament\Widgets;

use App\Models\Tps;
use Filament\Widgets\ChartWidget;

class TpsVoterChart extends ChartWidget
{
    protected static ?string $heading = 'Sebaran Pemilih per TPS';

    protected static ?int $sort = 3;

    protected static string $type = 'bar';

    protected static bool $isLazy = true;

    protected function getData(): array
    {
        $chartData = cache()->remember('dashboard_tps_chart_data', 300, function () {
            $tpsData = Tps::withCount('voters')->get();
            return [
                'labels' => $tpsData->map(fn ($tps) => "TPS {$tps->nomor_tps}")->toArray(),
                'counts' => $tpsData->map(fn ($tps) => $tps->voters_count)->toArray(),
            ];
        });

        $labels = $chartData['labels'];
        $counts = $chartData['counts'];

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
