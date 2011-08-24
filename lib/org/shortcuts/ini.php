<?php
    import('lib.org.ini');
    
    function ini($key = null) {
        return INI::get($key);
    }
    
    function set_ini($key, $value) {
        return INI::set($key, $value);
    }
    
?>
