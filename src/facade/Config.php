<?php

use framework\facade\Facade;
use linkphp\config\Config as ConfigReal;


/**
 * Class Config
 * @package linkphp\di\InstanceDefinition
 * @method ConfigReal get(string $definition) static 获取配置
 *
 */

class Config extends Facade
{

    /**
     * @return mixed;
     */
    protected static function getApplicationName()
    {
        return 'linkphp\\config\\Config';
    }

}