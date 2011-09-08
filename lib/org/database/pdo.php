<?php

/**
 * @package lib.org.database.pdo
 */
class PdoBackend implements DatabaseDriver {
    
    /**
     * PdoBackend::init()
     * 
     * @param string $conf_key 配置文件的key
     * @return object instance of PDO
     */
    static public function init($conf_key) {
        $conf = ini('database.'.$conf_key);
        try {
            $instance = new PDO($conf['dsn'], $conf['user'], $conf['pwd']);
            $instance->exec('SET NAMES UTF8');
        } catch(PDOException $e) {
            /**
             * @todo Log 和 异常处理
             */
            echo $e->getMessage();
        }
        
        return $instance;
    }
}

?>
