<?php

/*
 * @author : Nemo.xiaolan
 * @created: 
 */

class PathinfoURLRouter extends URLRouter {
    
    static public function parseURL($url) {
        $base_url_len = strlen(ini('base.url_root'));
        $url = substr($url, $base_url_len+1, strlen($url)-$base_url_len-2);
        
        return explode('/', $url);
    }
    
    static public function get_url($path, $params = null) {
        $path = str_replace('.', '/', $path);
        return ini('base.url_root').'/'.$path.'/';
    }
    
}
?>
