<?php

// +----------------------------------------------------------------------
// | LinkPHP [ Link All Thing ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016-2017 http://linkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liugene <liujun2199@vip.qq.com>
// +----------------------------------------------------------------------
// |               配置类
// +----------------------------------------------------------------------

namespace linkphp\boot;
use linkphp\Application;

class Environment
{

    static private $_instance;

    static private $init = false;

    static public function instance()
    {
        if(!isset(self::$_instance)){
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    //操作相应模式
    public function selectEnvModel($_env_object)
    {
        return $this;
    }

    public function requestRouterHandle()
    {
        /**
         * 设置应用启动中间件并监听执行
         */
        Application::hook('appMiddleware');
        Application::get('envmodel')
            ->init()
            ->run(
            Application::router()
                ->import(require LOAD_PATH . 'route.php')
                ->set(
                    Application::router()
                        ->setUrlModel('1')
                        ->setPath(
                            Application::input('server.PATH_INFO')
                        )
                        ->setDefaultPlatform('main')
                        ->setDefaultController('Home')
                        ->setDefaultAction('main')
                        ->setVarPlatform('m')
                        ->setVarController('c')
                        ->setVarAction('a')
                        ->setRouterOn('true')
                        ->setGetParam(Application::input('get.'))
                        ->setPlatform('')
                        ->setController('')
                        ->setAction('')
                        ->setDir(APPLICATION_PATH)
                        ->setNamespace(APP_NAMESPACE_NAME)
                )
                ->parser()
                ->dispatch()
        );
        return $this;
    }

    static public function requestCmdHandle()
    {
        if(!self::$init){
            self::$init = true;
            Application::httpRequest()
                ->setCmdParam(
                    Application::input('server.argv')
                );
            Application::get('envmodel')->set(
                Application::make(\linkphp\console\Console::class)
                    ->import(require LOAD_PATH . 'command.php')
            )->init();
        }
    }

}