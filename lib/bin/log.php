<?php

/**
 * @package lib.bin.
 */
interface LogInterface {}


class Log {
    
    static public function init($backend = 'default') {
		return singleton('lib.org.log.'.$backend, '', '', 'LogBackend');
    }
}

?>