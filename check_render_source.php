<?php
require 'vendor/autoload.php';

$classes = [
    'Filament\Resources\Pages\ViewRecord',
    'Filament\Pages\BasePage',
];

foreach ($classes as $cls) {
    $ref = new ReflectionClass($cls);
    if ($ref->hasMethod('render')) {
        $m = $ref->getMethod('render');
        echo "=== $cls::render ===\n";
        echo $m->getFileName() . ':' . $m->getStartLine() . '-' . $m->getEndLine() . "\n";
        $lines = file($m->getFileName());
        for ($i = $m->getStartLine() - 1; $i < $m->getEndLine(); $i++) {
            echo ($i + 1) . '| ' . $lines[$i];
        }
        echo "\n";
    }
}
