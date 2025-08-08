<?php

namespace App\Livewire\Dashboard;

use Filament\Widgets\ChartWidget;

class barchart extends ChartWidget
{
    // protected static ?string $heading = 'LEAVE';
    protected static string $color = 'warning';

    protected static ?string $pollingInterval = null;

    protected function getData(): array
    {
               return [
            'datasets' => [
                [

                    'data' => [13, 10, 5, 2, 21],
                    // 'backgroundColor'=> ["#4ade80", "#facc15", "#38bdf8", "#e879f9",'#f87171'],
                    'backgroundColor' => ["#4ade80", "#facc15", "#38bdf8", "#e879f9", '#f87171', '#ff69b4', '#33cc33'],
                    'borderColor' => '#0001',

                'borderRadius' => 8,
                'barPercentage'=>.9,
                'inflateAmount'=>1
                ],

            ],
            'labels' => ['Sick Leave(13)', 'Vacation Leave(10)', 'Force Leave(5)', 'SPL', 'CTO'],
        ];


    }
    protected static ?array $options = [
        'plugins' => [
            'legend' => [
                'display' => false,
            ],

        ],
        'chart' => [
            'borderRadius' => 10,
            'borderColor'=>'red'
        ],
    ];
    protected function getType(): string
    {
        return 'bar';
    }
}


