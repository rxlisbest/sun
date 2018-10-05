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
    protected $_conn;

    private $insert_template = 'INSERT INTO %TABLE% (%FIELD%) VALUES (%VALUE%)';

    public function __construct($config)
    {
        $this->_conn = new \PDO($config['dsn'], $config['username'], $config['password']);
    }

    public function insert($table, $data)
    {
        $sql = $this->insertSql($table, $data);
        $this->_conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        $sth = $this->_conn->prepare($sql);
        try {
            $data = array_values($data);
            $sth->execute($data);
            $id = $this->_conn->lastInsertId();
            return $id;
        } catch (\PDOException $e) {
            echo 'insert error: ' . print_r($data, true) . "\n" . $e->getMessage();
        }
    }

    public function insertSql($table, $data)
    {
        $field = array_keys($data);
        $value = range(0, count($data) - 1);

        $r = function () {
            return "?";
        };
        $value = array_map($r, $value);

        $before = [
            '%TABLE%',
            '%FIELD%',
            '%VALUE%',
        ];
        $after = [
            $table,
            implode(',', $field),
            implode(',', $value),
        ];
        $sql = str_replace($before, $after, $this->insert_template);
        return $sql;
    }
}