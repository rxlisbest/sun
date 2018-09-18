<?php
/**
 * Created by PhpStorm.
 * User: ruixinglong
 * Date: 2018/1/17
 * Time: 下午1:43
 */

namespace Rxlisbest\Sun\Component;

use Rxlisbest\Sun\Core\ClassLoader;

class Model
{
    protected $db_class = 'Rxlisbest\Sun\Component\Db';
    protected $db;

    public function __construct()
    {
        $db = ClassLoader::createObject($this->db_class, [ClassLoader::$config['database']]);
        $this->db = $db->connection();
    }

    public function get(){
        return $this->db->query('SELECT * FROM migration');
    }

    public function where(){

    }
}