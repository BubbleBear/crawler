<?php

namespace Vatel;

class HttpRequester
{
    private $ch;
    
    private $opts;
    
    private $host;
    private $port;
    private $scheme;
    
    public function __construct()
    {
        $this->boot();
    }

    public function doGetRequest($url, $referer = '')
    {
        curl_setopt($this->ch, CURLOPT_URL, $url);
        $res = curl_exec($this->ch);
        return $res;
    }
    
    public function doPostRequest()
    {
        ;
    }

    public function setUpHeaders(array $params = array())
    {
        $httpheader = array(
            'Connection:keep-alive',
            'User-Agent:Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36',
        );

        $this->opts[CURLOPT_HTTPHEADER] = array_merge($httpheader, $params);
    }

    protected function boot()
    {
        $this->ch = curl_init();

        $this->setUpHeaders();
        
        $this->opts[CURLOPT_HEADER] = true;
        $this->opts[CURLOPT_RETURNTRANSFER] = true;
        $this->opts[CURLOPT_SSL_VERIFYPEER] = false;
        $this->opts[CURLOPT_FOLLOWLOCATION] = true;
        $this->opts[CURLOPT_AUTOREFERER] = true;

        // kill slow http connections
        $this->opts[CURLOPT_LOW_SPEED_LIMIT] = 10 * 1024;
        $this->opts[CURLOPT_LOW_SPEED_TIME] = 5;

        $this->opts[CURLOPT_CONNECTTIMEOUT] = 10;
        $this->opts[CURLOPT_TIMEOUT] = 30;

        curl_setopt_array($this->ch, $this->opts);
    }

    // todo
    protected function handleSSL()
    {
    }

    // todo
    protected function getScheme()
    {
        $scheme = strstr($test, '://', true);

        $this->scheme = $scheme;
    }
}
