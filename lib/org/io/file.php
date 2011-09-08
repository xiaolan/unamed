<?php

/**
 * @package lib.org.io.file
 * 
 */
Class FileIO {
    
    /**
     * 写入文件
     * @static FileIO::write()
     * @param string $file_name
     * @param string $content
     */
    static public function write($file_name, $content, $mode = 'w') {
        /**
         * 判断每一级目录是否存在， 不存在则创建
         */
        $dirs = explode(DS, $file_name);
        array_pop($dirs);
        $current_dir = IS_WIN ? '' : '/';
        foreach($dirs as $dir) {
            $current_dir.= $dir.DS;
            if(!is_dir($current_dir)) {
                @mkdir($current_dir, '0755');
            }
        }
        
        /**
         * 写入文件， 使用独占锁LOCK_EX
         */
        $fp = fopen($file_name, $mode);
        if (flock($fp, LOCK_EX)) {
            fwrite($fp, $content);
            flock($fp, LOCK_UN);
        }
        fclose($fp);
    }
    
    /**
     * 清空目录
     * @param string $dir 
     * @param boolean $recursion 是否递归删除目录
     * @param boolean $force 是否强制删除
     * @return 
     */
    static public function clear_dir($dir, $recursion = true, $force = true) {
        if(!is_dir($dir)) {
            return true;
        }
        if(IS_WIN) {
            $command = 'del /Q %s %s';
            $param = '';
            if($recursion) {
                $param .= ' /S ';
            }
            if($recursion) {
                $param .= ' /F ';
            }
        } else {
            if(substr($dir, -1, 1) !== '/') {
                $command = 'rm %s %s/*';
            } else {
                $command = 'rm %s %s*';
            }
            if($recursion) {
                $param = ' -r ';
            }
            if($force) {
                $param = ' -rf ';
            }
        }
        
        $command = sprintf($command, $param, $dir);
        return @exec($command) ? true : false;
    }
    
    static public function upload($key = "upload_file") {
        
    }
    
}
?>
