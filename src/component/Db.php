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
    protected $config;
    public function __construct($config)
    {
        $this->config = $config;
    }

    public function connection()
    {
        return new \PDO($this->config['dsn'], $this->config['username'], $this->config['password']);
    }
}