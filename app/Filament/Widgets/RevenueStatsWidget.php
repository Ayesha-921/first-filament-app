<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class RevenueStatsWidget extends BaseWidget
{
    protected static ?int $sort = 2;

    protected int | string | array $columnSpan = 'full';
    protected function getStats(): array
    {
        return [
            Stat::make('Revenue', '$192.1k')
                ->description('32k increase')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success')
                ->chart([4000, 5000, 4500, 6000, 5500, 7000, 6500, 8000, 7500, 9000, 8500, 10000]),

            Stat::make('New customers', '1340')
                ->description('3% decrease')
                ->descriptionIcon('heroicon-m-arrow-trending-down')
                ->color('danger')
                ->chart([1800, 1700, 1600, 1750, 1500, 1400, 1450, 1350, 1300, 1250, 1340, 1280]),

            Stat::make('New orders', '3543')
                ->description('7% increase')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success')
                ->chart([2000, 2200, 2500, 2800, 2600, 3000, 2900, 3200, 3100, 3400, 3300, 3543]),
        ];
    }
}
