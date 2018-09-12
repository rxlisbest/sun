<?php
/**
 * Created by PhpStorm.
 * User: ruixinglong
 * Date: 2018/1/16
 * Time: 下午3:17
 */

namespace Rxlisbest\Sun\Component;


class Route
{
    public static $param = 'r';

    public function getUrl($path_info){
        if($path_info){
            $url = $_SERVER['REQUEST_URI'];
        }
        else{
            $param = Route::$param;
            $url = $_GET[$param];
        }
        return $url;
    }
}