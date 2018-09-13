<?php
/**
 * Created by PhpStorm.
 * User: ruixinglong
 * Date: 2018/1/16
 * Time: 下午3:16
 */

namespace Rxlisbest\Sun;

use Rxlisbest\Sun\Core\Factory;
use Rxlisbest\Sun\Core\Base;
use Rxlisbest\Sun\Core\Test;

class Application extends Base{

    protected $config;

    protected $factory;

    protected $component = [
        'request' => 'Rxlisbest\Sun\Component\Request',
        'route' => 'Rxlisbest\Sun\Component\Route'
    ];

    protected $controller_namespace = 'app\controllers';

    public function __construct($config){
        $this->config = $config;
        Test::$config = $this->config;
        Test::$controller_namespace = $this->controller_namespace;
        $this->factory = new Factory();
    }

    public function run(){
        $request = $this->getRequest();
        $route = $this->getRoute();
        $reponse = $this->handle($route, $request);

        $namespace = Route::getNamespace($url, $base_path);
        $file = Route::getFile($namespace);
        include $base_path . $file;
        $controller = $this->findController($namespace);
    }

    public function getComponent($id){
        return $this->component[$id];
    }

    public function getRequest(){
        $class = $this->getComponent('request');
        return $this->factory->get($class);
    }

    public function getRoute(){
        $class = $this->getComponent('route');
        return $this->factory->get($class);
    }
}

spl_autoload_register(['Rxlisbest\Sun\Core\Test', 'autoload'], true, true);