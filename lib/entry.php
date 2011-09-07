<?php
/*
 * 程序入口
 */

define('IN_APP', true);

define('DS', DIRECTORY_SEPARATOR);

/**
 * 入口文件夹， 包含index.php和statics
 */
define('ENTRY', dirname(dirname(__FILE__)));

/**
 * 主程序存放目录
 * 主要是lib
 */
define('MAIN_DIR', dirname(dirname(__FILE__)));

/**
 * 是否windows服务器
 */
define('IS_WIN', !strncasecmp(PHP_OS, 'win', 3));

header('Build-on: Unamed PHP Framework');
require(MAIN_DIR.DS.'lib'.DS.'common_func.php');


//编译文件
import('lib.bin.compiler');
/**
 * 导入基础配置和常用函数
 */
import('lib.org.shortcuts.ini');
set_ini('base', import('conf.base'));
Compiler::init();
/*
 * 运行时配置， 并缓存(使用基础文件缓存)
 */

import('lib.vendor.ThinkPHP.functions');
import('lib.vendor.ThinkPHP.extend');
/*
 * 根据URL配置， 调用相应的URL解析
 */
import('lib.bin.dispatcher');
/*
 * 获取URL根路径
 */
DispatcherFactory::set_baseurl();
/**
 * URL分发器工作
 */
DispatcherFactory::work(ini('base.url_style'));
    
?>
