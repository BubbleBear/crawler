<?php

class HttpRequest
{
    private $ch;

    private $url;

    private $host;
    private $port;
    private $scheme;

    public function __construct($url) {
        $this->url = $url;
        $this->bootstrap();
    }

    public function setGetRequest() {
        ;
    }

    public function setPostRequest() {
        ;
    }

    protected function bootstrap() {
        $this->ch = curl_init();
        var_dump(curl_escape($this->ch, 'http://hahaha/阿斯蒂芬'));
    }
}

new HttpRequest('asdf');
