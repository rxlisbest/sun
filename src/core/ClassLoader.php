<?php
/**
 * Created by PhpStorm.
 * User: ruixinglong
 * Date: 2018/9/13
 * Time: 下午5:43
 */

namespace Rxlisbest\Sun\Core;


class ClassLoader
{
    public static $config;
    public static $controller_namespace;
    public static $factory;

    public static function autoload($class_name){
        $class_file = self::$config['base_path'] . '/'. str_replace('\\', '/', $class_name) . '.php';
        if(!is_file($class_file)){
            return ;
        }
        include($class_file);
    }

    public static function createObject($class, $params = []){
        return self::$factory->get($class, $params);
    }
}