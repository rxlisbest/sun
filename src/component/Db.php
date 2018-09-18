<?php
/**
 * Created by PhpStorm.
 * User: ruixinglong
 * Date: 2018/1/17
 * Time: 下午1:43
 */

namespace Rxlisbest\Sun\Component;

class Db
{
    public function connection(){
        return new \PDO('mysql:host=localhost;dbname=taobao_2', 'root', 'root');
    }
}