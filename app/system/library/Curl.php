<?php


class Curl
{
    private $ch;
    private $result;
    private $json;
    /** @var string */
    private $httpCode;
    /** @var string  */
    private $url;
    /** @var string  */
    private $method;

    public function __construct($url = '', $method = 'GET')
    {
        $this->ch = $this->ch	= curl_init();
        $this->url = $url;
        $this->method = $method;
    }

    public function query($url = '', $method = '') {
        $refer = php_sapi_name() === 'cli' ? '127.0.0.1' : $_SERVER['HTTP_HOST'];
        $url = $url ?: $this->url;
        $method = $method ?: $this->method;
        curl_setopt($this->ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($this->ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($this->ch, CURLOPT_URL, $url);
        curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($this->ch, CURLOPT_NOBODY, false);
        curl_setopt($this->ch, CURLOPT_REFERER, $refer);
        curl_setopt($this->ch, CURLOPT_CUSTOMREQUEST, $method);

        $this->result	= curl_exec($this->ch);
        $this->json = json_decode($this->result, true);

        $this->httpCode = curl_getinfo($this->ch, CURLINFO_HTTP_CODE);

        return $this;
    }

    public function close() {
        curl_close($this->ch);
    }

    public function __destruct()
    {
       $this->close();
    }

    /**
     * @return mixed
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     * @return mixed
     */
    public function getJson()
    {
        return $this->json;
    }

    /**
     * @return mixed
     */
    public function getHttpCode()
    {
        return $this->httpCode;
    }
}
