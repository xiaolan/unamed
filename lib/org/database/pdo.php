<?php

/*
 * @author : Nemo.xiaolan
 * @created: 
 */

class PdoBackend implements DatabaseDriver {
    
    static public function init($conf_key) {
        $conf = ini('database.'.ini('base.run_mode').'.'.$conf_key);
        try {
            $instance = new PDO($conf['dsn'], $conf['user'], $conf['pwd']);
            $instance->exec('SET NAMES UTF8');
        } catch(PDOException $e) {
            echo $e->getMessage();
        }
        
        return $instance;
    }
    
}

?>
