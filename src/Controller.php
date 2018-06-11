<?php

namespace framework;

use linkphp\http\HttpRequest;

class Controller
{

    /**
     * @var \linkphp\http\HttpRequest Request 实例
     */
    protected $request;

    /**
     * @var array 前置操作方法列表
     */
    protected $beforeActionList = [];

    /**
     * 构造方法
     * @access public
     * @param \linkphp\http\HttpRequest $request Request 对象
     */
    public function __construct(HttpRequest $request)
    {
        $this->request = $request;

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

    public function view($template,$data=null)
    {
        return view($template,$data);
    }

    public function display($template)
    {
        return Application::get('linkphp\template\view')->display($template);
    }

    public function assign($name,$value=null)
    {
        return Application::get('linkphp\template\view')->assign($name,$value);
    }

    public function redirect(){}

}