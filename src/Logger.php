<?php

namespace Vatel;

class Logger
{
    protected $container;

    public function __construct($container)
    {
        $this->container = $container;
    }

    public function record($message)
    {
        file_put_contents($this->container['root'] . '/data/log/error.log', var_export($this->prepare($message), true), FILE_APPEND | LOCK_EX);
    }

    protected function prepare($message)
    {
        return array(
            'message' => $message,
            'time' => time(),
        );
    }
}
