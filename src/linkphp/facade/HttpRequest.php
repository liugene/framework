<?php

use linkphp\facade\Facade;
use linkphp\http\Restful;


/**
 * Class HttpRequest
 * @package linkphp\event
 * @method Restful bind(string $definition) static 绑定
 *
 */

class HttpRequest extends Facade
{

    /**
     * @return mixed;
     */
    public static function getApplicationName()
    {
        return 'linkphp\\http\\Restful';
    }

}