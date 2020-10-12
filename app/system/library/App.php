<?php

namespace App\System\Library;

use App\Controller;

class App
{
    /**
     * default controller
     * @param 'MainController'
     * @var $controller
     */
    protected $controller = 'PropertyController';

    /**
     * default method
     * @param 'index'
     * @var $method
     */

    protected $method = 'index';

    /**
     * parameter
     * @param [array]
     * @var $params
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
        if (class_exists('App\Controller\\'.ucwords($url[0]))) {
            $this->controller = 'App\Controller\\'.ucwords($url[0]);
            unset($url[0]);
        } else {
            dd(ucwords($url[0]).' not found');
        }

        /**
         * Require Controller
         *
         */

        // require_once DIR_CONTROLLER.$this->controller.'.php';
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
        if (isset($_GET['url'])) {
            $url = explode('/', filter_var(trim($_GET['url']), FILTER_SANITIZE_URL));
            $url[0] = $url[0].'Controller';
        } else {
            //TODO: redirect to controller
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
        /** @uses \App\Controller\PropertyController */
        return call_user_func_array([$this->controller, $this->method], $this->params);
    }
}
