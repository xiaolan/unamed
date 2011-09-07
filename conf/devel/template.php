<?php

/*
 * @author : Nemo.xiaolan
 * @created: 
 */

return array(
    'left_delimiter'  => '<{', 
    'right_delimiter' => '}>',
    
    'config_dir'      => MAIN_DIR.DS.'tmp'.DS.'template_config',
    
    'template_dir'    => ENTRY.DS.'templates'.DS.ini('base.theme'),
    'compile_dir'     => MAIN_DIR.DS.'tmp'.DS.'template_compiled',
    
    'caching'         => true,
    'cache_dir'       => MAIN_DIR.DS.'tmp'.DS.'template_cache',
    'cache_lifetime'  => 3600,
);

?>
