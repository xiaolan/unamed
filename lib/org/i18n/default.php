<?php

/**
 * 默认使用数组方式的i18n
 * 
 * @package lib.org.i18n.default
 */
class DefaultI18NBackend {
    
    private $language_dir = 'dev.lang';
    
    private $loaded_package = array();
    
    public function __construct($language = 'en') {
        $this->language_dir = ini('base.language_dir') ? ini('base.language_dir') : $this->language_dir;
        $language = $language ? $language : ini('base.language');
        $this->language_dir.='.'.$language.'.';
    }
    
    public function get($lang, $package = 'common') {
        if(!in_array($package, $this->loaded_package)) {
            $this->loaded_package[$package] = import($this->language_dir.$package.'#lang');
        }
        $i18ned = $this->loaded_package[$package][$lang];
        
        return $i18ned ? $i18ned : $lang;
    }
    
}

?>
