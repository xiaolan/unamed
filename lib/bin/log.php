<?php

/**
 * @package lib.bin.
 */
interface LogInterface {}

class Log {
    
    public function init($backend = 'default') {
        return singleton('lib.org.log.'.$backend);
    }
}

?>
