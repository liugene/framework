<?php

namespace linkphp\boot\event\provider;

use linkphp\boot\event\EventDefinition;
use linkphp\boot\event\EventServerProvider;
use link\db\D;
use linkphp\boot\Exception;

class DatabaseProvider implements  EventServerProvider
{
    public function update(EventDefinition $definition)
    {
        if(file_exists(LOAD_PATH . 'database.php')) {
            D::import(require_once LOAD_PATH . 'database.php');
        } else {
            throw new Exception('database config file not found');
        }
        return $definition;
        // TODO: Implement update() method.
    }
}
