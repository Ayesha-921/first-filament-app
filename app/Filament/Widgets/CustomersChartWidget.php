<?php

namespace App\Filament\Widgets;

use App\Models\User;
use Filament\Widgets\ChartWidget;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class CustomersChartWidget extends ChartWidget
{
    protected ?string $heading = 'Total customers';

    protected static ?int $sort = 4;

    protected int | string | array $columnSpan = 1;

    protected function getData(): array
    {
        // Get monthly customer registration data for last 12 months (SQLite compatible)
        $startDate = Carbon::now()->subMonths(11)->startOfMonth();
        $monthlyCustomers = User::where('created_at', '>=', $startDate)
            ->get()
            ->groupBy(function($item) {
                return $item->created_at->format('n');
            })
            ->map->count()
            ->toArray();

        // Calculate cumulative totals
        $customerData = [];
        $labels = [];
        $cumulative = User::where('created_at', '<', $startDate)->count();

        for ($i = 0; $i < 12; $i++) {
            $month = Carbon::now()->subMonths(11 - $i);
            $labels[] = $month->format('M');
            $cumulative += $monthlyCustomers[$month->month] ?? 0;
            $customerData[] = $cumulative;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Total Customers',
                    'data' => $customerData,
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
