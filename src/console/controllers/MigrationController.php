<?php
/**
 * Created by PhpStorm.
 * User: ruixinglong
 * Date: 2018/1/17
 * Time: 下午12:21
 */

namespace Rxlisbest\Sun\Console\Controllers;

use Rxlisbest\Sun\Sun;

defined('DS') or define('DS', DIRECTORY_SEPARATOR);

class MigrationController
{
    public function run()
    {
        echo "migration";
    }

    public function create($param)
    {
        $class_name = $param[0];
        $file_name = date('YmdHis') . '_' . strtolower(preg_replace('/(?<=[a-z])([A-Z])/', '_$1', $class_name)) . '.php';
        $path = Sun::$config['base_path'] . DS . 'database' . DS . 'migration' . DS;
        $file = $path . $file_name;
        if (!is_dir($path)) {
            mkdir($path, 0777, true);
        }
        $fp = fopen($file, "w");
        fwrite($fp, "test");
        fclose($fp);
    }
}