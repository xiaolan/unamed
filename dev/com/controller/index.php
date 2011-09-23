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
        
        $role_ids = array(1,2,3);
        
        
        $smarty = Template::init();
        $smarty->display('index/index.tpl');
    }
}

?>
