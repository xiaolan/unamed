<?php

/**
 * RBAC: 基于角色的权限控制
 * 
 * 只涉及角色， 节点， 权限。 不涉及到用户！
 * 角色：用户可以拥有多个角色
 * 节点：为controller+action[+category][+id]的节点
 * 权限：为CRUD权限 表示为：0100
 * 
 * 本类封装了一些常用model操作
 * 
 * @package dev.org.extension.RBAC.RBAC 
 * */
class RBAC {
    
    static protected $role_id;
    
    static protected $user;
    
    static public $session = array();
    
    static public function init() {
        import('dev.org.extension.auth.model.user');
        self::$user = get_instance_of('RBACUser');
    }
    
    /**
     * 需要登录
     * 
     * @param string $role
     * @return boolean
     * */
    static public function need_login($role = null) {
        
        if(!self::$user->is_authenticated()) {
            return false;
        }
        
        if($role && !in_array($role, self::$user['roles'])) {
            return false;
        }
        
        return true;
    }
    
    /**
     * 根据角色ID和需进行操作节点判断是否有权限进行操作
     * 拥有父节点的权限则子权限继承， 无父节点权限则检测子节点权限
     * 
     * @param integer $node_id
     * @param string $operation 操作权限为CRUD
     * @param integer $role_id 
     * @return boolean
     * */
    static public function has_permission($node, $operation, $role_ids = array()) {
        import('dev.org.extension.auth.model.role_permission');
        /**
         * $rp = role_permission
         * */
        $rp = get_instance_of('RolePermission');
        return $rp->check($node, $operation, $role_ids);
    }
    
    
    
}