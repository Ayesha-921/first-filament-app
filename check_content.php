<?php
require 'vendor/autoload.php';
$ref = new ReflectionMethod(Filament\Resources\Pages\ViewRecord::class, 'content');
echo $ref->getFileName() . ':' . $ref->getStartLine() . '-' . $ref->getEndLine() . PHP_EOL;
$lines = file($ref->getFileName());
for ($i = $ref->getStartLine() - 1; $i < $ref->getEndLine(); $i++) {
    echo ($i + 1) . '| ' . $lines[$i];
}
