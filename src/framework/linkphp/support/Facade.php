<?php

namespace linkphp\support;

use linkphp\Application;
use linkphp\boot\Exception;

class Facade
{
    /**
     * @var null|static 实例对象
     */
    protected static $instance = null;

    /**
     * @throw Exception
     * @return mixed
     */
    public function getApplicationName()
    {
        throw new Exception('该方法未继承');
    }

    public function getApplicationInstance()
    {
        self::$instance =  Application::get($this->getApplicationName());
    }

    /**
     * 获取示例
     * @return static
     */
    public function instance()
    {
        return self::$instance;
    }

    /**
     * 静态调用
     * @param string $method 调用方法
     * @param array  $params 调用参数
     * @return mixed
     * @throws Exception
     */
    public static function __callStatic($method, array $params)
    {
        if (is_null(self::$instance)) self::$instance = new self();

        return call_user_func_array([self::instance(), $method], $params);
    }

    public function __call($name, $arguments)
    {
        if (is_null(self::$instance)) self::$instance = new self();

        return call_user_func_array([self::$instance, $name], $arguments);
    }
}
