<?php
/**
 * Created by PhpStorm.
 * User: ruixinglong
 * Date: 2018/11/12
 * Time: 5:43 PM
 */

namespace Rxlisbest\Sun\Web\Component;

use Rxlisbest\Sun\Sun;

class Migration
{
    protected $db_class = 'Rxlisbest\Sun\Web\Component\Db';
    protected $db;

    public function __construct()
    {
        $this->db = Sun::createObject($this->db_class, [Sun::$config['database']]);
    }

    protected function createTable($table, $columns, $options = '')
    {
        $result = $this->db->createTable($table, $columns, $options);
        return $result;
    }
}