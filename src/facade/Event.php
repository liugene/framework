<?php

use framework\facade\Facade;
use linkphp\event\Event as EventReal;


/**
 * Class EventReal
 * @package linkphp\di\InstanceDefinition
 * @method EventReal bind(string $definition) static 绑定
 *
 */

class Event extends Facade
{

    /**
     * @return mixed;
     */
    public static function getApplicationName()
    {
        return 'linkphp\\event\\Event';
    }

}