<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of factory
 *
 * @author xiaolan
 */


class Template{
    /*
     * Return singleton-template instance
     */
    static public function init($tpl_engine = 'smarty', $config = null) {
        
        return singleton('lib.org.web.template_engine.'.$tpl_engine, 'init', 
                                                    $config, 'TemplateBackend');
        
    }
    
}

?>
