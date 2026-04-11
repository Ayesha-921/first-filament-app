<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;

class OrdersChartWidget extends ChartWidget
{
    protected ?string $heading = 'Orders per month';

    protected static ?int $sort = 3;

    protected int | string | array $columnSpan = 1;

    protected function getData(): array
    {
        return [
            'datasets' => [
                [
                    'label' => 'Orders',
                    'data' => [2800, 3500, 3200, 4200, 5800, 6000, 6500, 8500, 8000, 9000, 8800, 9200],
                    'borderColor' => '#f59e0b',
                    'backgroundColor' => 'rgba(245, 158, 11, 0.1)',
                    'fill' => true,
                    'tension' => 0.4,
                ],
            ],
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
