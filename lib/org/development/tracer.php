<?php

/**
 * @package lib.org.development.tracer
 */
class Tracer {
    
    /**
     * 
     */
    static public function output() {
        ob_start();
        debug_print_backtrace();
        $content = ob_get_clean();
        
        $content = explode("\n", $content);
	foreach($content as $k=>$v) {
            if(!trim($v)) {
                continue;
            }
            if($k % 2 == 0 || $k == 0) {
                $odd_even = 'even';
            } else {
                $odd_even = 'odd';
            }
            $content[$k] = preg_replace('/called at \[(.*)\]/', 
                    '<div class="trace-file">[$1]</div>', $v);
            $content[$k] = preg_replace('/(#[0-9]+)/', '<div class="trace-index">
                $1</div><div class="trace-content">', $content[$k]).'</div><div style="clear:both;"></div>';
            $content[$k] = sprintf('<div class="trace-per-line %s">%s</div>', $odd_even, $content[$k]);
	}
        $content = implode("\n", $content);
        $style = <<<EOF
<style type="text/css">
    #debug-backtrace {display:block;font-size:12px;font-family:"Verdana", Helvetica, sans-serif}
    #debug-backtrace .odd{background:#fff}
    #debug-backtrace .trace-per-line{line-height:30px;height:30px;}
    #debug-backtrace .trace-index{float:left;display:inline;width:30px;color:red}
    #debug-backtrace .trace-content{float:left;display:inline;}
    #debug-backtrace .trace-file{float:right;display:inline;margin-left:10px;color:#222}
</style>
EOF;
        return sprintf('%s<div id="debug-backtrace">%s</div>', $style, $content);
    }
    
}

?>
