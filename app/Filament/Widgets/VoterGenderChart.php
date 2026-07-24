<?php

namespace App\Filament\Widgets;

use App\Models\Voter;
use Filament\Widgets\ChartWidget;

class VoterGenderChart extends ChartWidget
{
    protected static ?string $heading = 'Sebaran Pemilih Berdasarkan Jenis Kelamin';
    
    protected static ?int $sort = 2;
    
    protected static string $type = 'doughnut';

    protected function getData(): array
    {
        $maleCount = Voter::where('jenis_kelamin', 'L')->count();
        $femaleCount = Voter::where('jenis_kelamin', 'P')->count();

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
