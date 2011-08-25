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
    	import('dev.com.object.member');
    	$member = get_instance_of('Member');
    	$member->access_forbidden();
        $smarty = Template::init();
        $smarty->display('index/index.tpl');
        
    }
}

?>
