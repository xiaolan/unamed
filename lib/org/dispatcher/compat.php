<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of compat
 *
 * @author xiaolan
 */
class CompatURLRouter extends URLRouter {
    
    static public function parseURL($url) {
        $url = str_ireplace(ini('base.url_root').'/', '', $url);
        $url = array_shift(explode('?', $url));
        $result = explode('/', end(explode('index.php', $url)));
        array_shift($result);
        return $result;
    }
    
    static public function get_url($path, $params = null) { }
    
}

?>
