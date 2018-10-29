<?php
/**
 * Created by PhpStorm.
 * User: ruixinglong
 * Date: 2018/9/12
 * Time: 下午2:55
 */

namespace Rxlisbest\Sun\Web\Core;

class Base
{
    protected function handle($route, $request)
    {
        $url = $route->getUrl($this->config['path_info']);
        list($controller_id, $url) = $route->getControllerId($url);

        $action_id = $route->getActionId($url);
        $this->runAction($controller_id, $action_id);
    }

    protected function createController($controller_id)
    {
        if ($pos = strrpos($controller_id, '\\') !== false) {
            $directory = substr($controller_id, 0, $pos);
            $class_name = ucwords(substr($controller_id, $pos + 1));
        } else {
            $directory = '';
            $class_name = ucwords($controller_id);
        }
        $controller_id = $directory . $class_name;
        return $this->factory->get($this->controller_namespace . '\\' . str_replace('/', '\\', $controller_id) . 'Controller');
    }

    protected function runAction($controller_id, $action_id)
    {
        $controller = $this->createController($controller_id);
        call_user_func_array([$controller, $action_id], []);
    }
}
