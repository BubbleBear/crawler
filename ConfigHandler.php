<?php

class ConfigHandler
{
    private $config;

    private $DBConfig;

    public function __construct($config)
    {
        $this->config = $config;
        $this->boot();
    }

    public function getDsn()
    {
        $driver = $this->DBConfig['driver'];

        $dsn = $driver . ':';

        if ($driver == 'sqlite') {
            $dsn .= $this->DBConfig['filepath'];
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
