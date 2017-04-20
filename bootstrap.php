<?php

include 'vendor/autoload.php';

use Vatel\HttpRequester;
use Vatel\LinkExtractor;
use Vatel\Kernel;
use Vatel\DBConnection;
use Vatel\ConfigHandler;

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
