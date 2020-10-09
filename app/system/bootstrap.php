<?php

require_once  'helper/functions.php';

spl_autoload_register(function ($className){
    require_once DIR_LIBRARY.$className.'.php';
});

