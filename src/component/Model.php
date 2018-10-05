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
    private $_force;
    private $_field;
    private $_where;
    private $_limit;
    private $_join;
    private $_group;
    private $_having;
    private $_order;
    private $_union;
    private $_lock;

    private $select_template = 'SELECT %FIELD% FROM %TABLE% %FORCE% %JOIN% %WHERE% %GROUP% %HAVING% %ORDER% %LIMIT% %UNION% %LOCK%';

    public function __construct()
    {
        $db = Sun::createObject($this->db_class, [Sun::$config['database']]);
        $this->db = $db;
    }

    public function getTableName()
    {
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

    public function force($field)
    {
        if (is_array($field)) {
            $field = implode(',', $field);
        }
        if ($field) {
            $this->_force = " FORCE INDEX (${field})";
        } else {
            $this->_force = '';
        }
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

    public function limit($offset, $limit = '')
    {
        if (is_string($offset) && strrpos($offset, ',')) {
            list($offset, $limit) = explode(',', $offset);
        }
        if (is_array($offset) && count($offset) == 2) {
            list($offset, $limit) = $offset;
        }
        if (!$limit) {
            $limit = $offset;
            $offset = 0;
        }

        $this->_limit = " LIMIT ${offset},${limit}";
        return $this;
    }

    public function join($table, $on, $type = '')
    {
        if ($type) {
            $this->_join .= " ${type} JOIN ${table} ON ${on}";
        } else {
            $this->_join .= " JOIN ${table} ON ${on}";
        }
        return $this;
    }

    public function group($group)
    {
        if ($group) {
            $this->_group = ' GROUP BY ' . $group;
        } else {
            $this->_group = '';
        }
        return $this;
    }

    public function having($having)
    {
        if ($having) {
            $this->_having = ' HAVING ' . $having;
        } else {
            $this->_having = '';
        }
        return $this;
    }

    public function order($order)
    {
        if ($order) {
            $this->_order = ' ORDER BY ' . $order;
        } else {
            $this->_order = '';
        }
        return $this;
    }

    public function union($union)
    {
        if ($union) {
            $this->_union = ' UNION ' . $union;
        } else {
            $this->_union = '';
        }
        return $this;
    }

    public function lock($lock)
    {
        if ($lock) {
            $this->_lock = ' FOR UPDATE';
        } else {
            $this->_lock = '';
        }
        return $this;
    }

    private function parseTable()
    {
        $this->_table = ' ' . $this->getTableName();
    }

    private function parseField()
    {
        if (!$this->_field) {
            $this->_field = " *";
        }
    }

    private function parseWhere()
    {
        if ($this->_where) {
            $this->_where = ' WHERE ' . $this->_where;
        } else {
            $this->_where = '';
        }
        return $this->_where;
    }

    public function select()
    {
        $sql = $this->selectSql();
        return $this->db->select();
    }

    public function insert($data)
    {
        $this->parseTable();
        return $this->db->insert($this->_table, $data);
    }

    public function selectSql()
    {
        $this->parseTable();
        $this->parseField();
        $this->parseWhere();

        $before = [
            ' %FIELD%',
            ' %TABLE%',
            ' %FORCE%',
            ' %JOIN%',
            ' %WHERE%',
            ' %GROUP%',
            ' %HAVING%',
            ' %ORDER%',
            ' %LIMIT%',
            ' %UNION%',
            ' %LOCK%'
        ];
        $after = [
            $this->_field,
            $this->_table,
            $this->_force,
            $this->_join,
            $this->_where,
            $this->_group,
            $this->_having,
            $this->_order,
            $this->_limit,
            $this->_union,
            $this->_lock,
        ];

        $sql = str_replace($before, $after, $this->select_template);
        return $sql;
    }
}