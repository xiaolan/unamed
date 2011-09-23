<?php

    return array(
        /**
         * 是否使用加密连接
         */
        'use_ssl'   => false,
        /**
         * URL样式， 默认可使用三种值：
         * normal: index.php?param=a&param1=b
         * compat: index.php/a/b/
         * pathinfo: /a/b/ //需要rewrite支持
         */
        'url_style' => 'normal',
        /**
         * 静态文件路径
         * 这里注意，尤其是在compat和pathinfo模式下， 最好使用绝对路径
         */
        'media_url' => '/unamed/statics/',
        /**
         * 使用某个主题， 当存在$_GET['theme']时使用
         */
        'theme'     => $_GET['theme'] ? $_GET['theme'] : 'default',
        /**
         * 是否使用编译import文件
         */
        'use_compile'   => true,
        /**
         * 是否使用i18n
         */
        'use_i18n'    => true,
        'i18n_engine' => 'default',
        'language'    => 'cn',
        'language_dir'=> 'dev.lang',
        
        /**
         * 日志
         * pack_size 以kb为单位
         */
        'log' => array(
            'error_enable' => true,
            'save_path' => 'dev.log',
            'pack_size' => 1024,
            'log_fields'=> array(
				'time', 'errno', 'file', 'line', 'message'
			)
        ),
        
        /**
         * 上次文件设置
         */
        'uploads' => array(
            'target'=> 'statics.uploads',
            /**
             * 是否使用子目录
             */
            'subdir'=> true,
            /**
             * 子目录模式， 每年，每月，或者每天
             */
            'subdir_type' => 'month',
            /**
             * 命名方式
             */
            'name_rule'=> 'Ymd[UNIQUE]',
        )
        
    );
    
    
?>
