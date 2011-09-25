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
        
        /**
         * 动态修改smarty的模板目录
         * */
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
            r('index');
        }
        
        import('lib.org.web.form.form');
        $form = new BaseForm($this->smarty, $_POST);
        $form->fields = array(
            'username'=> array(
                'type' => 'text',
                'required' => true,
                'minlength'=> 6,
                'maxlength'=> 20,
                'placeholder'=> 'Enter your username',
                'label'=> '用户名/邮箱'
            ), 
            'password'=> array(
                'type' => 'password',
                'required' => true,
                'label'=> '密码'
            )
        );
        
        if(is_post()) {
            if(true != $form->is_valid()) {
                $this->smarty->assign('error_message', $form->messages);
            } else {
                $auth = $this->user->authenticate($form->cleaned_data['username'],
                                          $form->cleaned_data['password']);
                if(true !== $auth) {
                    $this->smarty->assign('error_message', $auth);
                } else {
                    r('index');
                }
            }
        }
        
        $this->smarty->assign('login_form', $form->output());
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