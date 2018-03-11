<?php

/**
 * --------------------------------------------------*
 *  LhinkPHP遵循Apache2开源协议发布  Link ALL Thing  *
 * --------------------------------------------------*
 *  @author LiuJun     Mail-To:liujun2199@vip.qq.com *
 * --------------------------------------------------*
 * Copyright (c) 2017 LinkPHP. All rights reserved.  *
 * --------------------------------------------------*
 *                 LinkPHP缓存入口文件               *
 * --------------------------------------------------*
 */

namespace link\cache;

use link\cache\storage\File;

class Cache
{

    private $storage;

    public function storage()
    {
        if(is_null($this->storage)) $this->storage = new File();
        return $this->storage;
    }

    public function setCacheTime($time)
    {
        $this->storage()->setCacheTime($time);
        return $this;
    }

    public function setCachePath($path)
    {
        $this->storage()->setCachePath($path);
        return $this;
    }

    public function setExt($ext)
    {
        $this->storage()->setExt($ext);
        return $this;
    }

    public function get($key)
    {
        return $this->storage()->get($key);
    }

    public function put($key,$data)
    {
        return $this->storage()->put($key,$data);
    }

}