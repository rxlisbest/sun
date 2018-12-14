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
    private $type;
    private $length;
    private $is_null;
    private $default_value;
    private $comment = '';

    public function string($length = 255)
    {
        $this->type = 'string';
        $this->length = $length;
        return $this;
    }

    public function integer($length)
    {
        $this->type = 'integer';
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

    public function build()
    {
        return sprintf('%s %s(%s) %s', );
    }
}