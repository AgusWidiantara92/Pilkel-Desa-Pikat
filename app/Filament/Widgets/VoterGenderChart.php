<?php

namespace App\Filament\Widgets;

use App\Models\Voter;
use Filament\Widgets\ChartWidget;

class VoterGenderChart extends ChartWidget
{
    protected static ?string $heading = 'Sebaran Pemilih Berdasarkan Jenis Kelamin';
    
    protected static ?int $sort = 2;
    
    protected static string $type = 'doughnut';

    protected static bool $isLazy = true;

    protected function getData(): array
    {
        $genderStats = cache()->remember('dashboard_gender_stats', 300, function () {
            return [
                'male' => Voter::where('jenis_kelamin', 'L')->count(),
                'female' => Voter::where('jenis_kelamin', 'P')->count(),
            ];
        });

        $maleCount = $genderStats['male'];
        $femaleCount = $genderStats['female'];

        return [
            'datasets' => [
                [
                    'label' => 'Jumlah Pemilih',
                    'data' => [$maleCount, $femaleCount],
                    'backgroundColor' => [
                        '#6366f1', // Indigo / Laki-laki
                        '#ec4899', // Pink / Perempuan
                    ],
                ],
            ],
            'labels' => ['Laki-laki', 'Perempuan'],
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }
}
