<?php
require 'vendor/autoload.php';
foreach ([Filament\Pages\BasePage::class, Filament\Resources\Pages\ViewRecord::class] as $cls) {
    if (method_exists($cls, 'render')) {
        $ref = new ReflectionMethod($cls, 'render');
        echo '=== ' . $cls . '::render ===' . PHP_EOL;
        echo $ref->getFileName() . ':' . $ref->getStartLine() . '-' . $ref->getEndLine() . PHP_EOL;
        $lines = file($ref->getFileName());
        for ($i = $ref->getStartLine() - 1; $i < $ref->getEndLine(); $i++) {
            echo ($i + 1) . '| ' . $lines[$i];
        }
        echo PHP_EOL;
    }
}
