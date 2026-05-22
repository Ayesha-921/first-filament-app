<?php
require 'vendor/autoload.php';
$ref = new ReflectionClass(Filament\Resources\Pages\ViewRecord::class);
foreach ($ref->getMethods() as $m) {
    $name = $m->getName();
    if ($name === 'render' || $name === 'content' || $name === 'getContent' || $name === 'hasInfolist' || $name === 'infolist') {
        echo $name . ' in ' . $m->getDeclaringClass()->getName() . PHP_EOL;
    }
}
