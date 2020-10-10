<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once '../config.php';
require_once '../app/system/helper/functions.php';

require __DIR__.'/../vendor/autoload.php';

$app = new App\System\Library\App();
$app->run();
