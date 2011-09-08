<?php

/**
 * @package lib.org.web.session
 */
class Session {

    static private $instance;

    /**
     * session start
     */
    static public function start() {
        if(self::$instance instanceof self) {
            return self::$instance;
        }

        @session_start();
    }
}

?>
