<?php

/**
 * Description of index
 *
 * @author xiaolan
 */
class IndexController {
    
    public function index() {
        
        $node = sprintf("%s.%s.%s", ini('runtime.object'), ini('runtime.action'), 1);
        $operation = "uc";
        
        RBAC::has_permission($node, $operation, $role_id);
        
        exit;
        
    	
//     	import('lib.bin.log');
//     	$log = Log::init();
    	
//     	$log->write(array(
//     		'errno'=> 1121,
//     		'file'=> __FILE__,
//     		'line'=> __LINE__ ,
//     		'message'=> 'oops~ has been guier lede~'
//     	));
        
        $smarty = Template::init();
        $smarty->display('index/index.tpl');
    }
}

?>
