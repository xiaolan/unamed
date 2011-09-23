<?php

/**
 * 默认使用PHP写文件方式记录日志
 * 
 * @package lib.org.log.default
 */
class DefaultLogBackend implements LogInterface{
	
	/**
	 * Log存放路径
	 * */
	public $logpath;
	
	/**
	 * Log记录的字段信息
	 * */
	private $log_fields;
	
	/**
	 * 当Log文件达到此大小时 压缩， 以KB为单位
	 * */
	private $pack_size;
	
	/**
	* Log文件开头版权及安全性防止输出
	* */
	private $content_prefix = '<?php /* Loged By Unamed PHP Framework*/ die();?>';
	
	/**
	 * 实例化时设置参数
	 * */
	public function __construct() {
		$this->logpath = get_realpath(ini('base.log.save_path'), '');
		$this->pack_size = ini('base.log.pack_size');
		$this->log_fields = ini('base.log.log_fields');
	}
    
	/**
	 * 写入log
	 * 
	 * @param array $data
	 * @param string $type = error
	 * */
    public function write($data, $type='error') {
        $log_file = $this->logpath.DS.$type.'.log.php';
        $this->need_pack($log_file);
        
        $content = '';
        if(!file_exists_case($log_file)) {
        	$content.= $this->content_prefix."\n";
        }
        

        /**
         * 格式化日志内容
         * [Time][errno]: message . File ln lnnum
         * */
		$log[] = sprintf("[%s][%s]: %s. %s ln %d",
			date('YmdHis', CURRENT_TIMESTAMP),
			$data['errno'],
			$data['message'],
			$data['file'],
			$data['line']
		);
        
        import('lib.org.io.file');
        FileIO::write($log_file, $content.implode(', ', $log)."\n", 'a+');
    }
    
    
    /**
     * 当Log文件超过规定大小时， 打包log
     * 
     * @param string $log_file 
     * */
    private function need_pack($log_file) {
    	if(!file_exists_case($log_file)) {
    		return true;
    	}
    	
    	$size = filesize($log_file);
    	
    	if($size/1024 >= $this->pack_size) {
    		import('lib.org.io.zip');
    		$save_path = ini('base.log.save_path').'.error#log';
    		$name = 'error.log.'.date('YmdHis', time());
    		$newname = str_replace('error.log', $name, $log_file);
    		rename($log_file, $newname);
    		
    		Zip::compress($newname, $save_path);
    		unlink($newname);
    	}
    }
    
}

?>
