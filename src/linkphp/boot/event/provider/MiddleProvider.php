<?php

namespace linkphp\boot\event\provider;

use linkphp\boot\event\EventDefinition;
use linkphp\boot\event\EventServerProvider;
use linkphp\boot\Exception;
use linkphp\Application;

class MiddleProvider implements  EventServerProvider
{
    public function update(EventDefinition $definition)
    {
        Application::get('linkphp\boot\Middleware')
            ->import(include LOAD_PATH . 'middleware.php')
            ->beginMiddleware();
        return $definition;
        // TODO: Implement update() method.
    }
}
