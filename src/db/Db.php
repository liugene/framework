<?php

namespace link\db;

use linkphp\support\Facade;

class Db extends Facade
{

    /**
     * @return Query;
     */
    public static function getApplicationName()
    {
        return 'link\\db\\Query';
    }

}
