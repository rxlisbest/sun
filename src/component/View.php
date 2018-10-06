<?php
/**
 * Created by PhpStorm.
 * User: ruixinglong
 * Date: 2018/9/18
 * Time: 下午5:20
 */

namespace Rxlisbest\Sun\Component;

class View
{
    public function fetch($file, $params = [])
    {
        ob_start();
        ob_implicit_flush(0);
        extract($params, EXTR_OVERWRITE);
        include($file);
        $content = ob_get_clean();
        echo $content;
    }
}