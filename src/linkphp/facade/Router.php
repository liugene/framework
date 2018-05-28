<?php

use linkphp\facade\Facade;
use linkphp\router\Router as RouterReal;


/**
 * Class Router
 * @package linkphp\router
 * @method RouterReal get(string $definition) static 获取配置
 *
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