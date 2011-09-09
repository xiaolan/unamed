<?php

class I18N {
    
    static private $instance;
    
    static private $inited = false;
    
    static public function init($engine = 'default', $language='en') {
        import('lib.org.i18n.'.$engine);
        $engine_name = ucfirst($engine).'I18NBackend';
        self::$instance = new $engine_name($language);
        self::$inited = true;
    }
    
    static public function get($lang, $package = 'common') {
        if(!self::$inited) {
            self::init();
        }
        return self::$instance->get($lang, $package);
    }
    
}


/**
 * shotcuts
 */
if(!function_exists('_g')) {
    function _g($lang, $package = 'common') {
        return I18N::get($lang, $package);
    }
}

if(!function_exists('_e')) {
    function _e($lang, $package = 'common') {
        echo _g($lang, $package);
    }
}

?>
