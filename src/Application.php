<?php
/**
 * Created by PhpStorm.
 * User: ruixinglong
 * Date: 2018/1/16
 * Time: 下午3:16
 */

namespace Rxlisbest\Sun;
use app\controllers\IndexController;
use Rxlisbest\Sun\Core\Request;

class Application
{
    private $config;

    public function __construct($config)
    {
        $this->config = $config;
    }

    public function run()
    {
        $base_path = $this->config['base_path'];
        include $base_path . '/app/controllers/IndexController.php';
        $controller = new IndexController();
        $controller->index();
    }
}