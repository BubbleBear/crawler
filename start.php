<?php

include 'bootstrap.php';

$config = include 'config.php';

$dsn = $config['db']['driver'] . ':' . __DIR__ . $config['db']['filepath'];

$dao = new Dao($dsn);
