<?php

/**
 * 使用Zip打包或者解压文件
 * */
class Zip {
	
	static public function compress($files, $save_path, $append = true) {
		import('lib.vendor.pclzip.pclzip');
		$zip = new PclZip(get_realpath($save_path, '.zip'));
		if(is_array($files)) {
			foreach($files as $k=> $file) {
				$files[$k] = get_realpath($files, '');
			}
			$files = implode(',', $files);
		}
		
		$func = $append ? 'add' : 'create';
		
		if($zip->$func($files, PCLZIP_OPT_REMOVE_ALL_PATH)) {
			return true;
		} else {
			return false;
		}
	}
	
	/**
	static public function compress($files_or_dir, $save_path) {
		$zip = new ZipArchive();
		$success = $zip->open(get_realpath($save_path, '.zip'), ZipArchive::CREATE);
		if(!$success) {
			return false;
		}
		
		
		/**
		 * 打包目录下所有文件
		if(!is_array($files_or_dir)) {
			$dir = get_realpath($files_or_dir, '');
		}
		if(is_dir($dir)) {
			$handler = opendir($dir);
			while (($filename = readdir($handler)) !== false) {
				if($filename != '.' && $filename != '..') {
					
					$zip->addFile($filename);
				}
			}
		} else {
			foreach($files_or_dir as $file) {
				$file = file_exists_case($file) ? $file : get_realpath($file, '');
				if(file_exists_case($file)) {
					$zip->addFile($file);
				}
			}
		}
		
		$zip->close();
		
	}*/
	
	static public function extract() {}
	
}

?>