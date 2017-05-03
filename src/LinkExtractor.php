<?php

namespace Vatel;

class LinkExtractor
{
    private $context;

    private $links = array();

    public function extractLinks($url, $context)
    {
        $this->context = $context;

        $pattern = '/"([a-z]+:\/)?\/[\w\.\/]+"/';

        $tmp = array();

        preg_match_all($pattern, $this->context, $tmp);

        $this->links = array_unique($tmp[0]);

        foreach ($this->links as &$link) {
            $link = trim($link, '"');
        }

        $this->derelativeLinks($url);

        return $this->links;
    }

    protected function derelativeLinks($url)
    {
        $matches = array();
        preg_match('/([a-z]+:\/\/)?[\w\.]+\/?/', $url, $matches);
        $baseUrl = $matches[0];

        foreach ($this->links as &$link) {
            if (!strpos($link, '://')) {
                $link = rtrim($baseUrl, '/') . $link;
            }
        }
    }
}
