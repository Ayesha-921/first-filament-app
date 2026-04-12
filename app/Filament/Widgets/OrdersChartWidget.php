<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use Filament\Widgets\ChartWidget;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class OrdersChartWidget extends ChartWidget
{
    protected ?string $heading = 'Orders per month';

    protected static ?int $sort = 3;

    protected int | string | array $columnSpan = 1;

    protected function getData(): array
    {
        // Get monthly order data for last 12 months (SQLite compatible)
        $startDate = Carbon::now()->subMonths(11)->startOfMonth();
        $monthlyOrders = Order::where('created_at', '>=', $startDate)
            ->get()
            ->groupBy(function($item) {
                return $item->created_at->format('n'); // Get month number without leading zero
            })
            ->map->count()
            ->toArray();

        $ordersData = [];
        $labels = [];

        for ($i = 0; $i < 12; $i++) {
            $month = Carbon::now()->subMonths(11 - $i);
            $labels[] = $month->format('M');
            $ordersData[] = $monthlyOrders[$month->month] ?? 0;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Orders',
                    'data' => $ordersData,
                    'borderColor' => '#FF9900',
                    'backgroundColor' => 'rgba(255, 153, 0, 0.1)',
                    'fill' => true,
                    'tension' => 0.4,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
