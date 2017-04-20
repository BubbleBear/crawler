<?php

include 'vendor/autoload.php';

$c = new Pimple\Container();
$c['config'] = include 'config.php';
$c['root'] = __DIR__;

@dir('documents') or mkdir('documents');

$classes = scandir('src');

foreach ($classes as $class) {
    if ($p = strpos($class, '.php')) {
        $class = substr($class, 0, $p);
    }
    $c[$class] = function ($c) use ($class) {
        $class = 'Vatel\\' . $class;
        return new $class($c);
    };
}

return $c;
