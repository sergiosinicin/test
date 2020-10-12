<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

if (!is_file(__DIR__.'/../config.php')) {
    die('rename config.php.example to config.php');
}

require_once '../config.php';
require __DIR__.'/../vendor/autoload.php';
require_once '../app/system/helper/functions.php';

$app = new App\System\Library\App();
$app->run();
