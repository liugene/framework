<?php

/**
 * --------------------------------------------------*
 *  LhinkPHP遵循Apache2开源协议发布  Link ALL Thing  *
 * --------------------------------------------------*
 *  @author LiuJun     Mail-To:liujun2199@vip.qq.com *
 * --------------------------------------------------*
 * Copyright (c) 2017 LinkPHP. All rights reserved.  *
 * --------------------------------------------------*
 *                   LinkPHP基础类                   *
 * --------------------------------------------------*
 */

namespace linkphp;

class Controller
{

    public function view($template,$data=null)
    {
        return view($template,$data);
    }

    public function display($template)
    {
        return Application::get('linkphp\template\view')->display($template);
    }

    public function assign($name,$value=null)
    {
        return Application::get('linkphp\template\view')->assign($name,$value);
    }

    public function redirect(){}

}