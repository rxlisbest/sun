<?php
/**
 * Created by PhpStorm.
 * User: ruixinglong
 * Date: 2018/1/16
 * Time: 下午3:16
 */

namespace Rxlisbest\Sun\Web;

use Rxlisbest\Sun\Sun;
use Rxlisbest\Sun\Core\Factory;
use Rxlisbest\Sun\Core\ClassLoader;
use Rxlisbest\Sun\Web\Core\Base;

class Application extends Base
{

    protected $config;
    protected $factory;

    protected $component = [
        'request' => 'Rxlisbest\Sun\Web\Component\Request',
        'route' => 'Rxlisbest\Sun\Web\Component\Route'
    ];

    protected $controller_namespace = 'app\controllers';

    public function __construct($config)
    {
        Sun::$config = ClassLoader::$config = $config;
        Sun::$controller_namespace = $this->controller_namespace;
        Sun::$factory = $this->factory = new Factory();
        Sun::$app = $this;
    }

    public function run()
    {
        $request = $this->getRequest();
        $route = $this->getRoute();
        $reponse = $this->handle($route, $request);
    }

    public function getComponent($id)
    {
        return $this->component[$id];
    }

    public function getRequest()
    {
        $class = $this->getComponent('request');
        return $this->factory->get($class);
    }

    public function getRoute()
    {
        $class = $this->getComponent('route');
        return $this->factory->get($class);
    }
}

spl_autoload_register(['Rxlisbest\Sun\Core\ClassLoader', 'autoload'], true, true);