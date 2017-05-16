<?php

namespace Vatel\Fetcher;

class DynamicFetcher
{
    public function __construct()
    {
        ;
    }

    public function fetch($url, $referer = '')
    {
        $cmd = "\"bin/phantomjs\" src/Scripts/automation.js {$url}";
            
        return `$cmd`;
    }
}
