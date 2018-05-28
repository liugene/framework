<?php

use linkphp\facade\Facade;
use linkphp\error\Error as ErrorReal;


/**
 * Class Error
 * @package linkphp\di\InstanceDefinition
 * @method ErrorReal get(string $definition) static 获取配置
 *
 */

class Error extends Facade
{

    /**
     * @return mixed;
     */
    protected static function getApplicationName()
    {
        return 'linkphp\\error\\Error';
    }

}