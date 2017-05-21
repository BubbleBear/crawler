<?php

$c = include phpversion(){0} == 7 ? 'bootstrap.php' : 'old_bootstrap.php';

$url = 'http://www.baidu.com';

$d = $c['DynamicFetcher']->fetch($url);

$e = $c['LinkExtractor']->extractLinks($url, $d);

var_dump($e);
