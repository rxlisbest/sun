<?php
/**
 * Created by PhpStorm.
 * User: ruixinglong
 * Date: 2018/1/17
 * Time: 下午1:42
 */

namespace Rxlisbest\Sun\Component;

use Rxlisbest\Sun\Sun;

defined('DS') or define('DS', DIRECTORY_SEPARATOR);

class Controller
{
    protected $view;
    protected $view_class = 'Rxlisbest\Sun\Component\View';

    public function __construct()
    {
        $this->view = Sun::createObject($this->view_class);
    }

    public function fetch($template, $params = [])
    {
        $controller = Sun::$app->getRoute()->controller();
        $action = Sun::$app->getRoute()->action();
        $t = array_filter(explode('/', $template));
        $n = count($t);
        switch ($n) {
            case 0:
                $file = $controller . DS . $action . '.php';
                break;
            case 1:
                $file = $controller . DS . $template . '.php';
                break;
            default:
                $file = str_replace('/', DS, $template) . '.php';
        }
        $file = Sun::$config['base_path'] . DS . 'app' . DS . 'views' . DS . $file;
        return $this->view->fetch($file, $params);
    }
}