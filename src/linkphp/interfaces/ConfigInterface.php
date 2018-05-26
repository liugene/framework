<?php

namespace linkphp\interfaces;

interface ConfigInterface
{

    public function set($name,$value,$type);

    public function get($name, $value);

    public function has($name);

}