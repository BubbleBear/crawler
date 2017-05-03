<?php

$c = include 'bootstrap.php';

$c['UrlMapSetDAO'] = function ($c) {
    return new \Vatel\DAO\UrlMapSetDAO($c);
};

$c['Kernel']->crawl(array(
    'baidu.com',
));
