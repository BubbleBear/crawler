<?php

include 'vendor/autoload.php';

$c = new Pimple\Container();
$c['config'] = include 'config.php';
$c['root'] = __DIR__;

@dir('documents') or mkdir('documents');

$classNames = scandir('src');

foreach ($classNames as $className) {
    if ($p = strpos($className, '.php')) {
        $className = substr($className, 0, $p);
    }
    $c[$className] = function ($c) use ($className) {
        $className = '\\Vatel\\' . $className;
        return new $className($c);
    };
}

return $c;
