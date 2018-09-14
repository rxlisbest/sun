<?php
/**
 * Created by PhpStorm.
 * User: ruixinglong
 * Date: 2018/9/13
 * Time: 下午5:43
 */

namespace Rxlisbest\Sun\Core;


class Test
{
    public static $config;
    public static $controller_namespace;

    public static function autoload($class_name){
        if(strpos($class_name, self::$controller_namespace) !== false){
            $class_file = self::$config['base_path'] . '/'. str_replace('\\', '/', $class_name) . '.php';
            include($class_file);
        }
    }
}