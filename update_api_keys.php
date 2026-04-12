<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Str;
use App\Models\User;

// Update all users without api_key
$users = User::whereNull('api_key')->get();
echo "Updating " . $users->count() . " users...\n";

foreach ($users as $user) {
    $user->api_key = Str::random(60);
    $user->save();
    echo "✓ User ID {$user->id} ({$user->email}) - API Key generated\n";
}

echo "\n=== Updated Users ===\n";
User::select('id', 'name', 'email', 'api_key')->limit(5)->get()->each(function($u) {
    printf("ID: %d | %s | %s | %s...\n", $u->id, $u->name, $u->email, substr($u->api_key, 0, 20));
});

echo "\nDone! All users now have API keys.\n";
