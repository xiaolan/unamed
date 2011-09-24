<?php

class RegexValidator implements Validator {
    
    static public function check($data, $rule) {
        if(preg_match($rule, $data)) {
            return true;
        }
        
        return '%s can not be valid';
        
    }
    
}