<?php

namespace Vatel;

class LinkExtractor
{
    private $context;

    private $links = array();

    public function extractLinks($url, $context)
    {
        $this->context = $context;

        $this->getTaggedLinks();

        $this->purifyLinks();

        $this->derelativeLinks($url);

        return $this->links;
    }

    protected function getTaggedLinks()
    {
        $pattern = '/<a\s.*?href\s*=\s*(\"[.#]+?\"|\'[.#]+?\'|[^\s]+?)(>|\s.*?>)(.*?)<[\/ ]?a>/';

        $matches = array();

        preg_match_all($pattern, $this->context, $matches);

        $this->links = $matches[0];
    }

    protected function purifyLinks()
    {
        foreach ($this->links as &$link) {
            $link = ltrim(substr($link, strpos($link, '=', strpos($link, 'href')) + 1), '\t\r\n \'\"\x0c');
            $link = rtrim(substr($link, 0, strpos($link, '"')), '\t\r\n \'\"\x0c');
        }

        $this->links = array_unique($this->links);
    }

    protected function derelativeLinks($url)
    {
        $matches = array();
        preg_match('/.+:\/\/.+/', $url, $matches);
        var_dump($matches);
        return;
        $baseUrl = $matches[0];

        foreach ($this->links as &$link) {
            if (!strpos($link, '://')) {
                $link = rtrim($baseUrl, '/') . $link;
            }
        }
    }

    protected function getRootUrl($url)
    {
        if ($pos = strpos($url, '//') !== false) {
            $url = substr($url, $pos + strlen('//'));
        }

        if ($pos = strpos($url, '/') !== false) {
            return substr($url, 0, $pos);
        } else {
            return $url;
        }
    }
}
