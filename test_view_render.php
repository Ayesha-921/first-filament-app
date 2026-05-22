<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$viewPath = resource_path('views/filament/resources/ocr-task-resource/pages/task-show.blade.php');
echo "View file exists: " . (file_exists($viewPath) ? 'yes' : 'no') . "\n";
echo "View file path: " . $viewPath . "\n";

$task = App\Models\OcrTask::find(9);
if (!$task) {
    echo "Task 9 not found\n";
    exit;
}

try {
    $html = view('filament.resources.ocr-task-resource.pages.task-show', ['record' => $task])->render();
    echo "View rendered successfully. Length: " . strlen($html) . "\n";
    echo "Contains document-text icon: " . (strpos($html, 'heroicon-o-document-text') !== false ? 'yes' : 'no') . "\n";
    echo "Contains bg-primary-50: " . (strpos($html, 'bg-primary-50') !== false ? 'yes' : 'no') . "\n";
    echo "Contains rounded-md: " . (strpos($html, 'rounded-md') !== false ? 'yes' : 'no') . "\n";
    echo "Contains 'OCR Submission': " . (strpos($html, 'OCR Submission') !== false ? 'yes' : 'no') . "\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
