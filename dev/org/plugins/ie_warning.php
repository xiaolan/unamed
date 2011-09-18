<?php

class Ie_warning {
    
    static public function work() {
        $lang = _g('You are using unsafe web brower!');
        echo <<<EOF
        <!--[if gt IE 6]>
        <div id="for-gt-ie6"></div>
        <![endif]-->
        <!--[if lt IE 7]>
        <div id="for-ie6">
            {$lang}
        </div>
        <![endif]-->    
EOF;
    }
}

Pluggable::register(array('Ie_warning', 'work'), 'after_header_output');

?>