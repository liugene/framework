<?php

namespace framework;

use Closure;
use linkphp\http\HttpRequest;
use Config;

abstract class Kernel
{

    protected $app;

    protected $data;

    /**
     * @var array 前置操作方法列表
     */
    protected $beforeActionList = [];

    /**
     * @var HttpRequest
     */
    protected $request;

    public function __construct(Application $application, HttpRequest $httpRequest)
    {
        $this->app = $application;
        $this->request = $httpRequest;

        // 控制器初始化
        $this->_initialize();

        // 前置操作方法
        if ($this->beforeActionList) {
            foreach ($this->beforeActionList as $method => $options) {
                $this->beforeAction($method);
            }
        }
    }

    /**
     * 初始化操作
     * @access protected
     */
    protected function _initialize()
    {
    }

    /**
     * 前置操作
     * @access protected
     * @param  string $method  前置操作方法名
     * @return void
     */
    protected function beforeAction($method)
    {
        call_user_func([$this, $method]);
    }


    public function setData($data)
    {
        $this->data = $data;
    }

    public function getData()
    {
        return $this->data;
    }

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

    public function beforeComplete()
    {
        $namespace = $this->app->router()->getNamespace();

        $platform = $this->app->router()->getPlatform();

        $controller = $this->app->router()->getController();

        $action = $this->app->router()->getAction();

        $class = $namespace . '\\' . $platform . '\\' . 'controller' . '\\' . $controller;

        $controllerHandle = $this->app->get($class);

        $type = $controllerHandle->getReturnType($action);

        if($type && in_array($type, ['view', 'json', 'console', 'xml', 'jsonp'])){

            $this->request->setRequestHttpAccept($type);
        } else {

            $this->request->setRequestHttpAccept(Config::get('configure.default_return_type'));
        }
    }

    abstract public function start($config = null);

    abstract public function complete();

}