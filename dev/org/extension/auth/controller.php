<?php

/**
 * Auth扩展， 使用RBAC
 * 
 * @package dev.org.extension.auth.controller.AuthController
 * */
class AuthController {
    
    private $user;
    
    public function __construct() {
        import('dev.org.extension.model.user');
        $this->user = get_instance_of('RBACUser');
    }
    
    /**
     * 登录
     * */
    public function login() {}
    
    /**
     * 注册
     * */
    public function register() {}
    
    /**
     * 退出登录
     * */
    public function logout() {}
    
}