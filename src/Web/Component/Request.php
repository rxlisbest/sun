<?php
/**
 * Created by PhpStorm.
 * User: ruixinglong
 * Date: 2018/1/16
 * Time: 下午4:19
 */

namespace Rxlisbest\Sun\Web\Component;

use Rxlisbest\Sun\Web\Core\Route;

class Request extends \Rxlisbest\Sun\Web\Core\Request
{
    public function get()
    {
        return $_GET;
    }

    public function post()
    {
        return $_POST;
    }

    public function request()
    {
        return array_merge($_GET, $_POST);
    }
}