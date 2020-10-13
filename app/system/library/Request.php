<?php

namespace App\System\Library;

/**
 * Class Request
 */
class Request
{
    private $get;
    private $post;
    private $files;

    public function __construct()
    {
        $this->get = $this->sanitize($_GET);
        $this->post = $this->sanitize($_POST);
        $this->files = $this->sanitize($_FILES);
    }

    /**
     * @param $key
     * @param  null  $default
     * @return mixed|null
     */
    public function get($key, $default = null)
    {
        return $this->get[$key] ?? $default;
    }

    /**
     * @return array|string
     */
    public function getAll()
    {
        return $this->get;
    }

    /**
     * @param $key
     * @param  null  $default
     * @return mixed|null
     */
    public function post($key, $default = null)
    {
        return $this->post[$key] ?? $default;
    }

    /**
     * @return array|string
     */
    public function postAll()
    {
        return $this->post;
    }

    /**
     * @param $key
     * @return mixed|null
     */
    public function files($key)
    {
        return $this->files[$key] ?? null;
    }

    /**
     * @param $data
     * @return array|string
     */
    private function sanitize($data)
    {
        if (is_array($data)) {
            foreach ($data as $key => $value) {
                unset($data[$key]);
                $key = $this->sanitize($key);
                $data[$key] = $this->sanitize($value);
            }
        } else {
            $data = trim(htmlspecialchars($data, ENT_COMPAT, 'UTF-8'));
        }

        return $data;
    }
}
