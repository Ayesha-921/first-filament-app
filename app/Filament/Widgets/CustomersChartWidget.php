<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;

class CustomersChartWidget extends ChartWidget
{
    protected ?string $heading = 'Total customers';

    protected static ?int $sort = 4;

    protected int | string | array $columnSpan = 1;

    protected function getData(): array
    {
        return [
            'datasets' => [
                [
                    'label' => 'Customers',
                    'data' => [4200, 5000, 5800, 6500, 7200, 8000, 9000, 10000, 11500, 13000, 15000, 17500],
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
