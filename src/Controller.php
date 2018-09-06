<?php

namespace framework;

use linkphp\http\HttpRequest;
use linkphp\http\HttpResponse;
use linkphp\router\Router;
use linkphp\template\View;
use Config;

class Controller
{

    /**
     * @var \linkphp\http\HttpRequest Request 实例
     */
    protected $request;

    /**
     * @var \framework\Application Application 实例
     */
    protected $app;

    /**
     * @var \linkphp\router\Router Router 实例
     */
    protected $router;

    /**
     * @var \linkphp\template\View View 实例
     */
    protected $view;

    /**
     * @var array 前置操作方法列表
     */
    protected $beforeActionList = [];

    /**
     * 构造方法
     * @access public
     * @param \linkphp\http\HttpRequest $request Request 对象
     * @param \linkphp\router\Router $router Router 对象
     * @param \linkphp\template\View View 实例
     * @param \framework\Application Application 实例
     */
    public function __construct(HttpRequest $request, Router $router, View $view, Application $application)
    {
        $this->request = $request;

        $this->router = $router;

        $this->view = $view;

        $this->app = $application;

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

    /**
     * 操作错误跳转的快捷方法
     * @access protected
     * @param mixed  $msg    提示信息
     * @param string $url    跳转的 URL 地址
     * @param mixed  $data   返回的数据
     * @param int    $wait   跳转等待时间
     * @param array  $header 发送的 Header 信息
     * @return void
     */
    protected function error($msg = '', $url = null, $data = '', $wait = 3, array $header = [])
    {
        if (is_null($url)) {
            $url = $this->request->isAjax() ? '' : 'javascript:history.back(-1);';
        } elseif ('' !== $url && !strpos($url, '://') && 0 !== strpos($url, '/')) {
            $url = $this->request->scheme() . '://' . $this->request->host() . '/' . $url;
        }

        $type = $this->getResponseType();
        $result = [
            'code' => 0,
            'msg'  => $msg,
            'data' => $data,
            'url'  => $url,
            'wait' => $wait,
        ];

        if ('view' == strtolower($type)) {

            $this->assign('code', $result['code']);
            $this->assign('msg', $result['msg']);
            $this->assign('data', $result['data']);
            $this->assign('url', $result['url']);
            $this->assign('wait', $result['wait']);
            $result = $this->display(Config::get('dispatch_error_tmpl'));
        }

        HttpResponse::create($result, $type)->header($header)->send();
    }

    public function display($template)
    {
        return $this->view->display($template);
    }

    public function assign($name,$value=null)
    {
        $this->view->assign($name,$value);
    }

    public function redirect($url, $data = [])
    {
        if(!empty($data)){
            $url = $url . '?';
            foreach ($data as $k => $v){
                $url .= $k . '=' . $v . '&';
            }
        }

        HttpResponse::create('', 'view', '302')
            ->header("Location" , rtrim($url, '&'))->send();
    }

    /**
     * 获取当前的 response 输出类型
     * @access protected
     * @return string
     */
    protected function getResponseType()
    {
        return $this->request->isAjax()
            ? 'json'
            : Config::get('default_return_type');
    }

}