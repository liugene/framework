<?php

namespace linkphp\boot\http\response;
use linkphp\boot\http\HttpResponse;

class View extends HttpResponse
{

    protected $content_type = 'application/html';

    /**
     * 处理数据
     * @access public
     * @param mixed $data 要处理的数据
     * @return mixed
     */
    public function output($data)
    {
        return $data;
    }

}