<?php

namespace App\System\Library;
/**
 * Base Controller
 * Class Controller
 */
class Controller
{
    /** @var Request */
    protected $request;
    /** @var Response */
    protected $response;

    public function __construct()
    {
        $this->request = new Request();
        $this->response = new Response();
    }

    /**
     * TODO: add template adapter
     * @param $view
     * @param  array  $data
     * @return false|string
     */
    public function view($view, $data = [])
    {
        if (!is_file(DIR_TEMPLATE.$view.'.php')) {
            dd("View $view does not exists");
        }

        return include(DIR_TEMPLATE.$view.'.php');
    }
}
