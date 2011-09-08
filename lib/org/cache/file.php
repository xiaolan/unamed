<?php

/**
 * @package lib.org.cache.file
 * @see lib.bin.cache.CacheInterface
 */
class FileCacheBackend extends CacheBackend implements CacheInterface{
    
    public $cache_prefix = 'tmp.runtime.cache.';
    
    public $cache_life;
    
    public $content_prefix = '<?php /* Cached By Unamed PHP Framework*/ die();?>';
    
    public function set($key, $value) {
        import('lib.org.io.file');
        $content = $this->content_prefix.serialize($value);
        return FileIO::write($this->get_cache_path($key), $content);
    }
    
    public function get($key) {
        if(!$this->cached($key)) {
            return false;
        }
        $content = str_ireplace($this->content_prefix, '', 
                            file_get_contents($this->get_cache_path($key)));
        return unserialize($content);
    }
    
    public function cached($key) {
        return file_exists_case($this->get_cache_path($key));
    }
    
    public function clear($key) {
        return @unlink($this->get_cache_path($key));
    }
    
    public function clear_all() {
        import('lib.org.io.file');
        FileIO::clear_dir(get_realpath($this->cache_prefix, ''));
    }
    
    private function get_cache_path($key) {
        return get_realpath($this->cache_prefix.'~'.$key);;
    }
    
}
?>
