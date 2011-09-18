<?php

/**
 * 实现简易的插件机制
 * 
 * @package lib.org.pluggable
 */
class Pluggable {

    static public $hooks = array();

    static public $plugins = array();
    
    static public function init() {}

    /**
     * Pluggable::register()
     * @param array $callable
     * @param string $hook
     * @return void
     *
     */
    static public function register($callable, $hook) {
        list($class, $method,) = $callable;
        $package = 'dev.org.plugins.'.strtolower($callable);
        self::$plugins[$hook] = array($class, $method, $package);
    }

    /**
     * Pluggable::trigger();
     *
     * @param $hook string
     * @return void
     *
     * trigger the hook
     */
    static public function trigger($hook) {
    	
    }

}

?>
