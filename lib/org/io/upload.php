<?php

/**
 * 文件上传基础功能实现
 * 
 * @package lib.org.io.upload
 */
class Upload {
    
    /**
     * Public方法， 用于外部调用上传文件
     * 
     * @param string $key 上传文件input的name
     * @param boolean $image 是否为图片
     */
    static public function file($key, $image = true) {
        /**
         * 多文件上传， 使用了<input type="file" name="filename[]" /> 这种数组方式上传
         */
        $return = true;
        if(is_array($_FILES[$key]['name'])) {
            $length = count($_FILES[$key]['name']);
            
            for($i=0; $i<$length; $i++) {
                /**
                 * 上传文件为图片， 并且getimagesize返回false 则认为不是图片上传 则跳过
                 */
                if($image && false === getimagesize($_FILES[$key]['name'][0])) {
                    continue;
                }
                
                $result = self::move_uploaded_file($_FILES[$key]['tmp_name'][$i], $_FILES[$key]['name'][$i]);
                if(false === $result) {
                    $return = false;
                }
            }
        } else {
            $return = self::move_uploaded_file($_FILES[$key]['tmp_name'], $_FILES[$key]['name']);
        }
        
        return $return;
        
    }
    
    /**
     * 完成文件上传步骤
     * 
     * @param string $tmpname
     * @param string $destination
     */
    static private function move_uploaded_file($tmp_name, $name) {
        $destination = self::get_destination($name);
        return move_uploaded_file($tmp_name, $destination);
    }
    
    /**
     * 检测文件是否符合上传的规定
     * 
     * @param string $tmp_name
     * @param boolean $image
     * @param boolean 
     */
    static private function check($tmp_name, $image = true) {}
    
    /**
     * 根据配置获取文件的存储位置
     * 
     * @param string $name
     * @return string $destination
     */
    static private function get_destination($name) {
        $name = preg_replace('/\.[a-zA-Z]{0,5}/i', '', $name);
    }
    
}

?>
