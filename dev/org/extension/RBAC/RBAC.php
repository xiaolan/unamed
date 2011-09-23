<?php

/**
 * RBAC: 基于角色的权限控制
 * 
 * 只涉及角色， 节点， 权限。 不涉及到用户！
 * 角色：用户可以拥有多个角色
 * 节点：为controller+action[+category][+id]的节点
 * 权限：为CRUD权限 表示为：0100
 * 
 * @package dev.org.extension.RBAC.RBAC 
 * */
class RBAC {
    
    static private $role_id;
    
    static private $operation = "CRUD";
    
    public function init($role_id) {
        self::$role_id = $role_id;
    }
    
    /**
     * 当前登录用户的信息
     * */
    public function mine() {}
    
    /**
     * 根据角色ID获取所有的权限
     * 
     * RBAC::get_permission()
     * 
     * @param integer $role_id
     * @return array
     * */
    static public function get_permission($role_id = null) {
    	$role_id = $role_id ? $role_id : self::$role_id;
    }
    
    /**
     * 根据角色ID和需进行操作节点判断是否有权限进行操作
     * 
     * @param integer $node_id
     * @param string $operation 操作权限为CRUD
     * @param integer $role_id* 
     * @return boolean
     * */
    static public function has_permission($node, $operation, $role_id = null) {
        $operation = str_split($operation);
        $operation = str_ireplace($operation, '1', self::$operation);
        $operation = preg_replace();
        
        import('dev.org.extension.RBAC.role_permission');
        
        echo $operation;
        
    }
    
    
    
}