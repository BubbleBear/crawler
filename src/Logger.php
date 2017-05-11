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
        file_put_contents($this->container['root'] . '/data/log/error.log', $this->prepare($message), FILE_APPEND | LOCK_EX);
    }

    protected function prepare($message)
    {
        $log = time() . ' : ' . var_export(array(
            'message' => $message,
        ), true);
    }
}
