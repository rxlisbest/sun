<?php
/**
 * Created by PhpStorm.
 * User: ruixinglong
 * Date: 2018/9/18
 * Time: 下午5:20
 */

namespace Rxlisbest\Sun\Component;

use Rxlisbest\Sun\Sun;

class View
{
    public function fetch($template, $params = [])
    {
        ob_start();
        ob_implicit_flush(0);
        extract($params, EXTR_OVERWRITE);
        $file = Sun::$config['base_path'] . '/app/views/index/index.php';
        include($file);
        $content = ob_get_clean();
        echo $content;
    }
}