<?php

use framework\facade\Facade;
use linkphp\session\Session as SessionReal;


/**
 * Class Session
 * @package linkphp\session
 * @method SessionReal get($name = '', $prefix = null) static 获取session数据
 * @method SessionReal set($name, $value = '', $prefix = null) static 设置session
 * @method SessionReal delete($name = '', $prefix = null) static 设置session
 * @method SessionReal clear($prefix = null) static 设置session
 * @method SessionReal has($name, $prefix = null) static 设置session
 */

class Session extends Facade
{

    /**
     * @return mixed;
     */
    protected static function getApplicationName()
    {
        return 'linkphp\\session\\Session';
    }

}