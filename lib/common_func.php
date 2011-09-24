<?php
    /**
     * JAVA-Like Import
     * 
     * 优先判断/dev
     * 
     * @param string $package eg: lib.org.database.factory
     * @return mixed
     * @author Nemo.xiaolan
     * @uses  import('lib.vendor.smarty.Smarty#class');
     */
    function import($package) {
        static $_importPackages = array();
        
        /**
         * 根据当前定义的运行环境， 导入相应的配置
         */
        if(substr($package, 0, 4) == 'conf') {
            $package = preg_replace('/conf\./', 'conf.'.RUN_MODE.'.', $package);
        }
        /**
         * 是否已经加载过
         */
        if(key_exists($package, $_importPackages)
                        && false !== $_importPackages[$package]) {
            return true;
        } else if(false === $_importPackages[$package]) {
            return false;
        }
        /**
         * 判断文件是否核心并且已经“编译”
         */
        if($package !== 'lib.bin.compiler'
                && substr($package, 0, 8) !== 'dev.com.'
                && Compiler::is_compiled($package)) {
            $_importPackages[$package] = true;
            return true;
        }
        
        $file_path = get_realpath($package);
        if(file_exists_case($file_path) && !key_exists($package, $_importPackages)) {
            $_importPackages[$package] = require $file_path;
        } else if(!file_exists_case($file_path)) {
            $_importPackages[$package] = false;
        }
        
        return $_importPackages[$package];
    }
    
    /**
     * 根据框架规则 返回绝对路径
     */
    function get_realpath($package, $ext = '.php') {
        $package = str_replace('.', DS, $package);
        
        /**
         * 优先调用DEV
         */
        $dev_package = preg_replace('/lib\./', 'dev.', $package);
        $file_path = MAIN_DIR.DS.str_replace('#', '.', $dev_package).$ext;
        if(!file_exists_case($file_path)) {
            $file_path = MAIN_DIR.DS.str_replace('#', '.', $package).$ext;
        }
        return $file_path;
    }
    
    /**
     * 单件模式调用lib
     * 优先调用/dev下的工具
     * 
     * @param string $package
     * @param string $method = init
     * @param array  $params
     * @param string $suffix = 'Backend' 后缀
     * @return object instance of some object
     */
    function singleton($package, $method = 'init', $params = array(), $suffix = 'Backend') {
        static $_instances = array();
        $name = end(explode('.', $package));
        $class_name = ucfirst($name).$suffix;
        if(key_exists($class_name, $_instances)) {
            return $_instances[$class_name];
        }
        $dev_package = 'dev'.substr($package, 0, strlen($package)-3);
        
        if(!import($dev_package)) {
            import($package);
        }
        if(!class_exists($class_name)) {
            return false;
        }
        if(!has_static_method($class_name, $method)) {
            $class = new $class_name($params);
        }

        if(is_object($class)) {
            $_instances[$class_name] = $class;
        } else {
            $_instances[$class_name] = call_user_func(array($class_name, $method), $params);
        }
        
        return $_instances[$class_name];
    }
    
    /**
     * 判断类是否有某个静态方法
     */
    function has_static_method($className, $methodName) {
        $ref = new ReflectionClass($className);
        if ($ref->hasMethod($methodName) &&
                $ref->getMethod($methodName)->isStatic()) {
            return true;
        }
    }
    
    function is_post($has_data = true) {
        if($_SERVER['REQUEST_METHOD'] != 'POST') {
            return false;
        }
        if($has_data && $_POST) {
            return true;
        }
        return false;
    }
    
    function r($package = null, $params = null) {
        header('Location:'.DispatcherFactory::get_url($package, $params));
        exit;
    }
    
    function is_email($email) {
        return preg_match('/^[\_\.0-9a-zA-Z\-]+@[0-9a-z\-]+[a-z]{2,4}$/', $email);
    }

    /***************************************
        以下部分代码来自ThinkPHP
    */

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
