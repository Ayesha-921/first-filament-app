<?php
require_once 'vendor/autoload.php';

$classes = [
    'Filament\Widgets\ThemeSwitcher',
    'Filament\Http\Middleware\SetUpPanel',
    'Filament\Support\Components\ThemeSwitcherWidget',
    'Filament\Livewire\GlobalSearch',
    'Filament\Livewire\DatabaseNotifications',
    'Filament\Livewire\Notifications',
    'Filament\Pages\Auth\Login',
];

foreach ($classes as $c) {
    echo (class_exists($c) ? 'OK' : 'NO') . ' ' . $c . PHP_EOL;
}

// Also search for ThemeSwitcher in loaded classes
$all = get_declared_classes();
foreach ($all as $c) {
    if (stripos($c, 'theme') !== false && stripos($c, 'filament') !== false) {
        echo 'FOUND: ' . $c . PHP_EOL;
    }
}
