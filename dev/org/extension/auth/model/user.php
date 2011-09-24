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
        if(is_email($username_or_email)) {
            $field = 'email';
        } else {
            $field = 'username';
        }
        
        $sql = "SELECT ru.* , rru.* , rr.id AS role_id, rr.name AS role_name, ru.*
                FROM rbac_role rr, rbac_user ru
                LEFT JOIN rbac_role_user rru ON rru.uid = ru.id
                WHERE rr.id = rru.rid AND ru.%s = '%s'";
        
        $sql = sprintf($sql, $field, $username_or_email);
        
        $data = array();
        foreach($this->db->query($sql) as $row) {
            if($data) {
                $data['roles'][$row['role_id']] = $row['role_name'];
            } else {
                $data['username'] = $row['username'];
                $data['email'] = $row['email'];
            }
        }
        
        list($rand_string, $start, $length) = explode('__', $row['password']);
        
        if($this->generate_password($password, $start, $length) === $row['password']) {
            import('lib.bin.session');
            Session::start();
            $this->info = $_SESSION['user'] = $data;
            return true;
        }
        
        return _g("Username/email or password wrong");
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
    
    
    /********************/
    private function generate_password($password, $start = null, $length = null) {
        $length = $length ? $length : rand(18, 25);
        $start = $start ? $start : rand(0, 32-$length);
        $password = substr(md5($password), $start, $length);
        return sprintf("%s__%s__%s", $password, $start, $length);
    }
    
}