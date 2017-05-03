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
        $this->batchEnque($seeds);

        while ($url = $this->deque()) {
            $document = $this->container['HttpRequester']->doGetRequest($url);

            if (!empty($document)) {
                $documentName = md5($url);
                if ($this->container['UrlMapSetDAO']->update(
                    array(
                        'document_name' => $documentName,
                        'update_time' => time(),
                    ),
                    array('url' => $url)
                )) {
                    file_put_contents($documentName, $document);
                }                
            } else {
                ;
            }

            $links = $this->container['LinkExtractor']->extractLinks($document);
            $this->batchEnque($links);
        }
    }

    protected function batchEnque($targets) {
        foreach ($targets as $target) {
            $this->enque($target);
        }
    }

    protected function enque($target) {
        if ($this->container['UrlMapSetDAO']->insert(array(
            'url' => $target,
            'create_time' => time(),
            'update_time' => time(),
        ))) {
            array_push($this->queue, $target);
            return true;
        } else {
            return false;
        }
    }

    protected function deque() {
        return array_shift($this->queue) ?: false;
    }
}
