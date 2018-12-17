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
    private $build_type = 'column'; // column, index, primary_key
    private $field;
    private $type;
    private $length = 0;
    private $is_null = true;
    private $default_value = false;
    private $comment = '';
    private $auto_increment = false;

    public static function field($field)
    {
        $class = new self();
        $class->field = $field;
        return $class;
    }

    public static function primaryKey($field)
    {
        $class = self::field($field);
        $class->build_type = 'primary_key';
        return $class;
    }

    public static function index($field, $option){

    }

    public function string($length = 255)
    {
        $this->type = 'VARCHAR';
        $this->length = $length;
        return $this;
    }

    public function integer($length = 11)
    {
        $this->type = 'INT';
        $this->length = $length;
        return $this;
    }

    public function bigInt($length)
    {
        $this->type = 'BIGINT';
        $this->length = $length;
        return $this;
    }

    public function isNull($is_null)
    {
        $this->is_null = $is_null;
        return $this;
    }

    public function defaultValue($default_value)
    {
        $this->default_value = $default_value;
        return $this;
    }

    public function comment($comment)
    {
        $this->comment = $comment;
        return $this;
    }

    public function autoIncrement($auto_increment)
    {
        $this->auto_increment = $auto_increment;
        return $this;
    }

    public function build()
    {
        if ($this->field || $this->type) {
            return false;
        }
        $str = sprintf('`%s` %s', $this->field, $this->type);
        if ($this->length) {
            $str .= "({$this->length})";
        }
        if (!$this->is_null) {
            $str .= " IS NOT NULL";
        }
        if ($this->default_value !== false) {
            if (is_string($this->default_value)) {
                $str .= " DEFAULT '{$this->default_value}'";
            }
        }
        if ($this->comment) {
            $str .= " COMMENT '{$this->comment}'";
        }
        if ($this->auto_increment) {
            $str .= " AUTO_INCREMENT";
        }
        $str .= ";";
        return $str;
    }
}