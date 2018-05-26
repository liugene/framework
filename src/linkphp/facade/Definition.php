<?php

use linkphp\facade\Facade;
use linkphp\di\Container;
use linkphp\di\InstanceDefinition;

/**
 * Class InstanceDefinition
 * @package linkphp\di\InstanceDefinition
 * @method Container bind(InstanceDefinition $definition) static 绑定
 *
 */

class Definition extends Facade
{

    /**
     * @return mixed;
     */
    public static function getApplicationName()
    {
        return 'linkphp\\di\\InstanceDefinition';
    }

}