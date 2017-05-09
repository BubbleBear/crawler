<?php

$c = include 'bootstrap.php';

$c['UrlMapSetDAO'] = function ($c) {
    return new \Vatel\DAO\UrlMapSetDAO($c);
};

// $c['Kernel']->crawl(array(
//     'http://www.hdu.edu.cn/',
// ));

$res = $c['HttpRequester']->doGetRequest('edusoho.com');

// file_put_contents('tmp.html', $res);

$links = $c['LinkExtractor']->extractLinks('http://news.cctv.com/2017/05/08/ARTIKNLkg8H28qj3RhKaXsB2170508.shtml', $res);

var_dump($links);
