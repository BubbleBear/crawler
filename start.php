<?php

include 'bootstrap.php';

// $hr = new HttpRequester('http://www.163.com');
$hr = new HttpRequester('https://www.baidu.com');
// $hr = new HttpRequester('test.com/test1.php');

$response = $hr->doGetRequest();

// var_dump($response);
$le = new LinkExtractor($response);
$le->extractLinks();
