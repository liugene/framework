<?php

use linkphp\facade\Facade;
use linkphp\event\EventDefinition as EventDefinitionReal;


/**
 * Class EventDefinition
 * @package linkphp\event
 * @method EventDefinitionReal bind(string $definition) static 绑定
 *
 */

class EventDefinition extends Facade
{

    /**
     * @return mixed;
     */
    public static function getApplicationName()
    {
        return 'linkphp\\event\\EventDefinition';
    }

}