<?php

/**
 * 缓存配置
 * 
 * 缓存时间以秒计算
 */

return array(
    'runtime' => array(
        'dir' => 'tmp.runtime',
        'life'=> 36000
    ),
    
    'file'    => array(
        'life'=> 36000
    ),
    
    'xcache'  => array(),
    
    'memcache'=> array(
        'servers'=> array(
            array('host'=> 'localhost', 'port'=>'11211')
        ),
        'life'=> 1800,
        'force_replace'=> true,
        'key_pre'=> 'Unamed_PHP_Framework'
    ),
);

?>