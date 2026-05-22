<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\OcrTask;
$task = OcrTask::find(9);
if (!$task) {
    echo "Task 9 not found\n";
    exit;
}

// Simulate what ViewRecord does
$page = new class($task) extends \Filament\Resources\Pages\ViewRecord {
    protected static string $resource = \App\Filament\Resources\OcrTaskResource::class;
    public function __construct($record) {
        $this->record = $record;
    }
};

echo 'hasInfolist: ' . ($page->hasInfolist() ? 'true' : 'false') . PHP_EOL;
