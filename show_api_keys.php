<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;

echo "========================================\n";
echo "ALL USERS WITH API KEYS\n";
echo "========================================\n\n";

$users = User::all();

if ($users->isEmpty()) {
    echo "No users found.\n";
} else {
    foreach ($users as $user) {
        echo "ID:       {$user->id}\n";
        echo "Name:     {$user->name}\n";
        echo "Email:    {$user->email}\n";
        echo "API Key:  " . ($user->api_key ?? 'NULL') . "\n";
        echo str_repeat("-", 60) . "\n";
    }
}

echo "\nTotal users: " . $users->count() . "\n";
