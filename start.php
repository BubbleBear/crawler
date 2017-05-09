<?php

$c = include 'bootstrap.php';

$c['UrlMapSetDAO'] = function ($c) {
    return new \Vatel\DAO\UrlMapSetDAO($c);
};

// $c['Kernel']->crawl(array(
//     'http://www.hdu.edu.cn/',
// ));

$res = $c['HttpRequester']->doGetRequest('://baidu.com');

// file_put_contents('tmp.html', $res);

// $c['LinkExtractor']->extractLinks('baidu.com', $res);

var_dump($c['LinkExtractor']->extractLinks('baidu.com', $res));
