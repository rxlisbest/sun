<?php
/**
 * Created by PhpStorm.
 * User: ruixinglong
 * Date: 2018/1/16
 * Time: 下午3:17
 */

namespace Rxlisbest\Sun\Component;

use Rxlisbest\Sun\Sun;

class Route
{
    protected $param = 'r';
    protected $default_controller = 'index';
    protected $default_action = 'index';

    public function getUrl()
    {
        if (Sun::$config['path_info']) {
            $url = $_SERVER['REQUEST_URI'];
        } else {
            $param = $this->param;
            $url = $_GET[$param];
        }
        return $url;
    }

    public function getControllerId($url)
    {
        //        $script_file = $_SERVER['SCRIPT_FILENAME'];
        $script_name = $_SERVER['SCRIPT_NAME'];

        if (strpos($url, $script_name) !== false) {
            $url = substr($url, strlen($script_name) + 1);
        }

        if (!$url) {
            return [$this->default_controller, ''];
        }

        if (strpos('/', $url) === false) {
            return [$url, ''];
        }

        list($controller_id, $route) = explode('/', $url, 2);
        if (!$controller_id) {
            return [$this->default_controller, ''];
        }

        if ($pos = strrpos('/', $url) !== false) {
            $controller_id = substr($url, 0, $pos);
            $url = substr($url, $pos + 1);
        }
        return [$controller_id, $url];
    }

    public function getActionId($url)
    {
        $action_id = $url ?: $this->default_action;
        return $action_id;
    }

    public function controller()
    {
        list($controller_id, $url) = $this->getControllerId($this->getUrl());
        if ($pos = strrpos('/', $controller_id) !== false) {
            $controller = substr($controller_id, 0, $pos);
        } else {
            $controller = $controller_id;
        }
        return $controller;
    }

    public function action()
    {
        list($controller_id, $url) = $this->getControllerId($this->getUrl());
        return $this->getActionId($url);
    }
}