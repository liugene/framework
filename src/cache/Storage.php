<?php

namespace link\cache;

abstract class Storage
{

    private $cache_time = 3600;

    private $cache_path = RUNTIME_PATH . 'temp/temp_cache/';

    private $ext = '.php';

    abstract public function put($key,$data);

    abstract public function get($key);

    public function setCacheTime($time)
    {
        $this->cache_time = $time;
        return $this;
    }

    public function setCachePath($path)
    {
        $this->cache_path = $path;
        return $this;
    }

    public function setExt($ext)
    {
        $this->ext = $ext;
        return $this;
    }

    public function filename($key)
    {
        return $this->cache_path . md5($key) . $this->ext;
    }

}