<?php

namespace Vatel;

class LinkExtractor
{
    private $context;

    private $url;

    private $links = array();

    public function extractLinks($url, $context)
    {
        $this->context = $context;

        $this->url = $url;

        $this->getTaggedLinks();

        $this->purifyLinks();

        $this->derelativeLinks();

        $this->normalizeLinks();

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
            $link = ltrim(substr($link, strpos($link, '=', strpos($link, 'href')) + 1));
            $link = rtrim(substr($link, 1, strpos(substr($link, 1), $link[0])), " \t\n\r\0\x0B\'\"");
        }

        $this->links = array_filter($this->links, function ($link) {
            return !empty($link);
        });

        $this->links = array_unique($this->links);
    }

    protected function derelativeLinks()
    {
        $rel = preg_grep('/^(?!(\w*:?\/\/|\w+:))/', $this->links);

        $this->links = array_diff($this->links, $rel);

        foreach ($rel as &$link) {
            if ($link[0] == '/') {
                $link = $this->getRoot(1) . $link;
            } elseif ($link[0] == '.') {
                $link = $this->getRoot(0 - substr_count($link, '../')) . trim($link, './');
            } else {
                $link = $this->getRoot(0) . '/' . $link;
            }
        }

        $this->links = array_merge($this->links, $rel);
    }

    protected function getRoot($len = 0)
    {
        if (($pos = strpos($this->url, '//')) !== false) {
            $this->url = substr($this->url, $pos + 2);
        }

        $seg = explode('/', $this->url);

        if ($len <= 0) {
            $len += count($seg);
        }

        return implode('/', array_slice($seg, 0, $len));
    }

    protected function normalizeLinks()
    {
        foreach ($this->links as $key => &$link) {
            if (($pos = strpos($link, 'javascript:')) === 0) {
                array_splice($this->links, $key, 1);
            } elseif (($pos = strpos($link, '//')) === 0) {
                $link = 'http:' . $link;
            } elseif ($pos === 1) {
                $link = 'http' . $link;
            } elseif ($pos === false) {
                $link = 'http://' . $link;
            }
        }
    }
}
