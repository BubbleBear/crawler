<?php

namespace Vatel;

class ConfigHandler
{
    private $root;

    private $config;

    private $DBConfig;

    public function __construct($container)
    {
        $this->root = $container['root'];
        $this->config = $container['config'];
        $this->boot();
    }

    public function getDsn()
    {
        $driver = $this->DBConfig['driver'];

        $dsn = $driver . ':';

        if ($driver == 'sqlite') {
            $dsn .= $this->root . '/' . $this->DBConfig['filepath'];
        } else {
            throw new \Exception('driver ' . $driver . ' not supported.');
        }

        return $dsn;
    }

    protected function boot()
    {
        $this->DBConfig = $this->config['db'];
    }
}
