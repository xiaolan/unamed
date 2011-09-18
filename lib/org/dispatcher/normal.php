<?php

/*
 * @author : Nemo.xiaolan
 * @created: 
 */

class NormalURLRouter extends URLRouter {
    
    static public function parseURL($url) {
        return $_GET ? $_GET : '';
    }
    
    static public function get_url($path, $params = null) {
        $paths = array_flip(array_flip(explode('.', $path)));
        
        list($controller, $action, $_params) = $paths;
        
        if(is_array($params)) {
            $_params = array_merge($params, $_params);
        }
        
        $i = 0;
        if($_params) {
            foreach($_params as $k=>$v) {
                if(!$k) {
                   $i+=1; 
                   $k = 'param_'.$i;
                   $query_string[] = sprintf("%s=%s", $k, $v);
                }
            }
            $query_string = '&'.implode('&', $query_string);
        }
        
        $action = $action ? "&action=".$action : '';
        
        return sprintf("%s/?controller=%s%s%s", ini('base.url_root'), $controller, $action, $query_string);
        
    }
    
}

?>
