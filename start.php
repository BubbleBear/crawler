<?php

$c = include phpversion(){0} == 7 ? 'bootstrap.php' : 'old_bootstrap.php';

$c['DEV'] = true;

$c['Scheduler']->crawl(array(
    'http://www.jd.com/',
));
