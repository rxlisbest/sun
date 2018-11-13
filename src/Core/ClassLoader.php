<?php
/**
 * Created by PhpStorm.
 * User: ruixinglong
 * Date: 2018/9/13
 * Time: 下午5:43
 */

namespace Rxlisbest\Sun\Core;

defined('DS') or define('DS', DIRECTORY_SEPARATOR);

class ClassLoader
{
    public static $config;

    public static function autoload($class_name)
    {
        $class_file = self::$config['base_path'] . DS . str_replace('\\', DS, $class_name) . '.php';
        if (!is_file($class_file)) {
            return;
        }
        include($class_file);
    }
}