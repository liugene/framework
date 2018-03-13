<?php

namespace linkphp\interfaces;

interface ConfigInterface
{

    public static function set($name,$value,$type);

    public static function get($name, $value);

    public static function has($name);

}