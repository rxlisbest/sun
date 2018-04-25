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

    public static function getFile($url)
    {
    }

    public static function getNamespace($url, $base_path)
    {
        if(strripos($file, '/') !== false){

        }
        else{

        }
    }

    public static function setParam($param)
    {
        self::$param = $param;
    }
}