<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of smarty
 *
 * @author xiaolan
 */

import('lib.vendor.Smarty.Smarty');
import('lib.org.web.template_engine.smarty_plugins');

/**
 * @package lib.org.web.template.smarty.SmartyTemplateBackend
 */
class SmartyTemplateBackend extends Smarty {
    
    /**
     * SmartyTemplateBackend::init();
     * 
     * 实例化smarty, 调用载入smarty配置， 调用载入smarty常用插件
     * 
     * @access public
     * @return object $this
     */
    public function __construct() {
        parent::__construct();
        $this->configure();
        $this->load_common_plugins();
        return $this;
    }
    
    /**
     * 配置smarty， 并且合并基础smarty ini配置和模板中配置
     * 
     * @return void
     */
    private function configure() {
        $conf = import('conf.template');
        
        foreach($conf as $k=>$v) {
            $this->$k = $v;
        }
        
        if(!is_dir($this->template_dir)) {
            $this->template_dir = get_realpath('templates.default', '');
        }
        
        
        set_ini('template.smarty', $conf);
        /*
         * 合并ini配置文件到smarty配置目录
         */
        $this->assign('ini', ini());
        $this->merge_template_ini();
    }
    
    /*
     * 读取模板中配置，
     * /conf/smarty/*
     * /templates/CURRENT_TEMPLATE/conf/*
     * 并合并到/tmp/template_config/config.ini.php
     * 
     * @param string $filename = 'config.ini.php';
     */
    public function merge_template_ini($filename = 'config#ini') {
        $base_config_dir = MAIN_DIR.DS.'conf'.DS.'smarty'.DS;
        $template_config_dir = get_realpath('template.'.ini('base.theme').'._conf');
        
        if(!is_dir($template_config_dir)) {
            $template_config_dir = get_realpath('templates.default._conf', '');
        }
        
        $contents = array(
            $this->get_ini_content($base_config_dir),
            $this->get_ini_content($template_config_dir)
        );
        if(!$contents) {
            return false;
        }
        $output = get_realpath('tmp.template_config.'.$filename);
        $contents = preg_replace('/;(.*)/i', '', implode("\r\n", $contents));
        file_put_contents($output, $contents);
        
    }
    
    private function get_ini_content($dir) {
        $handle = opendir($dir);
        while(false !== ($file = readdir($handle))) {
            $f_name = explode('.', $dir.$file);
            if(!is_file($dir.$file) || end($f_name) != 'ini') {
                continue;
            }
            $data = parse_ini_file($dir.$file, true);
            $str = '';
            foreach($data as $section=>$d) {
                if(is_array($d)) {
                    $str.= "[{$section}]\r\n";
                    foreach($d as $k=>$v) {
                        $str.= "{$k} = {$v}\r\n";
                    }
                } else {
                    $str.= "{$section} = {$d}\r\n";
                }
            }
        }
        
        closedir($handle);
        return $str;
    }
    
    /*
     * 载入常用的smarty插件
     */
    private function load_common_plugins() {
        $this->registerPlugin('function', 'url', 'smarty_function_url');
    }
    
}

?>