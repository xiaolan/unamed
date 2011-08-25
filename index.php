<?php
/*
 * 程序入口
 */


/**/
define('IN_APP', true);

/**/
define('DS', DIRECTORY_SEPARATOR);

/*
 * 入口文件夹， 包含index.php和statics
 */
define('ENTRY', dirname(__FILE__));

/*
 * 主程序存放目录
 */
define('MAIN_DIR', dirname(__FILE__));

/*
 * 是否windows服务器
 */
define('IS_WIN', !strncasecmp(PHP_OS, 'win', 3));

header('Build-on: Unamed PHP Framework');

require('./common_func.php');

/*
 * 导入基础配置和常用函数
 */
import('lib.vendor.ThinkPHP.functions');
import('lib.vendor.ThinkPHP.extend');
import('lib.org.shortcuts.ini');
set_ini('base', import('conf.base'));


/*
 * 运行时配置， 并缓存
 */

/*
 * 根据URL配置， 调用相应的URL解析
 */
import('lib.org.dispatcher.factory');
/*
 * 获取URL根路径
 */
DispatcherFactory::set_baseurl();
DispatcherFactory::work(ini('base.url_style'));
    
?>
