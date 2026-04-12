<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class RevenueStatsWidget extends BaseWidget
{
    protected static ?int $sort = 2;

    protected int | string | array $columnSpan = 'full';

    protected function getStats(): array
    {
        // Total revenue from all completed orders
        $totalRevenue = Order::where('payment_status', 'completed')
            ->sum('total') ?? 0;

        // Revenue this month
        $thisMonthRevenue = Order::where('payment_status', 'completed')
            ->whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->sum('total') ?? 0;

        // Revenue last month
        $lastMonthRevenue = Order::where('payment_status', 'completed')
            ->whereMonth('created_at', Carbon::now()->subMonth()->month)
            ->whereYear('created_at', Carbon::now()->subMonth()->year)
            ->sum('total') ?? 0;

        // Revenue change percentage
        $revenueChange = $lastMonthRevenue > 0
            ? round((($thisMonthRevenue - $lastMonthRevenue) / $lastMonthRevenue) * 100, 1)
            : 0;

        // Total customers (users)
        $totalCustomers = User::count();

        // New customers this month
        $newCustomersThisMonth = User::whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->count();

        // New customers last month
        $newCustomersLastMonth = User::whereMonth('created_at', Carbon::now()->subMonth()->month)
            ->whereYear('created_at', Carbon::now()->subMonth()->year)
            ->count();

        // Customer change percentage
        $customerChange = $newCustomersLastMonth > 0
            ? round((($newCustomersThisMonth - $newCustomersLastMonth) / $newCustomersLastMonth) * 100, 1)
            : 0;

        // Total orders
        $totalOrders = Order::count();

        // Orders this month
        $ordersThisMonth = Order::whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->count();

        // Orders last month
        $ordersLastMonth = Order::whereMonth('created_at', Carbon::now()->subMonth()->month)
            ->whereYear('created_at', Carbon::now()->subMonth()->year)
            ->count();

        // Orders change percentage
        $ordersChange = $ordersLastMonth > 0
            ? round((($ordersThisMonth - $ordersLastMonth) / $ordersLastMonth) * 100, 1)
            : 0;

        // Get monthly revenue data for chart (last 12 months) - SQLite compatible
        $startDate = Carbon::now()->subMonths(11)->startOfMonth();
        $monthlyRevenue = Order::where('payment_status', 'completed')
            ->where('created_at', '>=', $startDate)
            ->get()
            ->groupBy(function($item) {
                return $item->created_at->format('n');
            })
            ->map->sum('total')
            ->toArray();

        $revenueChart = [];
        for ($i = 0; $i < 12; $i++) {
            $month = Carbon::now()->subMonths(11 - $i)->month;
            $revenueChart[] = isset($monthlyRevenue[$month]) ? (int) $monthlyRevenue[$month] : 0;
        }

        // Get monthly customer data for chart - SQLite compatible
        $monthlyCustomers = User::where('created_at', '>=', $startDate)
            ->get()
            ->groupBy(function($item) {
                return $item->created_at->format('n');
            })
            ->map->count()
            ->toArray();

        $customerChart = [];
        for ($i = 0; $i < 12; $i++) {
            $month = Carbon::now()->subMonths(11 - $i)->month;
            $customerChart[] = $monthlyCustomers[$month] ?? 0;
        }

        // Get monthly order data for chart - SQLite compatible
        $monthlyOrders = Order::where('created_at', '>=', $startDate)
            ->get()
            ->groupBy(function($item) {
                return $item->created_at->format('n');
            })
            ->map->count()
            ->toArray();

        $ordersChart = [];
        for ($i = 0; $i < 12; $i++) {
            $month = Carbon::now()->subMonths(11 - $i)->month;
            $ordersChart[] = $monthlyOrders[$month] ?? 0;
        }

        return [
            Stat::make('Total Revenue', '$' . number_format($totalRevenue, 2))
                ->description($revenueChange >= 0 ? $revenueChange . '% increase this month' : abs($revenueChange) . '% decrease this month')
                ->descriptionIcon($revenueChange >= 0 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down')
                ->color($revenueChange >= 0 ? 'success' : 'danger')
                ->chart($revenueChart ?: [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]),

            Stat::make('Total Customers', number_format($totalCustomers))
                ->description($newCustomersThisMonth . ' new this month')
                ->descriptionIcon($customerChange >= 0 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down')
                ->color($customerChange >= 0 ? 'success' : 'danger')
                ->chart($customerChart ?: [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]),

            Stat::make('Total Orders', number_format($totalOrders))
                ->description($ordersThisMonth . ' orders this month')
                ->descriptionIcon($ordersChange >= 0 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down')
                ->color($ordersChange >= 0 ? 'success' : 'danger')
                ->chart($ordersChart ?: [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]),
        ];
    }
}
