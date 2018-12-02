<?php

//类文件后缀常量
const EXT = '.php';
const SYS = '.php';
const DS = '\\';

//版本信息
define('LINKPHP_VERSION','1.0.0');
//声明应用根命名空间
//声明路径常量

//定义站点入库文件夹目录常量
defined('WEB_PATH') or define('WEB_PATH',ROOT_PATH . 'root/');
//定义框架加载文件夹目录常量
defined('LOAD_PATH') or define('LOAD_PATH',ROOT_PATH . 'conf/');
defined('APPLICATION_PATH') or define('APPLICATION_PATH', ROOT_PATH . 'src/application/');
//定义Composer目录常量
defined('VENDOR_PATH') or define('VENDOR_PATH', ROOT_PATH . 'vendor/');
//定义缓存目录常量
defined('CACHE_PATH') or define('CACHE_PATH', ROOT_PATH . 'src/resource/');
//定义公共附件目录常量
defined('__ATTACH__') or define('__ATTACH__', WEB_PATH . 'attachment/');
//定义框架运行产生文件文件夹目录常量
defined('RUNTIME_PATH') or define('RUNTIME_PATH',ROOT_PATH . 'src/runtime/');
//定义LinkPHP框架目录常量
defined('FRAMEWORK_PATH') or define('FRAMEWORK_PATH', VENDOR_PATH . 'linkphp/framework/src/');
//定义LinkPHP框架附加文件目录常量
defined('EXTRA_PATH') or define('EXTRA_PATH', FRAMEWORK_PATH . 'extra/');
//定义LinkPHP框架语言目录常量
defined('LANG_PATH') or define('LANG_PATH', FRAMEWORK_PATH . 'extra/lang/');
//定义LinkPHP框架附件目录常量
defined('TEMP_PATH') or define('TEMP_PATH', FRAMEWORK_PATH . 'extra/temp/');
//定义LinkPHP扩展类库目录常量
defined('EXTEND_PATH') or define('EXTEND_PATH', ROOT_PATH . 'ext/');

//系统可变常量
defined('ENV_PREFIX') or define('ENV_PREFIX', 'PHP_'); // 环境变量的配置前缀
defined('APP_INTERFACE_ON') or define('APP_INTERFACE_ON','FALSE'); //开启接口应用
defined('APP_NAMESPACE_NAME') or define('APP_NAMESPACE_NAME','app'); //定义应用名称
defined('APP_DEBUG') or define('APP_DEBUG',FALSE); //开启站点调试
defined('SYSTEM_LANGUAGE') or define('SYSTEM_LANGUAGE','');
define('IS_CLI',PHP_SAPI == 'cli' ? true : false);

