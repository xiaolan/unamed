<?php
/**
 * Description of validation
 *
 * @author Nemo.xiaolan
 * @created 2011-2-13 10:50:14
 *
 * Validation the data use php function or regex
 */

interface ValidatorInterface {
    
    static public function check($data, $rule);
    
}

class Validator {

    /*
     * @variable array $errors
     * The error message
     */
    public $errors = array();

    /*
     * @variable array $message
     * Defined message template
     */
    public $messages = array();

    private $is_valid = true;

    /*
     * Validation::check()
     * @param $name string | the field name
     * @param $type string | the type will be checked
     * @param $rule string
     * @param $data mixed
     * @return boolean
     *
     * <code>
     *  $validation->check('username', 'max_length', '255', 'John');
     * </code>
     */
    public function check($name, $field, $data) {
        
        foreach($field as $type=>$rule) {
            if(false === import('lib.org.security.validators.'.$type)) {
                continue;
            }
            
            $class_name = $type.'Validator';
            $object = new $class_name;
            $result = $object->check($data, $rule);
            if(true !== $result) {
                $this->is_valid = false;
                $this->messages[] = @sprintf(_g($result), $name, $rule);
            }
        }
        
        return $this->is_valid;
    }

}


?>
