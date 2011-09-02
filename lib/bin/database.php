<?php

    /*
     * @package lib.org.database.factory
     * @author Nemo.xiaolan
     */
    
    interface DatabaseDriver {
        static public function init($conf_key);
    }
    
    class Database {
    
        static public function init($driver = 'pdo', $config_key = 'maindb') {
            if(!ini('database')) {
                set_ini('database', import('conf.database'));
            }
            return singleton('lib.org.database.'.$driver, 'init', $config_key);
            
        }
        
    }
?>
