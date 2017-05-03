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

        while ($url = array_shift($this->queue)) {
            $document = $this->container['HttpRequester']->doGetRequest($url);

            if (empty($document)) {
                var_dump($url);
                continue;
            }

            file_put_contents('documents/' . md5($url), $document);
            $links = $this->container['LinkExtractor']->extractLinks($url, $document);
            foreach ($links as $link) {
                array_push($this->queue, $link);
            }
        }
    }
}
