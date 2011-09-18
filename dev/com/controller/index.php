<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of index
 *
 * @author xiaolan
 */
class IndexController {
    
    public function index() {
        
        $smarty = Template::init();
        $smarty->display('index/index.tpl');
    }
}

?>
