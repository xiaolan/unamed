<?php

    class Session {
    
        static private $instance;
    
        static public function start() {
            if(self::$instance instanceof self) {
                return self::$instance;
            }
            
            @session_start();
            
        }
    
    }

?>
