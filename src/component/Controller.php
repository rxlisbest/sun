<?php
/**
 * Created by PhpStorm.
 * User: ruixinglong
 * Date: 2018/1/17
 * Time: 下午1:42
 */

namespace Rxlisbest\Sun\Component;


class Controller
{
    public function fetch($template, $params = [])
    {
        ob_start();
        ob_implicit_flush(0);
        extract($params, EXTR_OVERWRITE);
        $file = '/Library/WebServer/Documents/htdocs/php-frame/sun/app/views/index/index.php';
        include($file);
        $content = ob_get_clean();
        echo $content;
    }
}