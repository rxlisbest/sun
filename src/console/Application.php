<?php
/**
 * Created by PhpStorm.
 * User: ruixinglong
 * Date: 2018/1/16
 * Time: 下午3:16
 */

namespace Rxlisbest\Sun\Console;

use Rxlisbest\Sun\Sun;
use Rxlisbest\Sun\Core\Factory;
use Rxlisbest\Sun\Core\ClassLoader;

class Application
{
    protected $config;
    protected $factory;

    protected $component = [
        'migration' => 'Rxlisbest\Sun\Console\Controllers\MigrationController',
    ];

    public function __construct($config)
    {
        Sun::$config = ClassLoader::$config = $config;
        Sun::$factory = $this->factory = new Factory();
    }

    public function run()
    {
        $arr = $_SERVER['argv'];
        $t = explode(':', $arr[1]);
        $controller = $t[0];
        $component = $this->component[$controller];
        $controller = $this->factory->get($component);
        $action = 'index';
        $params = [];
        call_user_func_array([$controller, $action], $params);
    }

    protected function getArgv()
    {
        return $_SERVER['argv'];
    }

    protected function getAction($argv)
    {

    }
}

spl_autoload_register(['Rxlisbest\Sun\Core\ClassLoader', 'autoload'], true, true);