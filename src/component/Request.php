<?php
/**
 * Created by PhpStorm.
 * User: ruixinglong
 * Date: 2018/1/16
 * Time: 下午4:19
 */

namespace Rxlisbest\Sun\Component;

use Rxlisbest\Sun\Core\Route;


class Request implements \Rxlisbest\Sun\Core\Request
{
    public function getController()
    {

    }

    public function getAction()
    {

    }

    public function get(){
        return $_GET;
    }

    public function post(){
        return $_POST;
    }

    public function request(){
        return array_merge($_GET, $_POST);
    }
}