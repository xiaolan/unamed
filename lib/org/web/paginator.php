<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


class Paginator {
    
    public $db_handler = false;
    
    public $items = array();
    
    public $current_page   = 1;
    
    public $per_page_size  = 20;
    
    public $total_pages    = 1;
    
    public $total_display_pages = 10;
    
    public $display_pages  = 10;
    
    public $total_rows     = 0;
    
    public $pages_range    = array();
    
    public $size;
    
    public $display_start  = 1;
    
    public $has_next = false;
    
    public $has_previous = false;
    
    public function __construct($db_handler, $page = 1, $size = 10) {
        $this->db_handler = $db_handler;
        $this->current_page = intval($page) > 0 ? intval($page) : 1;
        $this->per_page_size = $size ? $size : $this->per_page_size;
        $this->size = $size;
    }
    
    /*
     * 生成分页的SQL， 并且计算相关分页的值
     */
    public function get_paginator_sql($sql, $total = null) {
        if(!$total) {
            $get_total_sql = preg_replace('/SELECT (.*?) FROM/i', 'SELECT COUNT(*) FROM', $sql);
            $rs = $this->db_handler->query($get_total_sql);
            if($rs) {
                $count = $rs->fetch();
                $this->total_rows = $count[0] ? $count[0] : 0;
                if(!$this->total_rows) {
                    return $sql;
                }
            } else {
                $this->total_rows = 0;
            }
        } else {
            $this->total_rows = $total;
        }
        
        $this->total_pages = ceil($this->total_rows/$this->per_page_size);
        $this->total_display_pages = $this->total_pages > $this->display_pages ? $this->display_pages : $this->total_pages;
        
        /*
         * page range的开始和结束
         */
        if($this->total_pages <= $this->total_display_pages) {
            $this->display_start = 1;
            $this->display_end   = $this->total_pages;
        } else {
            if($this->current_page > $this->total_display_pages/2-1){
                $this->display_start = $this->current_page - $this->total_display_pages/2 - 1;
                $this->display_end = $this->display_start+$this->total_display_pages;
            } else {
                $this->display_start = 1;
                $this->display_end   = $this->total_display_pages;
            }
        }
        
        $this->display_start = $this->display_start <= 0 ? 1 : $this->display_start;
        $this->display_end = $this->display_end > $this->total_pages ? $this->total_pages : $this->display_end;
        
        if($this->display_end - $this->display_start < $this->total_display_pages) {
            $this->display_start = $this->display_end - $this->total_display_pages;
        }
        if($this->display_end > $this->total_display_pages) {
            $this->display_end = $this->display_start+$this->total_display_pages;
        }
        $this->display_start = $this->display_start <= 0 ? 1 : $this->display_start;
        $this->display_end = $this->display_end > $this->total_pages ? $this->total_pages : $this->display_end;
        $this->display_end = $this->display_end <=0 ? 1 : $this->display_end;
        
        if($this->current_page > 1) {
            $this->has_previous = true;
            $this->previous = $this->current_page-1;
        }
        
        if($this->current_page < $this->total_pages) {
            $this->has_next = true;
            $this->next     = $this->current_page+1;
        }
        
        $this->pages_range = range($this->display_start, $this->display_end);
        
        $limit = ($this->current_page - 1) * $this->size;
        
        $sql .= " LIMIT $limit,{$this->per_page_size}";
        $this->sql = $sql;
    }
    
    public function work($sql, $total = null) {
        if(false === strstr($_SERVER['REQUEST_URI'], '?')) {
            $this->page_param = $_SERVER['REQUEST_URI'].'?page=';
        } else {
            $_SERVER['REQUEST_URI'] = preg_replace('/&page=\d/i', '', $_SERVER['REQUEST_URI']);
            $this->page_param = $_SERVER['REQUEST_URI'].'&page=';
        }
        $this->get_paginator_sql($sql, $total);
        foreach($this->db_handler->query($this->sql) as $row) {
            $this->items[] = $row;
        }
    }
    
}
?>
