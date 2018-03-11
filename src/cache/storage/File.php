<?php

namespace link\cache\storage;

use link\cache\Storage;

class File extends Storage
{

    public function put($key, $data)
    {
        $value = serialize($data);
        $filename = $this->filename($key);
        $dir = dirname($filename);
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }
        $file = fopen($filename,'w');
        if($file){
            fwrite($file,$value);
            fclose($file);
        } else return false;
        return true;
    }

    public function get($key)
    {
        $filename = $this->filename($key);
        if(!file_exists($filename) || !is_readable($filename)){
            return false;
        }
        dump($filename);die;
    }

}