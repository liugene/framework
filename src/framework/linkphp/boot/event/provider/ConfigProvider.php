<?php

namespace linkphp\boot\event\provider;

use linkphp\boot\event\EventDefinition;
use linkphp\boot\event\EventServerProvider;
use linkphp\boot\Exception;
use linkphp\boot\Config;

class ConfigProvider implements  EventServerProvider
{
    public function update(EventDefinition $definition)
    {
        Config::set(
            Config::instance()
                ->setLoadPath(LOAD_PATH)
        )->import(require FRAMEWORK_PATH . 'configure.php');
        return $definition;
        // TODO: Implement update() method.
    }
}
