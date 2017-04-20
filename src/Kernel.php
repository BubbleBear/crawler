<?php

namespace Vatel;

class Kernel
{
    private $container;

    private $queue = array();

    public function __construct($container)
    {
        $this->container = $container;
    }

    public function crawl(array $seeds)
    {
        $this->queue = array_merge($this->queue, $seeds);

        while ($target = array_shift($this->queue)) {
            $document = $this->container['HttpRequester']->doGetRequest($target);

            if (empty($document)) {
                var_dump($target);
                continue;
            }

            file_put_contents('documents/' . md5($target), $document);
            $links = $this->container['LinkExtractor']->extractLinks($target, $document);
            foreach ($links as $link) {
                array_push($this->queue, $link);
            }
        }
    }
}
