<?php

/**
 * Cross Site Request Forgery
 * 防止跨站伪造请求攻击， 可以配合注册smarty modifier
 */
class CSRF {
    
    static public $token;
    
    static public $session_key;
    
    static public function init($key = 'CSRF_TOKEN') {
        self::$session_key = $key ? $key : 'CSRF_TOKEN';
        
        import('lib.bin.session');
        Session::start();
        self::$token = $_SESSION[self::$session_key];
    }
    
    /**
     * 生成MD5字符串
     * */
    static public function generate() {
        self::$token = $_SESSION[self::$session_key] = md5(CURRENT_TIMESTAMP);
        return self::$token;
    }
    
    static public function check($data) {
        return $data === self::$token;
    }
    
}

?>
