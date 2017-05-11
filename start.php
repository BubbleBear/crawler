<?php

$c = include phpversion(){0} == 7 ? 'bootstrap.php' : 'old_bootstrap.php';

$c['Kernel']->crawl(array(
    'http://www.jd.com/',
));
