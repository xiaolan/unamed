<?php

class MemcacheCacheBackend extends CacheBackend implements CacheInterface{
    
    public function __construct($conf_key) {
        parent::__construct($conf_key);
        
        if(!$this->servers) {
            return false;
        }
        
        $this->instance = new Memcache();
        
        foreach($this->servers as $server) {
            $this->instance->addServer($server['host'], $server['port']);
        }
    }
    
    public function get($key) {
        $key = $this->get_key($key);
        return $this->instance->get($key);
    }
    
    public function set($key, $value, $life=null) {
        $key = $this->get_key($key);
        $life = $life ? $life : $this->life;
        if($this->force_replace) {
            $func = 'set';
        } else {
            $func = 'add';
        }
        return $this->instance->$func($key, $value, MEMCACHE_COMPRESSED, $life);
    }
    
    public function cached($key) {
        return $this->get($key);
    }
    
    public function clear($key) {
        $key = $this->get_key($key);
        return $this->instance->delete($key);
    }
    
    public function clear_all() {
        return $this->instance->flush();
    }
    
    private function get_key($key) {
        return $this->key_pre.$key;
    }
   
}
?>
