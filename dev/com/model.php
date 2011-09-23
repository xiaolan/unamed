<?php

/**
 * 所有的Model均可继承此类
 * 
 * 定义了一个抽象方法 用于规定table name， 并且提供了一些基础的通用CRUD方法， 开发者可
 * 以在Model中重写或者扩展这些方法
 * */
abstract class BaseModel {
    
    /**
     * 使用的主表名
     * */
    private $table;
    
    /**
     * 表前缀等
     * */
    private $prefix;
    
    /**
     * 当前数据库连接对象
     * */
    protected $db;
    
    public function __construct() {
        import('lib.bin.database');
        $this->db = Database::init();
    }
    
    /**
     * 抽象方法 继承此类必须实现此方法
     * */
    abstract protected function set();
    
    
    
    /**
     * 
     * */
    public function read($cond = "WHERE TRUE") {}
    
    public function create($data) {}
    
    public function update($id, $data) {}
    
    public function delete($id) {}
    
    public function genreate_sql($sql) {
        
    }

}