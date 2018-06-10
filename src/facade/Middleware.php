<?php

use framework\facade\Facade;
use linkphp\middleware\Middleware as MiddlewareReal;


/**
 * Class Middleware
 * @package linkphp\middleware
 * @method MiddlewareReal add(string $event, $handle) static 添加中间件
 * @method MiddlewareReal beginMiddleware($middle=null) static 添加或者触发开始中间件
 * @method MiddlewareReal appMiddleware($middle=null) static 添加或者触发开始中间件
 * @method MiddlewareReal modelMiddleware($middle=null) static 添加或者触发开始中间件
 * @method MiddlewareReal controllerMiddleware($middle=null) static 添加或者触发开始中间件
 * @method MiddlewareReal actionMiddleware($middle=null) static 添加或者触发开始中间件
 * @method MiddlewareReal destructMiddleware($middle=null) static 添加或者触发开始中间件
 */

class Middleware extends Facade
{

    /**
     * @return mixed;
     */
    protected static function getApplicationName()
    {
        return 'linkphp\\middleware\\Middleware';
    }

}