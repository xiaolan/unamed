<?php

/**
 * @package lib.bin.cache.CacheInterface
 */
if(!interface_exists('CacheInterface')) {
    /*
    public function get($key) {}
    public function set($key, $value) {}
    public function cached($key) {}
    public function clear($key) {}
    public function clear_all() {}
    */
    Interface CacheInterface {
    
        /**
         * 写缓存
         * 
         * @param string $key
         * @param mixed $value
         * @param integer $life 缓存存活时间
         * @return void
         */
        public function set($key, $value, $life=null);

        /**
         * 获得缓存
         * 
         * @param string $key
         * @return mixed
         */
        public function get($key);

        /**
         * 是否已经缓存
         * @param string $key
         * @return boolean
         */
        public function cached($key);
        
        /**
         * 清除缓存
         * @param string $key
         * @return boolean
         */
        public function clear($key);
        
        /**
         * 清除所有缓存
         * @return boolean
         */
        public function clear_all();

    }
}

/**
 * @package lib.bin.cache.CacheBackend
 */
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

/**
 * @package lib.bin.cache.Cache
 */
if(!class_exists('Cache')) {
    class Cache {
        /**
         * 通过单件模式 调用缓存实例
         * 
         * @param string $driver
         * @return object instance of some cache backend
         */
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
