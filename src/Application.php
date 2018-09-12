<?php
/**
 * Created by PhpStorm.
 * User: ruixinglong
 * Date: 2018/1/16
 * Time: 下午3:16
 */

namespace Rxlisbest\Sun;
use Rxlisbest\Sun\Core\Request;
use Rxlisbest\Sun\Core\Route;

class Application{

    private $config;
    protected $controller_namespace = 'app\controllers';

    public function __construct($config){
        $this->config = $config;
    }

    public function run(){
        $request = new Request();
        $base_path = $this->config['base_path'];
        $url = $request->getUrl($this->config['path_info']);
        $script_file = $_SERVER['SCRIPT_FILENAME'];
        $script_name = $_SERVER['SCRIPT_NAME'];
        $path = substr($url, strlen($script_name) + 1);
        $controller_id = explode('/', $path, 2)[0];

        $namespace = Route::getNamespace($url, $base_path);
        $file = Route::getFile($namespace);
        include $base_path . $file;
        $controller = $this->findController($namespace);
        call_user_func_array([$controller, 'index'], []);
    }

    public function findController($namespace){
        $controller = $namespace;
        return new $controller();
    }
}