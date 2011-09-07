<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * @package lib.bin.compile
 * 
 * 两种解决方案： 1. 设定所有可以缓存的文件 2. 即时缓存 通过import()引入的文件都缓存
 * 
 */
class Compiler {
    
    /**
     * 需要编译的文件
     */
    static private $compiled = array();
    
    static private $file_name= 'tmp.runtime.~compiled';
    
    static private $cache_key = 'compiled_files';
    
    static private $runtime_cache = null;

    static public function init() {
        
        /**
         * 读取runtime缓存
         */
        import('lib.bin.cache');
        
        Cache::init('runtime');
        self::$runtime_cache = Cache::init('runtime');
        if(self::$runtime_cache->cached(self::$cache_key)) {
            self::$compiled = self::$runtime_cache->get(self::$cache_key);
            
        }
        
        if(!self::$compiled) {
            $compiled = import('conf.compile');
            foreach($compiled as $v) {
                self::compile_file($v);
            }
            set_ini('compiled', self::$compiled);
        }
        
        self::work();
        
        import(self::$file_name);
        /**
         * 注册程序结束时候的事件
         */
        //register_shutdown_function(array('Compiler', 'work'));
    }
    
    /**
     * 程序结束时将编译过的文件列表写入缓存
     * @todo 在第一次写入编译文件时会在等待磁盘IO时重复刷新
     */
    static public function work() {
        if(self::expire() && ini('base.use_compile')) {
            return true;
        }
        
        $now = date('Y-m-d H:i:s', time());
        $output_content = "<?php /* Compiled By Unamed PHP Framework. Generated on {$now} */ ";
        foreach(self::$compiled as $v) {
            $content = trim(php_strip_whitespace($v['file_path']));
            $content = substr($content, 6, strlen($content));
            if ('?>' == substr($content, -2)) {
                $output_content.= substr($content, 0, -2);
            } else {
                $output_content.= $content;
            }
        }
        
        /**
         * 写入编译缓存
         */
        $cache_path = get_realpath(self::$file_name);
        $fp = fopen($cache_path, 'w');
        if(flock($fp, LOCK_EX)) {
            fwrite($fp, $output_content);
            if(flock($fp, LOCK_UN)) {
                /**
                 * 将已编译的文件写入缓存
                 */
                self::$runtime_cache->set(self::$cache_key, self::$compiled);
                /**
                 * 第一次写入编译文件， 休眠3秒以保证文件完全写入
                 * 重新载入页面， 使编译文件生效
                 */
                sleep(3);
                echo <<<EOF
            <script type="text/javascript">window.location.reload();</script>
EOF;
            }
        }
        fclose($fp);
    }
    
    static public function expire() {
        $not_expired = false;
        foreach(self::$compiled as $k=>$v) {
            if(md5_file($v['file_path']) !== $v['hash']) {
                $not_expired = true;
                break;
            }
        }
        if(!$not_expired && file_exists_case(get_realpath(self::$file_name))) {
            $not_expired = true;
        } else {
            $not_expired = false;
        }
        return $not_expired;
    }
    
    /**
     * 查看是否已经编译
     */
    static public function is_compiled($package) {
        return key_exists($package, self::$compiled);
    }
    
    /**
     * 运行时编译 写入需编译文件列表
     */
    static public function compile_file($package) {
        if(!key_exists($package, self::$compiled)) {
            $file_path = get_realpath($package);
            if(!file_exists_case($file_path)) {
                return false;
            }
            self::$compiled[$package] = array(
                'hash' => md5_file($file_path),
                'file_path'=> $file_path
            );
        }
    }

    
}
?>