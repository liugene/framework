<?php

namespace linkphp;

use linkphp\config\Config;
use linkphp\boot\Environment;
use linkphp\boot\Component;
use linkphp\boot\Definition;
use linkphp\di\InstanceDefinition;
use bootstrap\Loader;
use linkphp\http\HttpRequest;
use linkphp\Make;
use linkphp\router\router\Router;
use linkphp\event\Event;
use linkphp\event\EventDefinition;
use linkphp\db\Query;

class Application
{
    private $data;

    //保存是否已经初始化
    private static $_init;
    //links启动
    static public function run()
    {
        if(!isset(self::$_init)){
            self::event('system');
            //初次初始化执行
            self::$_init = new self();
        }
        return self::$_init;
    }

    public function check(Environment $env)
    {
        return $this;
    }

    public function request()
    {
        self::httpRequest()
            ->start();
        return $this;
    }

    public function response()
    {
        $this->setData(self::router()->getReturnData());
        Application::hook('destructMiddleware');
        self::httpRequest()
            ->setData($this->data)
            ->send();
    }

    public function setData($data)
    {
        $this->data = $data;
        return $this;
    }

    static public function getRequestMethod()
    {
        return self::httpRequest()->getRequestMethod();
    }

    /**
     * 获取环境实例
     * @param string $rule
     * @param string $tag
     * @return Router
     */
    static public function router($rule='',$tag='')
    {
        if($rule=='' || $tag=='') return self::get('run');
        return self::get('run')->rule($rule,$tag);
    }

    /**
     * 获取环境实例
     * @return Environment Object
     */
    static public function env()
    {
        return self::get('linkphp\boot\Environment');
    }

    /**
     * 获取HttpRequest类实例
     * @return HttpRequest Object
     */
    static public function httpRequest()
    {
        return self::get('linkphp\http\Restful')->request();
    }

    /**
     * 获取实例
     * @param string $alias
     * @return Object
     */
    static public function get($alias)
    {
        return Component::instance()->get($alias);
    }

    static public function bind(InstanceDefinition $definition)
    {
        return Component::instance()->bind($definition);
    }

    static public function singleton($alias,$callback)
    {
        return self::bind(
            Application::definition()
                ->setAlias($alias)
                ->setIsSingleton(true)
                ->setCallBack($callback)
        );
    }

    public static function singletonEager($alias,$callback)
    {
        return self::bind(
            Application::definition()
                ->setAlias($alias)
                ->setIsEager(true)
                ->setIsSingleton(true)
                ->setClassName($callback)
        );
    }

    public static function eager($alias,$callback)
    {
        return self::bind(
            Application::definition()
                ->setAlias($alias)
                ->setIsEager(true)
                ->setClassName($callback)
        );
    }

    /**
     * 获取实例
     * @return Definition
     */
    static public function definition()
    {
        return (new Definition());
    }

    static public function getContainerInstance()
    {
        return Component::instance()->getContainerInstance();
    }

    static public function input($param='',$filter='')
    {
        return self::httpRequest()->input($param,$filter);
    }

    static public function getInput($filter='')
    {
        return self::httpRequest()->getInput($filter);
    }

    static public function url($c=null,$a=null,$p=null)
    {
        return self::make()->url($c,$a,$p);
    }

    /**
     * 获取MAKE类实例
     * @return Make
     */
    static public function make()
    {
        return self::get('linkphp\boot\Make');
    }

    /**
     * 获取配置信息
     * @param string $key
     * @return Config
     */
    static public function config($key='')
    {
        return $key=='' ? self::get('linkphp\config\Config') : self::get('linkphp\config\Config')->get($key);
    }

    static public function middleware($middle,$middleware=null)
    {
        if(self::get('linkphp\middleware\Middleware')->isValidate($middle)){
            return self::get('linkphp\middleware\Middleware')->$middle($middleware);
        }
    }

    static public function hook($middle)
    {
        if(self::get('linkphp\middleware\Middleware')->isValidate($middle)){
            return self::get('linkphp\middleware\Middleware')->$middle();
        }
    }

    /**
     * 获取装载类实例
     * @return Loader Object
     */
    static public function Loader()
    {
        return Loader::instance();
    }

    /**
     * 获取事件类实例
     * @param string $server
     * @param string|array $events
     * @return mixed
     */
    static public function event($server='',$events='')
    {
        if($server == '') return Event::instance();
        if($events != ''){
            if(is_array($events)){
                $first = false;
                $instance = Event::instance();
                foreach($events as $event){
                    if($first){
                        $instance->getEventMap($server)
                            ->register(new $event);
                        continue;
                    }
                    $instance->provider(
                        self::eventDefinition()
                            ->setServer($server)
                            ->register(new $event)
                    );
                    $first=true;
                }
                return;
            } else {
                Event::instance()->provider(
                    self::eventDefinition()
                        ->setServer($server)
                        ->register(new $events)
                );
                return;
            }
        }
        return Event::instance()->target($server);
    }

    /**
     * 获取事件定义类实例
     * @return EventDefinition Object
     */
    static public function eventDefinition()
    {
        return new EventDefinition();
    }

    /**
     * @param mixed $template
     * @param array $data
     */
    public static function view($template,$data=[])
    {
        $view = self::get('linkphp\boot\View');
        $view->assign($data);
        $view->display($template);
    }

    public static function cache($key,$value=null)
    {
        if(is_null($value)) return self::get('linkphp\cache\Cache')->get($key);
        return self::get('linkphp\cache\Cache')->put($key,$value);
    }

    /**
     * 获取DB类实例
     * @return Query
     */
    public static function db()
    {
        return self::get('linkphp\db\Query');
    }


}