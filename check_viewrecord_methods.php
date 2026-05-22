<?php
require 'vendor/autoload.php';
$ref = new ReflectionClass(Filament\Resources\Pages\ViewRecord::class);
foreach ($ref->getMethods() as $m) {
    $name = $m->getName();
    if (strpos($name, 'Form') !== false || strpos($name, 'form') !== false || $name === 'hasInfolist' || $name === 'getInfolist') {
        echo $name . ' in ' . $m->getDeclaringClass()->getName() . PHP_EOL;
    }
}
