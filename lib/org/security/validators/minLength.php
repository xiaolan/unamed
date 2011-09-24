<?php

class minLengthValidator implements ValidatorInterface {
    
    static public function check($data, $rule) {
        if(strlen($data) >= $rule) {
            return true;
        }
        
        return "%s's length must more than %s";
    }
    
} 