<?php
/**
 * Created by PhpStorm.
 * User: ruixinglong
 * Date: 2018/9/12
 * Time: 上午10:58
 */

namespace Rxlisbest\Sun\Core;

use Rxlisbest\Sun\Core\Container;

class Factory
{
    private $_singletons;

    public function get($class, $params = [])
    {
        return $this->build($class, $params);
    }

    public function getSingleton()
    {
        if (isset($this->_singletons[$class])) {
            return $this->_singletons[$class];
        }
        $this->_singletons[$class] = $this->build($class, $params);
        return $this->_singletons[$class];
    }

    private function build($class, $params)
    {
        return Container::getInstance($class, $params);
    }
}