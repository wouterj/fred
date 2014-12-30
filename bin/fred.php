<?php

require_once __DIR__.'/../vendor/autoload.php';

error_reporting(E_ALL ^ E_USER_DEPRECATED);

$app = new WouterJ\Fred\Extension\Console\Application();

$app->run();
