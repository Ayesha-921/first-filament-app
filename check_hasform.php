<?php
require 'vendor/autoload.php';
$ref = new ReflectionClass(Filament\Resources\Pages\ViewRecord::class);
foreach ($ref->getMethods() as $m) {
    $name = $m->getName();
    if ($name === 'hasForm' || $name === 'getFormContentComponent' || $name === 'getInfolistContentComponent') {
        echo $name . ' in ' . $m->getDeclaringClass()->getName() . PHP_EOL;
        $method = $ref->getMethod($name);
        $filename = $method->getFileName();
        $start = $method->getStartLine();
        $end = $method->getEndLine();
        $lines = file($filename);
        for ($i = $start - 1; $i < $end; $i++) {
            echo ($i + 1) . '| ' . $lines[$i];
        }
        echo "---\n";
    }
}
