<?php

    return array(
        /**/
        'use_ssl'   => false,
        /**/
        'url_style' => 'compat',
        /**/
        'media_url' => 'http://127.0.0.1/unamed/statics/',
        /*theme*/
        'theme'     => $_GET['theme'] ? $_GET['theme'] : 'default',
        /*是否使用编译import文件*/
        'use_compile'   => true,
        /**
         * 是否使用i18n
         */
        'use_i18n'  => true,
        'language'  => 'en',
        'language_dir'=> 'dev.lang'
        
    );
    
    
?>
