<?php

use framework\facade\Facade;
use linkphp\router\Router as RouterReal;


/**
 * Class Router
 * @package linkphp\router
 * @method RouterReal rule($rule, $route='', $type = '*', $option = [], $pattern = []) static 注册路由
 * @method RouterReal get($rule, $route='', $option = [], $pattern = []) static 注册get路由
 * @method RouterReal post($rule, $route='', $option = [], $pattern = []) static 注册post路由
 * @method RouterReal delete($rule, $route='', $option = [], $pattern = []) static 注册post路由
 * @method RouterReal put($rule, $route='', $option = [], $pattern = []) static 注册post路由
 * @method RouterReal patch($rule, $route='', $option = [], $pattern = []) static 注册post路由
 * @method RouterReal alias($rule, $route='', $option = [], $pattern = []) static 注册post路由
 */

class Router extends Facade
{

    /**
     * @return mixed;
     */
    protected static function getApplicationName()
    {
        return 'linkphp\\router\\Router';
    }

}