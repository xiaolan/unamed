<?php
/*
 * File: fields.php
 * 
 * Encoding: UTF-8
 * Created on: Feb 12, 2011 8:25:48 PM
 *
 * @author: xiaolan
 *
 * 
 *
 */

class BaseFields {

    static private $extra = '';

    static private $enable_property = array(
        'minlength', 'maxlength', 'rule', 'value', 'rows', 'cols', 'width',
        'height', 'style', 'class', 'placeholder'
    );

    /*
     * BaseFields::get()
     * @param string $name | fields id/name
     * @param array  $property
     *
     * @return string html
     */
    static public function get($name, $property, $data = null) {
        if(!method_exists(self, $property['type'])) {
            self::set_extra_property($property, $data[$name]);
            $html = self::$property['type']($name, $property);
            /*
             * Do the replace default content
             */
            $search = array('[[TheDefaultContent]]');
            $replace = array($data[$name]);
            return str_ireplace($search, $replace, $html);
        }

        return '';
    }

    /*
     * Base::set_extra_property
     * @param array $property
     * @return void
     *
     * Set the extra property like min-lenght, and so on.
     */
    static private function set_extra_property(array $property, $data) {
        self::$extra = '';
        $data_exists = false;
        if($data && $data!=$property['value']) {
            $property['value'] = $data;
            $data_exists = true;
        }
        /*
         * Ignore the textarea, editor
         */
        $value_skip = array('editor', 'textarea');
        foreach($property as $key=>$value) {
            if(!in_array($key, self::$enable_property) ||
                    ($key =='value' && in_array($property['type'], $value_skip))) {
                continue;
            }
            if(($key=='value' || $key=='placeholder') && !$data_exists) {
                $other = sprintf(' placeholder="%s" ', $value, $value, $value);
                self::$extra.= $other;
            } else {
                self::$extra.= sprintf(' %s="%s" %s', $key, $value, $other);
            }
            
        }

        if(!isset($property['require']) || $property['require']) {
            self::$extra.= 'required="true"';
        }
    }

    /*
     * BaseFields::text()
     * @param string $name
     * @param array  $property
     * @return string html
     *
     * the base text input
     */
    static private function text($name, $property) {
        return sprintf('<input type="text" name="%s" id="%s" %s />', $name,
                            $name, self::$extra);
    }

    
    static private function password($name, $property) {
        return sprintf('<input type="password" name="%s" id="%s" %s />', $name,
                            $name, self::$extra);
    }

    static private function textarea($name, $property) {
        return sprintf('<textarea name="%s" id="%s" %s></textarea>', $name,
                            $name, self::$extra);
    }

    static private function radio() {}

    static private function checkbox() {}

    static private function editor($name, $property) {
        if(is_callable(array('Pluggable', 'trigger'))) {
            $html = Pluggable::trigger('on_editor_create', array($name, $property));
        }
        if(!$html) {
            $html = <<<EOF
            <script type="text/javascript">
                KE.show({
                    id : '{$name}',
                    width: '{$property['width']}',
                    height: '{$property['height']}',
                    afterCreate : function(id) {
                        KE.event.ctrl(document, 13, function() {
                            KE.util.setData(id);
                            document.forms['example'].submit();
                        });
                        KE.event.ctrl(KE.g[id].iframeDoc, 13, function() {
                            KE.util.setData(id);
                            document.forms['example'].submit();
                        });
                    }
                });
           </script>
EOF;
        }
        $html.= sprintf('<textarea name="%s" id="%s" %s>[[TheDefaultContent]]</textarea>', 
                $name, $name, self::$extra);
        return $html;
    }

    static private function upload() {}

    static private function select($name, $property) {
        $options = $property['options'];
        $html = sprintf('<select name="%s" id="%s" %s>%s</select>', $name, $name, self::$extra, '%s');

        if(!$property['options']) {
            return false;
        }
        foreach($property['options'] as $k=>$v) {
            $options_html.= sprintf('<option value="%s">%s</option>', $v['value'], $v['label']);
        }

        return sprintf($html, $options_html);

    }

    static private function datepicker($name, $property) {
        $js = <<<EOF
            <script type="text/javascript">
                $(function(){
                    $('#{$name}').datepicker({
                        'monthNames': ['一月','二月','三月','四月','五月','六月','七月','八月','九月','十月','十一月','十二月'],
                        'dayNamesMin': ['日','一','二','三','四','五','六',],
                        'dateFormat': 'yy-mm-dd '
                    });
                });
            </script>
EOF;
       $value = $property['value'] ? $property['value'] : date('Y-m-d', time());
       $html = sprintf('<input type="text" readonly value="%s" id="%s" name="%s" />', $value, $name, $name);

       return $js.$html;
    }

}

    

?>
