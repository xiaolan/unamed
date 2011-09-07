<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class FileCacheBackend extends CacheBackend implements CacheInterface{
    
    public $cache_prefix = 'tmp.runtime.cache.';
    
    public $cache_life;
    
    public $file_prefix = '<?php /* Cached By Unamed PHP Framework*/ die();?>';
    
    public function set($key, $value) {
        $fp = fopen($this->get_cache_path($key), 'w');
        if (flock($fp, LOCK_EX)) {
            fwrite($fp, $this->file_prefix.serialize($value));
            flock($fp, LOCK_UN);
        }
        fclose($fp);
        return;
    }
    
    public function get($key) {
        if(!$this->cached($key)) {
            return false;
        }
        $content = str_ireplace($this->file_prefix, '', 
                            file_get_contents($this->get_cache_path($key)));
        return unserialize($content);
    }
    
    public function cached($key) {
        return file_exists_case($this->get_cache_path($key));
    }
    
    private function get_cache_path($key) {
        return get_realpath($this->cache_prefix.'~'.$key);;
    }
    
}
?>
