<?php

namespace Vatel;

class Scheduler
{
    private $container;

    private $queue = array();

    public function __construct($container)
    {
        $this->container = $container;

        !isset($this->container['DEV']) or $this->container['UrlMapSetDAO']->delete(array());
    }

    public function crawl(array $seeds)
    {
        $this->batchEnque($seeds);

        while ($url = $this->deque()) {
            var_dump($url);

            $document = $this->container['DynamicFetcher']->fetch($url);

            $this->archiveDocument($document, $url);

            $links = $this->container['LinkExtractor']->extractLinks($url, $document);
            $this->batchEnque($links);
        }
    }

    protected function archiveDocument($document, $url)
    {
        if (!empty($document)) {
            $documentName = md5($url);
            try {
                $this->container['UrlMapSetDAO']->update(
                    array(
                        'document_name' => $documentName,
                        'update_time' => time(),
                    ),
                    array('url' => $url)
                );

                file_put_contents("documents/ ". $documentName, $document);
            } catch (\Exception $e) {
                ;
            }
        } else {
            ;
        }
    }

    protected function batchEnque($targets)
    {
        foreach ($targets as $target) {
            $this->enque($target);
        }
    }

    protected function enque($target)
    {
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

    protected function deque()
    {
        return array_shift($this->queue) ?: false;
    }
}
