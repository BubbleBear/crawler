<?php

include 'vendor/autoload.php';

return new class implements \ArrayAccess
{
    private $container;

    public function __construct()
    {
        @dir('documents') or mkdir('documents');

        $this->container = new Pimple\Container();
        $this->container['config'] = include 'config.php';
        $this->container['root'] = __DIR__;

        $this->autoInjection();
    }

    public function offsetSet($offset, $value)
    {
        if (is_null($offset)) {
            return new \Exception('null is not available for offset');
        } else {
            $this->container[$offset] = $value;
        }
    }

    public function offsetGet($offset)
    {
        return $this->container[$offset];
    }

    public function offsetExists($offset)
    {
        return isset($this->container[$offset]);
    }

    public function offsetUnset($offset)
    {
        unset($this->container[$offset]);
    }

    private function autoInjection()
    {
        $dirMap = json_decode(file_get_contents('composer.json'), true)['autoload']['psr-4'];
        
        $stack = array_map(function ($value) {
            return array(
                $value => 0,
            );
        }, array_keys($dirMap));

        while ($stack) {
            $cwd = array_pop($stack);

            chdir(!current($cwd) && in_array(key($cwd), array_keys($dirMap)) ? $dirMap[key($cwd)] : '.');

            $signal = true;

            $files = array_slice(scandir('.'), current($cwd), NULL, true);

            foreach ($files as $key => $file) {
                if ($file == '.' || $file == '..' || $file == 'deprecated') {
                    continue;
                } elseif (is_dir($file)) {
                    array_push($stack, array(key($cwd) => $key + 1));
                    array_push($stack, array(key($cwd) . $file . '\\' => 0));
                    chdir($file);
                    $signal = false;
                    break;
                } elseif ($p = strpos($file, '.php')) {
                    $class = substr($file, 0, $p);
                    $this->container[$class] = function ($c) use ($cwd, $class) {
                        $class = '\\' . key($cwd) . $class;
                        return new $class($c);
                    };
                }
            }

            $signal ? chdir('..') : null;
        }
    }
};
