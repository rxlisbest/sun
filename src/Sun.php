<?php
/**
 * Created by PhpStorm.
 * User: ruixinglong
 * Date: 2018/9/18
 * Time: 下午9:08
 */

namespace Rxlisbest\Sun;


class Sun
{
    public static $app;
    public static $config;
    public static $controller_namespace;
    public static $factory;

    public static function createObject($class, $params = [])
    {
        return static::$factory->get($class, $params);
    }
}