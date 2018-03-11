<?php

/**
 * --------------------------------------------------*
 *  LhinkPHP遵循Apache2开源协议发布  Link ALL Thing  *
 * --------------------------------------------------*
 *  @author LiuJun     Mail-To:liujun2199@vip.qq.com *
 * --------------------------------------------------*
 * Copyright (c) 2017 LinkPHP. All rights reserved.  *
 * --------------------------------------------------*
 *                  Links模板引擎类                  *
 * --------------------------------------------------*
 */

namespace linkphp\boot\view\engine;

use linkphp\boot\Exception;
use linkphp\boot\view\Engine;

class Link extends Engine
{
    /**
     * 模板编译文件
     * */
    private $temp_c;
    /**
     * 模板编译文件内容
     * */
    private $temp_content;
    /**
     * 模板复制变量
     * */
    private $tVar = [];
    /**
     * 左界定符号
     * */
    private $left_limit;
    /**
     * 右界定符号
     * */
    private $right_limit;


    /**
     * 模板编译
     * */
    private function fetch($tempfile)
    {
        $CompileFile = file_get_contents($tempfile);
        $pregRule_L = '#' . config('set_left_limiter') . '#';
        $pregRule_R = '#' . config('set_right_limiter') . '#';
        $this->temp_content = preg_replace($pregRule_L,'<?php echo ',$CompileFile);
        $this->temp_content = preg_replace($pregRule_R,'; ?>',$this->temp_content);
        $this->temp_c = RUNTIME_PATH . 'temp/temp_c/' . md5($tempfile) . '.c.php';
        // 检测模板目录
        $dir = dirname($this->temp_c);
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }
        if(false === file_put_contents($this->temp_c,$this->temp_content)){
            throw new Exception('runtime文件夹无法创建，请检查目录权限');
        }
    }
    /**
     * 加载视图方法
     * */
    public function display($template)
    {
        $filename = CACHE_PATH . 'view/' . $template . config('default_theme_suffix');
        $this->fetch($filename);
        //加载视图文件
        // 模板阵列变量分解成为独立变量
        extract($this->tVar);
        if(file_exists($this->temp_c)){
            include_once $this->temp_c;
        } else {
            throw new \Exception($filename . '视图文件不存在');
        }
    }
    /**
     * 模板赋值输出方法
     * @param string $name
     * @param string $value
     */
    public function assign($name,$value=null)
    {
        //模板赋值
        if(is_array($name)){
            $this->tVar = $name;
            return;
        }
        $this->tVar[$name] = $value;
    }
}