<?php

namespace linkphp;
use Closure;

abstract class Kernel
{

    protected $_app;

    protected $data;

    public function __construct(Application $application)
    {
        $this->_app = $application;
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

    abstract public function complete();

}