<?php

class maxLengthValidator implements Validator {
    
    static public function check($data, $rule) {
        if(strlen($data) <= $rule) {
            return true;
        }
        
        return "%s's length must less than %s";
    }
    
} 