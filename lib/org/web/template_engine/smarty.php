<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of smarty
 *
 * @author xiaolan
 */

import('dev.vendor.Smarty.Smarty');
import('lib.org.web.template.smarty_plugins');

class SmartyTemplateBackend extends Smarty {
    
    public function init() {
        parent::__construct();
        $this->configure();
        $this->load_common_plugins();
        return $this;
    }
    
    private function configure() {
        $conf = import('conf.smarty');
        foreach($conf as $k => $v) {
            $this->$k = $v;
        }
        set_ini('template.smarty', $conf);
    }
    
    private function load_common_plugins() {}
    
}

?>