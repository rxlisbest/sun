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
        include $base_path . '/app/controllers/IndexController.php';

        $controller = $this->findController();
        call_user_func_array([$controller, 'index'], []);
    }

    public function findController(){
        $controller = '\app\controllers\IndexController';
        return new $controller();
    }
}