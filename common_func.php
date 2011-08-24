<?php
    /*
     * JAVA-Like Import
     * 
     * 优先判断/dev
     * 
     * @param string $package eg: lib.org.database.factory
     * @return mixed
     * @author Nemo.xiaolan
     * @usage  import('lib.vendor.smarty.Smarty#class');
     */
    function import($package) {
        
        $result = false;
        
        if(substr($package, 0, 3) == 'lib') {
            $dev_package = 'dev'.substr($package, 3, strlen($package));
            $dev_package = str_replace('.', DS, $dev_package);
            $dev_package = MAIN_DIR.DS.str_replace('#', '.', $dev_package).'.php';
            
            if(file_exists_case($dev_package)) {
                $result = require_cache($dev_package); 
            }
        }
        
        if(false === $result){
            $package = str_replace('.', DS, $package);
            $package = MAIN_DIR.DS.str_replace('#', '.', $package).'.php';

            if(file_exists_case($package)) {
                $result = require_cache($package);
            }
        }
        
        return $result;
    }
    
    /*
     * 根据框架规则 返回绝对路径
     */
    function get_realpath($path) {
        $package = str_replace('.', DS, $package);
        return MAIN_DIR.DS.str_replace('#', '.', $package).'.php';
    }
    
    /*
     * 单件模式调用lib
     * 
     * 优先调用/dev下的工具
     * 
     * @param string $package
     * @param string $method = init
     * @param array  $params
     * @param string $suffix = 'Backend' 后缀
     * @return object instance of some object
     */
    function singleton($package, $method = 'init', $params = array(), $suffix = 'Backend') {
        static $_instance = array();
        $name = end(explode('.', $package));
        $class = $class_name = ucfirst($name).$suffix;
        if(key_exists($class_name, $_instance) && $instance[$class_name] instanceof $class_name) {
            return $_instance[$class_name];
        }
        $dev_package = 'dev'.substr($package, 0, strlen($package)-3);

        if(false === import($dev_package)) {
            import($package);
        }
        if(!class_exists($class_name)) {
            return false;
        }
        if(!has_static_method($class_name, $method)) {
            $class = new $class_name;
        }

        $instance = call_user_func(array($class, $method), $params);

        $_instances[$class_name] = $instance;
        return $instance;
    }
    
    /*
     * 判断类是否有某个静态方法
     */
    function has_static_method($className, $methodName) {
        $ref = new ReflectionClass($className);
        if ($ref->hasMethod($methodName) and $ref->getMethod($methodName)->isStatic()) {
            return true;
        }
    }
    
    /***************************************
        以下部分代码来自ThinkPHP
    */
    // 优化的require_once
    function require_cache($filename) {
        static $_importFiles = array();
        $filename = realpath($filename);
        if (!isset($_importFiles[$filename])) {
            if (file_exists_case($filename)) {
                $_importFiles[$filename] = true;
                return require $filename;
            } else {
                $_importFiles[$filename] = false;
                return false;
            }
        }
        
        return true;
    }

    // 区分大小写的文件存在判断
    function file_exists_case($filename) {
        if (is_file($filename)) {
            if (IS_WIN) {
                if (basename(realpath($filename)) != basename($filename))
                    return false;
            }
            return true;
        }
        return false;
    }
    
    
?>
