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
        $paths = explode('.', $path);
        foreach($paths as $k=> $p) {
            $val = trim($p);
            if($val) {
               $_paths[$k] = $val; 
            }
        }
        list($controller, $action, $_params) = $paths;
        
        $_params = !is_array($_params) ? array($_params) : $_params;
        
        if(is_array($params)) {
            $_params = array_merge($params, $_params);
        }
        
        $i = 0;
        if($_params && is_array($_params)) {
            foreach($_params as $k=>$v) {
                if(!trim($v)) {
                    continue;
                }
                if(!$k) {
                   $i+=1; 
                   $k = 'param_'.$i;
                }
                $query_string[] = sprintf("%s=%s", $k, $v);
            }
        }
        
        if($params && !is_array($params)) {
            foreach(explode('&', $params) as $p) {
                $query_string[] = $p;
            }
        }
        
        if($query_string) {
            $query_string = '&'.implode('&', $query_string);
        }
        
        $action = $action ? "&action=".$action : '';
        
        return sprintf("%s/?controller=%s%s%s", ini('base.url_root'), 
                                    $controller, $action, $query_string);
        
    }
    
}

?>
