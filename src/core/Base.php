<?php
/**
 * Created by PhpStorm.
 * User: ruixinglong
 * Date: 2018/9/12
 * Time: 下午2:55
 */

namespace Rxlisbest\Sun\Core;

use Rxlisbest\Sun\Component\Route;


class Base
{
    protected $default_controller = 'index';
    protected $default_action = 'index';

    protected function handle($route, $request){
        $url = $route->getUrl($this->config['path_info']);
        list($controller_id, $url) = $this->getControllerId($url);

//        $controller->runAction();
        $this->runAction($controller_id, $url);
    }

    protected function getControllerId($url){
//        $script_file = $_SERVER['SCRIPT_FILENAME'];
        $script_name = $_SERVER['SCRIPT_NAME'];

        if(strpos($url, $script_name) !== false){
            $url = substr($url, strlen($script_name) + 1);
        }

        if(!$url){
            return [$this->default_controller, ''];
        }

        if(strpos('/', $url) === false){
            return [$url, ''];
        }

        list($controller_id, $route) = explode('/', $url, 2);
        if(!$controller_id){
            return [$this->default_controller, ''];
        }

        if($pos = strrpos('/', $url) !== false){
            $controller_id = substr($url, 0, $pos);
            $url = substr($url, $pos + 1);
        }
        return [$controller_id, $url];
    }

    protected function createController($controller_id){
        if($pos = strrpos($controller_id, '\\') !== false){
            $directory = substr($controller_id, 0, $pos);
            $class_name = ucwords(substr($controller_id, $pos + 1));
        }
        else{
            $directory = '';
            $class_name = ucwords($controller_id);
        }
        $controller_id = $directory . $class_name;
        return $this->factory->get($this->controller_namespace . '\\' . $controller_id . 'Controller');
    }

    protected function runAction($controller_id, $url){
        $action_id = $url ?: $this->default_action;

        $controller = $this->createController($controller_id);
        call_user_func_array([$controller, $action_id], []);
    }
}
