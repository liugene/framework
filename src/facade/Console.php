<?php

use framework\facade\Facade;
use linkphp\console\Console as RealConsole;

/**
 * Class Console
 * @package link\console
 * @method RealConsole import(string $command) static 导入相关指令配置文件
 *
 */

class Console extends Facade
{

    /**
     * @return mixed;
     */
    public static function getApplicationName()
    {
        return 'linkphp\\console\\Console';
    }

}