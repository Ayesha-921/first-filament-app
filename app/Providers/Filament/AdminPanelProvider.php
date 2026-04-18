<?php

namespace App\Providers\Filament;

use App\Filament\Widgets\CustomersChartWidget;
use App\Filament\Widgets\OrdersChartWidget;
use App\Filament\Widgets\RevenueStatsWidget;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use App\Filament\AvatarProviders\WhiteAvatarProvider;
use App\Filament\Pages\EditProfile;
use Filament\Navigation\NavigationGroup;
use Filament\Navigation\MenuItem;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets\AccountWidget;
use Filament\Widgets\FilamentInfoWidget;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\PreventRequestForgery;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()
            ->registration()
            ->databaseNotifications()
            ->brandName('Filament App')
            ->colors([
                'primary' => Color::Amber,
            ])
            ->darkMode(true)
            ->defaultAvatarProvider(WhiteAvatarProvider::class)
            ->renderHook(
                'panels::head.end',
                fn (): string => '<style>.fi-user-avatar[src^="data:"]{filter:invert(1)}.dark .fi-user-avatar[src^="data:"]{filter:none}</style>',
            )
            ->navigationGroups([
                NavigationGroup::make('Shop')->collapsible(),
                NavigationGroup::make('Blog')->collapsible(),
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\Filament\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\Filament\Pages')
            ->pages([
                Dashboard::class,
                EditProfile::class,
            ])
            ->userMenuItems([
                MenuItem::make()
                    ->label('Edit Profile')
                    ->url(fn (): string => EditProfile::getUrl())
                    ->icon('heroicon-o-user-circle')
                    ->sort(-1),
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\Filament\Widgets')
            ->widgets([
                AccountWidget::class,
                // FilamentInfoWidget::class,
                RevenueStatsWidget::class,
                OrdersChartWidget::class,
                CustomersChartWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                PreventRequestForgery::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
