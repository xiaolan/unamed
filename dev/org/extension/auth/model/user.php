<?php

class RBACUser extends BaseModel {
    
    public $is_authenticated = false;
    
    /**
     * 用户信息
     * */
    public $info = array();
    
    public function set() {}
    
    public function __construct() {
        parent::__construct();
        import('lib.bin.session');
        Session::start();
    }
    
    /**
     * 认证
     * 
     * @param string $username_or_email
     * @param string $password
     * @param string $field username | email
     * */
    public function authenticate($username_or_email, $password) {
        
    }
    
    /**
     * 新用户注册
     * */
    public function register($username, $email, $password) {}
    
    /**
     * 是否已经登录
     * */
    public function is_authenticated() {
        if($this->is_authenticated) {
            return true;
        }
        
        if($_SESSION['user']) {
            $this->is_authenticated = true;
            $this->info = $_SESSION['user'];
            return true;
        }
        
        return false;
    }
    
    public function logout() {
        unset($_SESSION['user']);
        $this->is_authenticated = false;
        $this->info = array();
    }
    
    
}