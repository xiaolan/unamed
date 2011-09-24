<?php

/**
 * Auth扩展， 使用RBAC
 * 
 * @package dev.org.extension.auth.controller.AuthController
 * */
class AuthController {
    
    private $user;
    
    private $smarty;
    
    public function __construct() {
        import('dev.org.extension.model.user');
        $this->user = get_instance_of('RBACUser');
        
        $this->smarty = Template::init();
        $this->smarty->assign('base_template_dir', $this->smarty->template_dir);
        $this->smarty->assign('layout', $this->smarty->template_dir.
                            DS.'_layouts'.DS.'base_layout.tpl');
        $this->smarty->template_dir = dirname(__FILE__).DS.'templates';
    }
    
    /**
     * 登录
     * */
    public function login() {
        if($this->user->is_authenticated()) {
            //redirect
            r('index');
        }
        
        import('lib.org.web.html.form');
        $form = new NormalForm($_POST);
        $form->fields = array(
            'username'=> array(
                'type' => 'text',
                'required' => true,
                'minLength'=> 6,
                'maxLength'=> 20
            ), 
            'password'=> array(
                'type' => 'password',
                'required' => true
            )
        );
        
        if(is_post()) {
            $valid_result = $form->valid();
            if(true !== $valid_result) {
                $this->smarty->assign('error_message', $valid_result);
            } else {
                $auth = $this->user->authenticate($form->cleaned_data['username'],
                                          $form->cleaned_data['password']);
                if(true !== $auth) {
                    r('index');
                } else {
                    $this->smarty->assign('error_message', $auth);
                }
            }
        }
        
        $this->smarty->assign('login_form', $form);
        $this->smarty->assign('CSRF_TOKEN', CSRF::generate());
        $this->smarty->display('login.tpl');
    }
    
    /**
     * 注册
     * */
    public function register() {}
    
    /**
     * 退出登录
     * */
    public function logout() {}
    
}