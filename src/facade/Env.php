<?php

use framework\facade\Facade;
use framework\Env as EnvReal;


/**
 * Class Env
 * @package framework
 * @method EnvReal get($name, $default = null) static 获取配置
 *
 */

class Env extends Facade
{

    /**
     * @return mixed;
     */
    protected static function getApplicationName()
    {
        return 'framework\\Env';
    }

}