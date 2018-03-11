<?php

/**
 * --------------------------------------------------*
 *  LhinkPHP遵循Apache2开源协议发布  Link ALL Thing  *
 * --------------------------------------------------*
 *  @author LiuJun     Mail-To:liujun2199@vip.qq.com *
 * --------------------------------------------------*
 * Copyright (c) 2017 LinkPHP. All rights reserved.  *
 * --------------------------------------------------*
 *            LinkPHP框架视图控制类                  *
 * --------------------------------------------------*
 */

namespace linkphp\boot;
class View
{

    private static $_instance;

    private $_engine;

    public static function instance()
    {
        if(is_null(self::$_instance)) self::$_instance = new self();
        return self::$_instance;
    }

    public function engine()
    {
        if(is_null($this->_engine)) $this->_engine = new \linkphp\boot\view\engine\Link();
        return $this->_engine;
    }

    /**
     * 加载显示模板视图方法
     * @param string $template
     */
    public function display($template)
    {
        $this->engine()->display($template);
    }

    /**
     * 模板赋值输出方法
     * @param string $name
     * @param string $value
     */
    public function assign($name,$value=null)
    {
        $this->engine()->assign($name,$value);
    }

}
