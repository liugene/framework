<?php

namespace link\db;

use linkphp\support\Facade;

class D extends Facade
{

    /**
     * @return Query;
     */
    public function getApplicationName()
    {
        return 'link\\db\\Query';
    }

}
