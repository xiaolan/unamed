<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

if(!interface_exists('CacheInterface')) {
    Interface CacheInterface {
    
        public function set($key, $value);

        public function get($key);

        public function cached($key);

    }
}


if(!class_exists('CacheBackend')) {
    class CacheBackend {
        public function __construct($conf_key) {
            if(ini('cache.'.$conf_key)) {
                foreach(ini('cache.'.$conf_key) as $k=>$v) {
                    $this->$k = $v;
                }
            }
        }
    }
}

if(!class_exists('Cache')) {
    class Cache {
        static public function init($driver = 'file') {
            if(!ini('cache')) {
                set_ini('cache', import('conf.cache'));
            }
            import('lib.org.cache.'.$driver);
            return singleton('lib.org.cache.'.$driver, '', $driver, 'CacheBackend');
        }
    }
}

?>
