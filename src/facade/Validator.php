<?php

use framework\facade\Facade;
use linkphp\validator\Validator as ValidatorReal;


/**
 * Class Validator
 * @package linkphp\validator
 * @method ValidatorReal data(string|array $data) static 设置需验证的数据
 * @method ValidatorReal withValidator($validator, $input = null, $param = null, $error_message = null) static 使用验证器
 * @method ValidatorReal check() static 验证数据
 * @method ValidatorReal getError() static 获取错误信息
 */

class Validator extends Facade
{

    /**
     * @return mixed;
     */
    protected static function getApplicationName()
    {
        return 'linkphp\\validator\\Validator';
    }

}