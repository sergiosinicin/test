<?php

class App
{
    /**
     * default controller
     * @var $controller
     * @param 'MainController'
     */
    protected $controller = 'PropertyController';

    /**
     * default method
     * @var $method
     * @param 'index'
     */

    protected $method = 'index';

    /**
     * parameter
     * @var $params
     * @param [array]
     */

    protected $params = [];

    /**
     * constructor
     *
     */
    public function __construct()
    {
        $url = $this->parseURL();

        /**
         * $this->controller
         *
         */
        if (file_exists(DIR_CONTROLLER.ucwords($url[0]) . '.php')) {
            $this->controller = ucwords($url[0]);
            unset($url[0]);
        }else{
            dd(DIR_CONTROLLER.ucwords($url[0]) . '.php not found');
        }

        /**
         * Require Controller
         *
         */

        require_once DIR_CONTROLLER.$this->controller.'.php';
        $this->controller = new $this->controller;

        /**
         * $this->method
         *
         */
        if (isset($url[1])) {
            if (method_exists($this->controller, $url[1])) {
                $this->method = $url[1];
                unset($url[1]);
            }
        }

        /**
         * check $url
         */

        if (!empty($url)) {
            $this->params = array_values($url);
        }
    }

    /**
     *
     * function for parse url
     */

    public function parseURL()
    {
        if (isset($_GET['url']))
        {
            $url 	= explode('/', filter_var(trim($_GET['url']), FILTER_SANITIZE_URL));
            $url[0] = $url[0] . 'Controller';
        }else{
            $url[0] = $this->controller;
        }

        return $url;
    }

    /**
     * call route
     *
     * @return  $this->controller
     * @return  $this->method
     * @return  $this->params
     */

    public function run()
    {
        return call_user_func_array([$this->controller, $this->method], $this->params);
    }
}
