<?php

namespace framework;
use Closure;
use linkphp\http\HttpRequest;

abstract class Kernel
{

    protected $_app;

    protected $data;

    /**
     * @var HttpRequest
     */
    protected $_request;

    public function __construct(Application $application, HttpRequest $httpRequest)
    {
        $this->_app = $application;
        $this->_request = $httpRequest;
    }

    public function setData($data)
    {
        $this->data = $data;
    }

    public function getData()
    {
        return $this->data;
    }

    abstract public function use($config = null);

    public function then(Closure $closure)
    {
        call_user_func($closure);
        return $this;
    }

    public function daemon(Closure $closure)
    {
        call_user_func($closure);
        return $this;
    }

    abstract public function complete();

}