<?php

include 'vendor/autoload.php';

return new class implements \ArrayAccess
{
    private $container;

    private $dirMap;

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
        $this->dirMap = json_decode(file_get_contents('composer.json'), true)['autoload']['psr-4'];
        
        $stack = array_map(function ($value) {
            return array(
                $value => 0,
            );
        }, array_keys($this->dirMap));

        while ($stack) {
            $cwd = array_pop($stack);

            $files = $this->scandir($cwd);

            foreach ($files as $key => $file) {
                if ($file == '.' || $file == '..' || $file == 'deprecated') {
                    continue;
                } elseif (is_dir($this->map($file))) {
                    array_push($stack, array(key($cwd) => $key + 1));
                    array_push($stack, array($file => 0));
                    break;
                } elseif ($sufpos = strpos($file, '.php')) {
                    $class = substr($file, 0, $sufpos);
                    $alias = substr($class, strrpos($class, '\\') + 1);
                    $this->container[$alias] = function ($c) use ($class) {
                        return new $class($c);
                    };
                }
            }
        }
    }

    private function scandir(array $cwd)
    {
        return array_map(function ($file) use ($cwd) {
            return rtrim(key($cwd), '\\') . '\\' . $file;
        }, array_filter(array_slice(scandir($this->map(key($cwd))), current($cwd), null, true), function ($file) {
            return ($file == '.' || $file == '..' || $file == 'deprecated') ? false : true;
        }));
    }

    private function map($namespace)
    {
        foreach ($this->dirMap as $virtual => $real) {
            if (strpos($namespace, $virtual) === 0) {
                return trim(str_replace($virtual, $real, $namespace), '/');
            }
        }
    }
};
