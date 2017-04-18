<?php

class LinkExtractor
{
    private $context;

    private $links = array();

    public function __construct($context)
    {
        $this->context = $context;
    }

    public function writeToFile($path = '/documents/tmp.txt')
    {
        file_put_contents($path, $this->context);
    }

    public function extractLinks()
    {
        $pattern = '/"[a-z]+:\/\/[\w\.\/]+"/';

        $tmp = array();

        preg_match_all($pattern, $this->context, $tmp);

        $links = $tmp[0];

        foreach ($links as $k => $v) {
            $links[$k] = trim($v, '"');
        }

        $this->links = $links;
    }
}
