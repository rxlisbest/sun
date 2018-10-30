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
        $argv = $this->getArgv();
        $component = $this->getComponent($argv);
        $controller = $this->factory->get($component);
        $action = $this->getAction($argv);
        $params = $this->getParams($argv);
        call_user_func_array([$controller, $action], $params);
    }

    protected function getArgv()
    {
        return $_SERVER['argv'];
    }

    protected function getComponent($argv)
    {
        if (!isset($argv[1]) || $argv[1] == null) {
            throw new \Exception("Comman can not empty.");
        }
        $component = explode(':', $argv[1]);
        if (!isset($this->component[$component[0]])) {
            throw new \Exception("Comman can not find.");
        }
        return $this->component[$component[0]];
    }

    protected function getAction($argv)
    {
        $component = explode(':', $argv[1]);
        if (!isset($component[1])) {
            $component[1] = 'run';
        }
        return $component[1];
    }

    protected function getParams($argv)
    {
        unset($argv[0], $argv[1]);
        return $argv;
    }
}

spl_autoload_register(['Rxlisbest\Sun\Core\ClassLoader', 'autoload'], true, true);