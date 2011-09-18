<?php

/**
 * 扩展PHP内建Exception类
 */
class BaseException extends Exception {
    
    /**
     * 异常收尾处理
     */
    public function work() {
        if(ini('base.log.error_enable')) {
            import('lib.bin.log');
            $log = Log::init();
        }
    }
    
}

?>
