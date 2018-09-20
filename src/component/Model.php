<?php
/**
 * Created by PhpStorm.
 * User: ruixinglong
 * Date: 2018/1/17
 * Time: 下午1:43
 */

namespace Rxlisbest\Sun\Component;

use Rxlisbest\Sun\Sun;

class Model
{
    protected $db_class = 'Rxlisbest\Sun\Component\Db';
    protected $db;

    private $_table;
    private $_field;
    private $_where;
    private $_offset = 0;
    private $_limit;
    private $_join;
    private $_group;
    private $_order;

    private $sql_template = 'SELECT %FIELD% FROM %TABLE% %JOIN% %WHERE% %GROUP% %ORDER%';

    public function __construct()
    {
        $db = Sun::createObject($this->db_class, [Sun::$config['database']]);
        $this->db = $db->connection();
        $this->_table = $this->getTableName();
    }

    public function getTableName(){
        $prefix = Sun::$config['database']['prefix'];
        $class_name = get_class($this);
        $class_name = substr($class_name, strrpos($class_name, '\\') + 1);
        $table = $prefix . strtolower($class_name);
        return $table;
    }

    public static function get()
    {
        return Sun::createObject(get_class());
//        return $this->db->query('SELECT * FROM migration');
    }

    public function field($field)
    {
        if (is_array($field)) {
            $field = implode(',', $field);
        }
        $this->_field = $field;
        return $this;
    }

    public function where()
    {
        $args = func_get_args();
        $this->andWhere($args);
        return $this;
    }

    public function andWhere()
    {
        $args = func_get_args();
        $_where = call_user_func_array([$this, 'createWhere'], $args);
        if (!$this->_where) {
            $this->_where = $_where;
        } else {
            $this->_where .= ' AND ' . $_where;
        }
        return $this;
    }

    public function orWhere()
    {
        $args = func_get_args();
        $_where = call_user_func_array([$this, 'createWhere'], $args);
        if (!$this->_where) {
            $this->_where = $_where;
        } else {
            $this->_where .= ' OR ' . $_where;
        }
        return $this;
    }

    private function createWhere()
    {
        $args = func_get_args();
        $n = count($args);
        if (is_string($args[$n - 1])) {
            $condition = $args[$n - 1];
            unset($args[$n - 1]);
        } else {
            $condition = 'AND';
        }
        $where = [];
        foreach ($args as $k => $v) {
            if (is_array($v[0])) {
                $where[] = '(' . call_user_func_array([$this, 'createWhere'], $v) . ')';
            } else {
                $where[] = '(' . implode(' ', $v) . ')';
            }
        }
        return implode(" ${condition} ", $where);
    }

    public function limit($offset, $limit)
    {
        if (is_string($offset) && strrpos($offset, ',')) {
            list($offset, $limit) = explode(',', $offset);
        }
        if (is_array($offset) && count($offset) == 2) {
            list($offset, $limit) = $offset;
        }

        $this->_offset = $offset;
        $this->_limit = $limit;
        return $this;
    }

    public function join($table, $condition)
    {
        $this->_group = $group;
        return $this;
    }

    public function group($group)
    {
        $this->_group = $group;
        return $this;
    }

    public function order($order)
    {
        $this->_order = $order;
        return $this;
    }

    private function sql()
    {
        if ($this->_field) {

        }
    }
}