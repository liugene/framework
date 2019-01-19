<?php

use framework\facade\Facade;
use linkphp\http\HttpRequest as HttpRequestRel;


/**
 * Class HttpRequestRel
 * @package linkphp\http
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
        return 'linkphp\\http\\HttpRequest';
    }

}