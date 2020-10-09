<?php
require_once 'config.php';
require_once 'app/system/bootstrap.php';

$init = new App();

$property = new PropertyController();
$currentPage = $page = 1;
while ($page) {
    $currentPage = $page;
    echo 'request to upload page '.$page.PHP_EOL;
    $result = $property->populateDb($page);
    if(!isset($result['current_page']) || !isset($result['last_page'])) {
        var_dump($result);
        exit('Unknown response.Last uploaded page is '.$page);
    }

    echo 'Uploaded'.PHP_EOL;
    if($result['current_page'] < $result['last_page']) {
        $page = $page + 1;
    } else {
        exit('All pages is downloaded');
    }
}
