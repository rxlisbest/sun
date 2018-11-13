<?php
/**
 * Created by PhpStorm.
 * User: ruixinglong
 * Date: 2018/9/12
 * Time: 上午9:38
 */

namespace Rxlisbest\Sun\Core;


class Container
{
    public static function getInstance($class, $params)
    {
        if (empty($params)) {
            return new $class();
        } else {
            $reflection = new \ReflectionClass($class);
            $contructor = $reflection->getConstructor();
            $default_params = $contructor->getParameters();
            $args = [];
            foreach ($default_params as $k => $v) {
                if (isset($params[$k])) {
                    $args[] = $params[$k];
                } else {
                    if ($v->isDefaultValueAvailable()) {
                        $args[] = $v->getDefaultValue();
                    } else {
                        $args[] = null;
                    }
                }
            }
            return $reflection->newInstanceArgs($args);
        }
    }
}