<?php
/**
 * @package: lib.org.dispatcher.factory
 * @author : Nemo.xiaolan
 */


/**
 * URL路由抽象类， 所有格式的路由必须继承此类
 * @abstract URLRouter
 */
abstract class URLRouter {
    
    /**
     * 解析URL, 返回值包括： controller, action, params
     * 
     * @param string $url
     * @return array 
     */
    abstract static public function parseURL($url);
    
    /**
     * 根据参数获取URL
     * 
     * @param string $path eg: member.login
     * @param string||array $params eg: a=1&b=2 || array('a'=>1, 'b'=>2);
     */
    abstract static public function get_url($path, $params = null);
    
}

/**
 * URL分发器工厂， 调用不同的URL路由来实现
 */
class DispatcherFactory {

    /**
     * DispatcherFactory::work()
     * @params string $url_type
     * @return void
     */
    static public function work($url_type) {
        $URL_router_name = ucfirst($url_type).'URLRouter';
        $url = ini('base.use_ssl') ? 'https' : 'http';
        $url.= '://'.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
        
        import('lib.org.dispatcher.'.$url_type);
        
        $result = call_user_func(array($URL_router_name, 'parseURL'), $url);

        $controller = array_shift($result);
        $action = array_shift($result);

        import('dev.org.common');
        
        $controller = $controller ? $controller : 'index';
        $is_exists = import('dev.com.controller.'.$controller);
        $controller_name = ucfirst($controller).'Controller';
        
        /**
         * @todo 
         */
        if(false === $is_exists) {
            exit('Controller does not exists');
        }
        
        if(!method_exists($controller_name, $action)) {
            $action = 'index';
        }
        
        /**
         * 
         */
        set_ini('runtime.object', $controller_name);
        set_ini('runtime.action', $action);
        
        /**
         * 实例化控制器
         */
        $controller_instance = new $controller_name();
        call_user_func_array(array($controller_instance, $action), $result);
    }

    /**
     * 根据当前URL样式配置 获取绝对URL
     * 
     * @param string $action
     * @param mixed  $params
     * @return string 
     */
    static public function get_url($action, $params = null) {
        return call_user_func_array(array($URL_router_name = 
        ucfirst(ini('base.url_style')).'URLRouter', 'get_url'), array($action, $params));
    }
    
    /**
     * 设置当前访问域名的根路径
     */
    static public function set_baseurl() {
        switch(ini('base.url_style')) {
            case 'compat':
            case 'pathinfo':
            default:
                $self = array_shift(explode('index.php', $_SERVER['PHP_SELF'])).'index.php';
                $php_selfs = explode('/', $self);
                array_pop($php_selfs);
                $url = implode('/', $php_selfs);
                $url = sprintf('%s://%s', ini('base.use_ssl') ? 'https' : 'http',
                        $_SERVER['SERVER_NAME'].$url);
                break;
        }
        
        set_ini('base.url_root', $url);
    }

}
    
    
?>
