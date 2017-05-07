<?php

$c = include 'bootstrap.php';

$c['UrlMapSetDAO'] = function ($c) {
    return new \Vatel\DAO\UrlMapSetDAO($c);
};

$c['Kernel']->crawl(array(
    'http://www.hdu.edu.cn/',
));

// $res = $c['HttpRequester']->doGetRequest('edusoho.com');

// file_put_contents('tmp.html', $res);

// var_dump(($c['LinkExtractor'])->extractLinks('edusoho.com', $res));
