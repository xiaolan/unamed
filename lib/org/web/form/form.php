<?php
/**
 * 
 *
 * @author Nemo.xiaolan
 * @created 2011-1-30 11:03:41
 */

class BaseForm {
    
    public $strip_tags = true;

    /*
     * @variable boolean $is_bound
     * is the form bound or not
     */
    public $is_bound = false;

    /*
     * @variable boolean $is_valid
     * is the form valid or not
     */
    public $is_valid = null;

    /*
     * @variable boolean $is_cleaned
     * is the form data cleaned or not
     */
    public $is_cleaned = false;

    /*
     * @variable array $messages
     * the error message
     */
    public $messages = array();

    /*
     * @variable array $fields
     * the form fields
     */
    public $fields = array();

    /*
     * @variable array $data
     * form bound data
     */
    public $data   = array();
    
    public $cleaned_data = array();
    
    private $smarty_instance;
    
    
    /*
     * BaseForm::__construct()
     * @param string $form
     * @param string $application
     * @param array  $data
     * @return void
     */
    public function __construct($smarty = null, $data = null) {
        
        if(is_object($smarty)) {
            $this->smarty_instance = $smarty;
            $this->smarty_instance->registerPlugin('modifier', 'as_table',
                                                        'smarty_modifier_as_table');
            $this->smarty_instance->registerPlugin('modifier', 'as_p',
                                                    'smarty_modifier_as_p');
            $this->smarty_instance->registerPlugin('modifier', 'as_ul',
                                                    'smarty_modifier_as_ul');
            $this->smarty_instance->registerPlugin('modifier', 'as_div',
                                                    'smarty_modifier_as_div');
            $this->smarty_instance->registerPlugin('function', 'csrf_protected',
                                                    'smarty_function_csrf_protected');
        }

        if($data) {
            $this->data = $data;
            $this->is_bound = true;
        }

        $this->clean();
    }
    
    /*
     * BaseForm::output()
     * @return array Fields HTML
     *
     * return the fields html
     */
    public function output() {
        import('lib.org.web.form.fields');
        $fields_html = array();
        foreach($this->fields as $field_name=>$property) {
            $fields_html['content'][$field_name]
                        = BaseFields::get($field_name, $property, $this->data);
            $label = $this->fields[$field_name]['label']
                    ? $this->fields[$field_name]['label']
                    : $field_name;
            $fields_html['label'][$field_name] = _g($label);
        }
        $fields_html['fields']  = $this->fields;

        if($this->is_bound) {
            $fields_html['messages']= $this->messages;
            $fields_html['data']    = $this->data;
        }
        
        return $fields_html;
    }

    /*
     * BaseForm::clean()
     * @return array
     */
    public function clean() {
        if(!$this->is_bound || !$this->data) {
            return array();
        }
        $func = $this->strip_tags ? 'strip_tags' : 'htmlspecialchars';
        foreach($this->data as $key=>$value) {
            if($this->fields[$key]['type'] != 'editor' && !is_array($value)) {
                $this->cleaned_data[$key] = trim($func($value));
            } else if(is_array($value) && $value) {
                foreach($value as $k=>$v) {
                    $this->cleaned_data[$key][$k] = trim($func($v));
                }
            }
        }
        
        $this->is_cleaned = true;
        return $this->cleaned_data;
    }

    /*
     * BaseForm::cleaned()
     * @return array
     *
     * return the form cleaned data
     */
    public function cleaned() {
        if($this->is_cleaned) {
            return $this->data;
        } else {
            return $this->clean();
        }
    }

    /*
     * BaseForm::is_valid()
     * @return boolean
     *
     * is the form validationed or not
     */
    public function is_valid() {
        if($this->is_valid === null) {
            return $this->validation($this->data);
        } else {
            return $this->is_valid;
        }
    }
    

    /*
     * BaseForm::validation()
     * @param array $data
     * @return boolean
     *
     * Validate the form with Form.yml by Validation class
     */
    protected function validation() {
        
        import('lib.org.security.csrf');
        if(!CSRF::check($this->cleaned_data['CSRF_TOKEN'])) {
            $this->is_valid = false;
            $this->messages[] = _g('Please do not try CSRF!');
        }
        
        import('lib.org.security.validator');
        $validation_instance = new Validator();
        
        foreach($this->fields as $name=> $field) {
            if(!$validation_instance->check($name, $field, $this->cleaned_data[$name])) {
                $this->is_valid = false;
            }
        }

        if($this->is_valid === null) {
            $this->is_valid = true;
        }
        
        $this->messages = $validation_instance->messages;

        return $this->is_valid;
    }

}

?>
