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
class Member{
	
	public $db_instance;
	
	public function init_db() {
		$this->db_instance = Database::init('pdo');
	}
    
    public function is_authenticated() { }
    
    public function authenticate($username, $password) { }
    
    public function register($username, $email) { }
    
    /*
     * @access public
     * */
    public function access_forbidden($http_status = '404') {
    	send_http_status($http_status);exit;
    }
    
}

?>
