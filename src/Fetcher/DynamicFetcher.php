<?php

namespace Vatel\Fetcher;

class DynamicFetcher
{
    public function __construct()
    {
        ;
    }

    public function fetch($url, $waitTime = 2000, $referer = '')
    {
        $cmd = "\"bin/phantomjs\" \"src/Scripts/automation.js\" \"{$url}\" \"{$waitTime}\"";
            
        return `$cmd`;
    }
}
