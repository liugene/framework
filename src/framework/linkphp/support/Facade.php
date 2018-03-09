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
    public static function getApplicationName()
    {
        throw new Exception('该方法未继承');
    }

    public function getApplicationInstance()
    {
        return Application::get(static::getApplicationName());
    }

    /**
     * 获取示例
     * @return static
     */
    public function instance()
    {
        return static::getApplicationInstance();
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
        $instance = static::instance();
        return $instance->$method($params);
    }

    public function __call($name, array $arguments)
    {
        $instance = static::instance();
        return $instance->$name($arguments);
    }
}
