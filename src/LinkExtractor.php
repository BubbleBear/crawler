<?php

namespace Vatel;

class LinkExtractor
{
    private $context;

    private $links = array();

    public function extractLinks($url, $context)
    {
        $this->context = $context;

        $pattern = '/"((https?|ftp):\/\/)?(([^\.][\w\._]+\.[a-zA-Z]{2,6}|(\d{1,3}\.){3}\d{1,3})(:\d{1,4})?)?(\/[\w\&%\.\/-~]*)?"|
                    \'((https?|ftp):\/\/)?(([^\.][\w\._]+\.[a-zA-Z]{2,6}|(\d{1,3}\.){3}\d{1,3})(:\d{1,4})?)?(\/[\w\&%\.\/-~]*)?\'/';

        $tmp = array();

        preg_match_all($pattern, $this->context, $tmp);

        $this->links = array_unique($tmp[0]);

        foreach ($this->links as &$link) {
            $link = trim($link, '"\'');
        }

        $this->derelativeLinks($url);

        return $this->links;
    }

    protected function derelativeLinks($url)
    {
        $matches = array();
        preg_match('/[\w-\.]+\/?/', $url, $matches);
        $baseUrl = $matches[0];

        foreach ($this->links as &$link) {
            if (!strpos($link, '://')) {
                $link = rtrim($baseUrl, '/') . $link;
            }
        }
    }
}
