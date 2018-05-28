<?php

namespace linkphp;

use linkphp\config\Config;
use linkphp\di\Container;
use linkphp\di\InstanceDefinition;
use linkphp\loader\Loader;
use linkphp\http\HttpRequest;
use linkphp\Make;
use linkphp\router\Router;
use Event;
use linkphp\event\EventDefinition;
use linkphp\db\Query;

class Application
{
    private $data;

    //保存是否已经初始化
    private static $_init;

    /**
     * 容器实例
     * @var Container
     */
    private static $_container;

    public function __construct()
    {
        $container = new Container();
        $container->bind(
            self::definition()
                ->setAlias('linkphp\di\Container')
                ->setIsEager(true)
                ->setIsSingleton(true)
                ->setClassName('linkphp\di\Container')
        );
        static::$_container = $container;
    }

    //links启动
    public function run()
    {
        $this->event('system');
        return $this;
    }

    private function consoleMode($config)
    {
        if(isset($config)){
            $this->make(\linkphp\console\Console::class)
                ->setDaemon(true)
                ->setDaemonConfig($config);
        }
        $this->event('console');
    }

    public function routerMode()
    {
        $this->event('router');
    }

    public function request($config = null)
    {
        $this->event('error');
        IS_CLI
            ?
            $this->consoleMode($config)
            :
            $this->routerMode();
        return $this;
    }

    public function response($class)
    {
        $this->setData(
            $this->make($class)->getReturnData()
        );
        $this->hook('destructMiddleware');
        $this->httpRequest()
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
        return self::make(\linkphp\router\Router::class)->rule($rule,$tag);
    }

    /**
     * 获取HttpRequest类实例
     * @return HttpRequest Object
     */
    static public function httpRequest()
    {
        return self::get('linkphp\http\HttpRequest');
    }

    /**
     * 获取实例
     * @param string $alias
     * @return Object
     */
    static public function get($alias)
    {
        return static::$_container->get($alias);
    }

    static public function bind(InstanceDefinition $definition)
    {
        return static::$_container->bind($definition);
    }

    static public function singleton($alias,$callback)
    {
        return self::bind(
            self::definition()
                ->setAlias($alias)
                ->setIsSingleton(true)
                ->setCallBack($callback)
        );
    }

    public static function singletonEager($alias,$callback)
    {
        return self::bind(
            self::definition()
                ->setAlias($alias)
                ->setIsEager(true)
                ->setIsSingleton(true)
                ->setClassName($callback)
        );
    }

    public static function eager($alias,$callback)
    {
        return self::bind(
            self::definition()
                ->setAlias($alias)
                ->setIsEager(true)
                ->setClassName($callback)
        );
    }

    public static function containerInstance($alias, $instance)
    {
        self::bind(
            self::definition()
                ->setAlias($alias)
                ->setIsSingleton(true)
                ->setIsEager(true)
                ->setInstance($instance)
        );
    }

    /**
     * 获取实例
     * @return InstanceDefinition
     */
    static public function definition()
    {
        return (new InstanceDefinition());
    }

    static public function getContainerInstance()
    {
        return static::$_container->getContainerInstance();
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
     * 获取类实例
     * @param $alias
     * @return mixed
     */
    static public function make($alias)
    {
        return self::get($alias);
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
    static public function loader()
    {
        return self::get('linkphp\\loader\\Loader');
    }

    /**
     * 获取事件类实例
     * @param string $server
     * @param string|array $events
     * @return mixed
     */
    static public function event($server='',$events='')
    {
        $eventObject = self::get('linkphp\event\Event');
        if($server == '') return $eventObject;
        if($events != ''){
            if(is_array($events)){
                $first = false;
                foreach($events as $event){
                    if($first){
                        $eventObject->getEventMap($server)
                            ->register(new $event);
                        continue;
                    }
                    $eventObject->provider(
                        self::eventDefinition()
                            ->setServer($server)
                            ->register(new $event)
                    );
                    $first=true;
                }
                return;
            } else {
                $eventObject->provider(
                    self::eventDefinition()
                        ->setServer($server)
                        ->register(new $events)
                );
                return;
            }
        }
        return $eventObject->target($server);
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
        $view = self::get('linkphp\template\View');
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

    /**
     * 获取Container类实例
     * @return Container
     */
    public static function container()
    {
        return static::$_container;
    }

    public function app()
    {
        return self::get('linkphp\\Application');
    }

}