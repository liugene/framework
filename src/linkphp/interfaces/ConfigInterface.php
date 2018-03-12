<?php

namespace linkphp\interfaces;

interface ConfigInterface
{

    public static function set($name);

    public static function get($name, $value);

    public static function has($name);

}