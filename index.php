<?php
    /**
     * 定义运行环境
     * 建议可选： devel, test, deploy 主要对应conf.RUN_MODE.*下的配置文件
     * @const RUN_MODE
     */
    define('RUN_MODE', 'devel');
    
    error_reporting(E_ALL^E_NOTICE);

    require './lib/entry.php';
    
?>