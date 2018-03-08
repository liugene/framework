<?php

namespace util\curl;
/**
 * --------------------------------------------------*
 *  LhinkPHP遵循Apache2开源协议发布  Link ALL Thing  *
 * --------------------------------------------------*
 *  @author LiuJun     Mail-To:liujun2199@vip.qq.com *
 * --------------------------------------------------*
 * Copyright (c) 2017 LinkPHP. All rights reserved.  *
 * --------------------------------------------------*
 *                 LinkPHP框架CURL类                 *
 * --------------------------------------------------*
 */
/**
 * Client URL 可用来模拟URL客户端(浏览器，请求代理)的工具扩展
 * curl_init()初始化curl
 * curl_setopt(curl资源，选项标志，选项值)
 * curl_exec(资源)发出请求
 * curl_close()关闭资源
 * CURLOPT_COOKIEJAR 指定用来存储服务器所设置的cookie变量值
 * CURLOPT_COOKIEFILE 请求时携带的cookie数据所在的位置
 * CURL操作类
 */

class Curl
{

    public function get($url,$data=[])
    {
        if (is_array($url)) {
            $data = $url;
            $url = (string)$this->url;
        }
        $this->setUrl($url, $data);
        $this->setOpt(CURLOPT_CUSTOMREQUEST, 'GET');
        $this->setOpt(CURLOPT_HTTPGET, true);
        return $this->exec();
    }

    public function post($url,$data=[]){}

    static public function request($type,$url,$data=''){
        
        //模拟GET请求
        $curl = curl_init();
        curl_setopt($curl,CURLOPT_URL,$url);
        switch($type){
            case 'get';
                break;
            case 'post';
                curl_setopt($curl,CURLOPT_POST,true);
                $post_data = $data;
                curl_setopt($curl,CURLOPT_POSTFIELDS,$post_data);
                break;
        }
        //处理响应数据
        curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }
}
