<?php
/**
 * Created by PhpStorm.
 * User: ruixinglong
 * Date: 2018/1/16
 * Time: 下午4:19
 */

namespace Rxlisbest\Sun\Core;
use Rxlisbest\Sun\Core\Route;


class Request
{
    public function getUrl($path_info){
        if($path_info){
            $url = $_SERVER['REQUEST_URI'];
        }
        else{
            $param = Route::$param;
            $url = $_GET[$param];
        }
        return $_SERVER['REQUEST_URI'];
    }

    public function getController()
    {

    }

    public function getAction()
    {

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