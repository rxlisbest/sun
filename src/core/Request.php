<?php
/**
 * Created by PhpStorm.
 * User: ruixinglong
 * Date: 2018/1/16
 * Time: 下午4:19
 */

namespace Rxlisbest\Sun\Core;


class Request
{
    public function getUrl(){
        return $_SERVER['REQUEST_URI'];
    }

    public function get(){
        return $_GET;
    }

    public function post(){
        return $_POST;
    }

    public function request(){
        return array_merge($_GET, $_POST);
    }
}