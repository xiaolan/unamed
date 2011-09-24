<?php

class RegexValidator implements ValidatorInterface {
    
    static public function check($data, $rule) {
        if(preg_match($rule, $data)) {
            return true;
        }
        
        return '%s can not be valid';
        
    }
    
}