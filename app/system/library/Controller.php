<?php

/**
 * Base Controller
 * Class Controller
 */
class Controller
{
    /**
     * @var Request
     */
    protected $request;

    public function __construct()
    {
        $this->request = new Request();
    }

    /**
     * @param  string  $model
     * @return mixed
     */
    public function model($model)
    {
        if (!is_file(DIR_MODEL.$model.'.php')) {
            dd("Model ".DIR_MODEL.$model.".php is not found");
        }

        require_once DIR_MODEL.$model.'.php';

        $result = new $model();
        return $result;
    }

    /**
     * @param  string  $view
     * @param $data
     */
    public function view($view, $data = [])
    {
        if (!is_file(DIR_TEMPLATE.$view.'.php')) {
            dd('View does not exists');
        }

        require_once DIR_TEMPLATE.$view.'.php';
    }
}
