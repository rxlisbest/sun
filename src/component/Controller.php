<?php
/**
 * Created by PhpStorm.
 * User: ruixinglong
 * Date: 2018/1/17
 * Time: 下午1:42
 */

namespace Rxlisbest\Sun\Component;

use Rxlisbest\Sun\Sun;

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
        return $this->view->fetch($template, $params);
    }
}