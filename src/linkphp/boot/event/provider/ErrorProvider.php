<?php

namespace linkphp\boot\event\provider;

use linkphp\boot\event\EventDefinition;
use linkphp\boot\event\EventServerProvider;
use linkphp\boot\Error;

class ErrorProvider implements  EventServerProvider
{
    public function update(EventDefinition $definition)
    {
        //注册错误和异常处理机制
        Error::register(
            Error::instance()
                ->setErrorView(EXTRA_PATH . 'tpl/error.html')
                ->setDebug(true)
                ->setErrHandle('')
        )->complete();
        return $definition;
        // TODO: Implement update() method.
    }
}
