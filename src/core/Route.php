<?php
/**
 * Created by PhpStorm.
 * User: ruixinglong
 * Date: 2018/1/16
 * Time: 下午3:17
 */

namespace Rxlisbest\Sun\Core;


class Route
{
    public static $param = 'r';

    public static function getClass($url)
    {

    }

    public static function getFile($namespace)
    {
        return '/app/controllers/IndexController.php';
    }

    public static function getNamespace($url, $base_path)
    {
        return '\app\controllers\IndexController';
        if(strripos($url, '/') !== false){
            $url_arr = explode('/', $url);
            $controller = $url_arr;
        }
        else{

        }
    }

    public static function setParam($param){
        self::$param = $param;
    }
}