<?php

use framework\facade\Facade;
use linkphp\di\Container;
use linkphp\di\InstanceDefinition;

/**
 * Class Container
 * @package linkphp\di\\Container
 * @method Container bind(InstanceDefinition $definition) static 绑定
 *
 */

class Component extends Facade
{

    /**
     * @return mixed;
     */
    public static function getApplicationName()
    {
        return 'linkphp\\di\\Container';
    }

}