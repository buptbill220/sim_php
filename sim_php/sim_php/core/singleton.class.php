<?php
class Singleton extends Base {
    public static function getInstance($class) {
        static $instances = array();
        if (!isset($instances[$class])) {
            if (method_exists($class, 'getInstance')) {
                $instances[$class] = $class::getInstance();
            }
            else {
                $instances[$class] = &new $class;
            }
        }
        $instance = &$instances[$class];
        return $instance;
    }
}
