<?php

/**
 * Description of index
 *
 * @author xiaolan
 */
class IndexController {
    
    public function index() {
        
        RBAC::need_login();
        
        $smarty = Template::init();
        $smarty->display('index/index.tpl');
    }
}
