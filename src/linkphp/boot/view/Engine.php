<?php

namespace linkphp\boot\view;

abstract class Engine
{

    abstract public function display($template);

    abstract public function assign($name,$value=null);

}
