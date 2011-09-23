<?php

/**
 * RolePermission => rbac_role_permission
 * */
class RolePermission extends BaseModel {
    
    
    public function set() {}
    
    /**
     * 检测角色是否有权限进行某操作
     * */
    public function check($node, $operation, $role_ids) {
        
        /**
         * 检测配置中allow字段无需认证的
         * */
        $conf = import('dev.org.extension.conf#ini');
        $allows = explode(',', $conf['allow']);
        if($allows) {
            foreach($allows as $v) {
                $v = trim($v);
                if(substr($node, 0, strlen($v)) == $v) {
                    return true;
                }
            }
        }
        
        $data = $this->get_by_role_and_operation($operation, $role_ids);
        /**
        * 不存在相应的操作和角色对应数据时
        * */
        if(!$data) {
            return false;
        }
        
        if(in_array($node, $data)) {
            return true;
        }
        
        /**
         * 父节点有权限时  子节点皆有权限
         * */
        foreach($data as $v) {
            if(substr($node, 0, strlen($v['node'])) == $v['node']) {
                return true;
            }
        }
        return false;
    }
    
    
    /**
     * 根据CRUD权限和角色ID获得
     * 
     * @param string $operation => CRUD
     * @param array $role_ids
     * @return array $data
     * */
    public function get_by_role_and_operation($operation, $role_ids) {
        
        if($role_ids && is_array($role_ids)) {
            $role_ids = implode(',', $role_ids);
        } else {
            return false;
        }
        $role_ids = '0,'.$role_ids;
        
        $operation = str_ireplace(str_split($operation), '1', 'CRUD');
        $operation = preg_replace('/[a-zA-Z]+/i', '_', $operation);
        
        
        $sql = sprintf("SELECT rp.*, n.title, n.node FROM rbac_role_permission rp 
        			LEFT JOIN rbac_node n ON n.id=rp.node_id WHERE rp.operation 
        			LIKE '%s' AND rp.role_id IN(%s)", $operation, $role_ids);
        
        foreach($this->db->query($sql) as $v) {
            $data[] = $v;
        }
        
        return $data;
        
    }
    
    public function get_by_uid($uid) {
        if(!$uid) {
            return false;
        }
        
        $sql = sprintf("SELECT rid FROM rbac_role_user WHERE uid = '%d'", $uid);
        
        foreach($this->db->query($sql) as $v){
            $role_ids[] = $v['rid'];
        }
        
        
        
    }
    
}