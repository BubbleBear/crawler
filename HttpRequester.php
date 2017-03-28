<?php

class HttpRequester
{
    private $ch;
    
    private $url;

    private $opts;
    
    private $host;
    private $port;
    private $scheme;
    
    public function __construct($url)
    {
        $this->url = $url;
        $this->bootstrap();
    }
    
    public function doGetRequest()
    {
        $res = curl_exec($this->ch);
        return $res;
    }
    
    public function doPostRequest()
    {
        ;
    }

    public function test()
    {
        return curl_getinfo($this->ch);
    }
    
    protected function bootstrap()
    {
        $this->ch = curl_init($this->url);

        $this->setUpHeaders();
        
        $this->opts[CURLOPT_HEADER] = true;
        $this->opts[CURLOPT_RETURNTRANSFER] = true;
        $this->opts[CURLOPT_CONNECTTIMEOUT] = 10;

        curl_setopt_array($this->ch, $this->opts);
    }

    protected function setUpHeaders()
    {
        $this->opts[CURLOPT_HTTPHEADER] = array(
            'User-Agent: Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36',
        );
    }
}
