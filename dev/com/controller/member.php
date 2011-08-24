<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of member
 *
 * @author xiaolan
 */
class MemberController {
    
    public function login() {
        
    }
    
    public function register() {
        $smarty = Template::init('smarty');
        
        $smarty->display();
    }
    
    public function oauth() {
        
    }
    
}

?>
