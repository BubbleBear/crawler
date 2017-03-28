<?php

class LinkExtractor
{
    private $context;

    private $links = array();

    public function __construct($context)
    {
        $this->context = $context;
    }

    public function writeToFile($path = 'tmp')
    {
        file_put_contents($path, $this->context);
    }

    public function extractLinks()
    {
        $pattern = '/[a-z]+:\/\/(\w+\.)+\w+(\/(\w|\.)+)*/';

        $tmp = array();

        preg_match_all($pattern, $this->context, $tmp);

        $this->links = $tmp[0];

        var_dump($this->links);
    }
}
