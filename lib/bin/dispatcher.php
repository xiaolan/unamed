<?php
/*
 * @package: lib.org.dispatcher.factory
 * @author : Nemo.xiaolan
 * @
 */


/*
 * URL路由抽象类， 所有格式的路由必须继承此类
 */
abstract class URLRouter {
    
    /*
     * 解析URL, 返回值包括： controller, action, params
     * 
     * @param string $url
     * @return array 
     */
    abstract static public function parseURL($url);
    
    /*
     * 根据参数获取URL
     * 
     * @param string $path eg: member.login
     * @parma string||array $params eg: a=1&b=2 || array('a'=>1, 'b'=>2);
     */
    abstract static public function get_url($path, $params = null);
    
}

/*
 * URL分发器工厂， 调用不同的URL路由来实现
 */
class DispatcherFactory {


    /*
     * DispatcherFactory::work()
     * @params string $url_type
     * 
     */
    static public function work($url_type) {
        $URL_router_name = ucfirst($url_type).'URLRouter';
        $url = ini('base.use_ssl') ? 'https' : 'http';
        $url.= '://'.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
        
        import('lib.org.dispatcher.'.$url_type);
        
        /*
         * $result = array('object', 'method', 'param1', 'param2');
         */
        $result = call_user_func(array($URL_router_name, 'parseURL'), $url);

        $controller = array_shift($result);
        $action = array_shift($result);

        
        $controller = $controller ? $controller : 'index';
        $is_exists = import('dev.com.controller.'.$controller);
        $controller_name = ucfirst($controller).'Controller';
        
        /*
         * @todo 
         */
        if(false === $is_exists) {
            exit('Controller does not exists');
        }
        
        $controller_instance = new $controller_name();
        
        if(!method_exists($controller_instance, $action)) {
            $action = 'index';
        }
        
        set_ini('runtime.object', $controller_name);
        set_ini('runtime.action', $action);
        
        import('dev.org.common');
        
        call_user_func_array(array($controller_instance, $action), $result);
        
    }

    /**/
    static public function get_url($action, $params = null) {
        return call_user_func_array(array($URL_router_name = 
        ucfirst(ini('base.url_style')).'URLRouter', 'get_url'), array($action, $params));
    }
    
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
