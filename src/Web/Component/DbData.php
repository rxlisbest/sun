<?php
/**
 * Created by PhpStorm.
 * User: ruixinglong
 * Date: 2018/11/12
 * Time: 5:43 PM
 */

namespace Rxlisbest\Sun\Web\Component;

class DbData
{
    const BUILD_TYPE_COLUMN = 'column';
    const BUILD_TYPE_INDEX = 'index';
    const BUILD_TYPE_KEY = 'key';

    private $build_type = 'column'; // column, index, key
    private $field;

    // column
    private $column_type;
    private $column_length = 0;
    private $column_is_null = true;
    private $column_default_value = false;
    private $column_comment = '';
    private $column_auto_increment = false;

    // key
    private $key_type = '';

    // index
    private $index_name;
    private $index_type = '';
    private $index_option;

    public static function field($field)
    {
        $class = new self();
        $class->field = $field;
        return $class;
    }

    public static function primaryKey($field)
    {
        $class = self::field($field);
        $class->build_type = self::BUILD_TYPE_KEY;
        $class->key_type = 'PRIMARY';
        return $class;
    }

    public static function key($field, $name)
    {
        $class = self::field($field);
        $class->key_type = $type;
        return $class;
    }

    public static function index($field, $name = '', $option = '')
    {
        $class = self::field($field);
        $class->index_type = $type;
        return $class;
    }

    public static function uniqueIndex()
    {
        $class = self::field($field);
        $class->index_type = 'UNIQUE';
        return $class;
    }

    public function string($length = 255)
    {
        $this->column_type = 'VARCHAR';
        $this->column_length = $length;
        return $this;
    }

    public function integer($length = 11)
    {
        $this->column_type = 'INT';
        $this->column_length = $length;
        return $this;
    }

    public function bigInt($length)
    {
        $this->column_type = 'BIGINT';
        $this->column_length = $length;
        return $this;
    }

    public function isNull($is_null)
    {
        $this->column_is_null = $is_null;
        return $this;
    }

    public function defaultValue($default_value)
    {
        $this->column_default_value = $default_value;
        return $this;
    }

    public function comment($comment)
    {
        $this->column_comment = $comment;
        return $this;
    }

    public function autoIncrement($auto_increment = 'true')
    {
        $this->column_auto_increment = $auto_increment;
        return $this;
    }

    public function build()
    {
        $str = '';
        switch ($this->build_type) {
            case self::BUILD_TYPE_COLUMN:
                if (!$this->field || !$this->column_type) {
                    return false;
                }
                $str = sprintf('`%s` %s', $this->field, $this->column_type);
                if ($this->column_length) {
                    $str .= "({$this->column_length})";
                }
                if (!$this->column_is_null) {
                    $str .= " NOT NULL";
                }
                if ($this->column_default_value !== false) {
                    if (is_string($this->column_default_value)) {
                        $str .= " DEFAULT '{$this->column_default_value}'";
                    }
                }
                if ($this->column_comment) {
                    $str .= " COMMENT '{$this->column_comment}'";
                }
                if ($this->column_auto_increment) {
                    $str .= " AUTO_INCREMENT";
                }
                break;
            case self::BUILD_TYPE_KEY:
                if ($this->key_type) {
                    $str .= $this->key_type . ' ';
                }
                $str .= "KEY ({$this->field})";
                break;
            case self::BUILD_TYPE_INDEX:
                if ($this->index_type) {
                    $str .= $this->index_type . ' ';
                }
                $str .= "INDEX {$this->index_name} ({$this->field})";
                break;
            default:
                // do nothing
                break;
        }

        return $str;
    }
}