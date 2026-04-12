<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Check if column exists
$hasColumn = Illuminate\Support\Facades\Schema::hasColumn('users', 'api_key');
echo "api_key column exists: " . ($hasColumn ? "YES" : "NO") . "\n\n";

if ($hasColumn) {
    // Show users with api_key
    $users = DB::table('users')->select('id', 'name', 'email', 'api_key')->limit(5)->get();
    echo "Users:\n";
    echo str_repeat("-", 80) . "\n";
    foreach ($users as $user) {
        printf("ID: %d | Name: %s | Email: %s | API Key: %s\n",
            $user->id,
            $user->name,
            $user->email,
            $user->api_key ?? 'NULL'
        );
    }
}
