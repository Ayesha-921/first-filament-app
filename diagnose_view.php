<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

// Check view paths
$viewPaths = config('view.paths');
echo "=== View Paths ===\n";
foreach ($viewPaths as $path) {
    echo $path . "\n";
}

// Check which file Laravel resolves for our view
$viewName = 'filament.resources.ocr-task-resource.pages.task-show';
try {
    $resolvedPath = view($viewName)->getPath();
    echo "\n=== Resolved View Path ===\n";
    echo $resolvedPath . "\n";
    echo "File exists: " . (file_exists($resolvedPath) ? 'yes' : 'no') . "\n";
    echo "File modified: " . date('Y-m-d H:i:s', filemtime($resolvedPath)) . "\n";
    
    // Check for specific strings
    $content = file_get_contents($resolvedPath);
    echo "\n=== Content Checks ===\n";
    echo "Contains 'document-text' icon: " . (strpos($content, 'heroicon-o-document-text') !== false ? 'yes' : 'no') . "\n";
    echo "Contains 'bg-primary-50': " . (strpos($content, 'bg-primary-50') !== false ? 'yes' : 'no') . "\n";
    echo "Contains 'rounded-md': " . (strpos($content, 'rounded-md') !== false ? 'yes' : 'no') . "\n";
    echo "Contains 'OCR Submission': " . (strpos($content, 'OCR Submission') !== false ? 'yes' : 'no') . "\n";
} catch (Exception $e) {
    echo "Error resolving view: " . $e->getMessage() . "\n";
}

// Also check old view file
$oldViewName = 'filament.resources.ocr-task-resource.pages.view-ocr-task';
try {
    $oldPath = view($oldViewName)->getPath();
    echo "\n=== Old View Path ===\n";
    echo $oldPath . "\n";
    echo "Same as new: " . ($oldPath === $resolvedPath ? 'yes' : 'no') . "\n";
} catch (Exception $e) {
    echo "\nOld view error: " . $e->getMessage() . "\n";
}
