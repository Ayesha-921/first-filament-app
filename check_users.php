<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;

echo "Total users in database: " . User::count() . "\n\n";

if (User::count() > 0) {
    echo "Users list:\n";
    echo str_repeat("=", 80) . "\n";
    User::all()->each(function($u) {
        printf("ID: %d | Name: %s | Email: %s | API Key: %s\n",
            $u->id,
            $u->name ?? 'N/A',
            $u->email,
            $u->api_key ? substr($u->api_key, 0, 20) . '...' : 'NULL'
        );
    });
} else {
    echo "No users found. You need to register a user first.\n";
}
