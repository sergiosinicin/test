<?php


namespace App\System\Library;

/**
 * Class Response
 * @package App\System\Library
 */
class Response
{
    public function output($content)
    {
        echo $content;
    }

    public function jsonOutput($content)
    {
        header('Content-Type: application/json');
        echo json_encode($content);
    }
}
