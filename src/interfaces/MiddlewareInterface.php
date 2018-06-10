<?php

namespace framework\interfaces;

interface MiddlewareInterface
{

    public function beginMiddleware();

    public function appMiddleware();

    public function modelMiddleware();

    public function controllerMiddleware();

    public function actionMiddleware();

    public function destructMiddleware();

}
