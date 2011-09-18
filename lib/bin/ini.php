<?php

class INI {

    static public $config;

    static public function load($key, $data = null) {
        return self::set($key, $data);
    }

    /*
     * INI::get()
     * @param $package String
     * @return mixed
     * <code>
     *  INI::get('base.site.url');
     * </code>
     */
    static public function get($package = null) {
        if(!$package) {
            return self::$config;
        }

        $packages = explode('.', $package);
        $ini = self::$config;
        foreach($packages as $value) {
            $ini = $ini[$value];
        }
        return $ini;
    }

    /*
     * INI::set()
     *
     * @param $package String
     * @param $data Mixed
     * @return void
     *
     * eg:
     * <code>
     *     INI::set('base.site.title', 'Page title');
     * </code>
     *
     * like the array(
     *  'application' => array(
     *                      'site' => array(
     *                          'title' => 'Page title'
     *                      ),
     *                  ),
     * );
     */
    static public function set($package, $data = null) {

        if(!is_array($data)) {
            if(strpos($package, ".") === false) {
                self::$config[$package] = $data;
                return;
            }

            $packages = explode(".", $package);
            $length = count($packages);
            $position =& self::$config;

            for($i=0;$i<$length;$i++) {
                $current = $packages[$i];
                if($i == $length-1) {
                    $position[$current] = $data;
                } else {
                    if(!isset($position[$current])) {
                        $position[$current] = array();
                    }
                    $position =& $position[$current];
                }
            }

        } else {
            foreach($data as $k => $v) {
                self::set($package.'.'.$k, $v);
            }
        }
    }
}

if(!function_exists('write_ini')) {
    /*
     * Write to ini file
     * 
     * @param string $package eg: tmp.~template_config
     */
    function write_ini($package, $data) {
        $content = ";<?php die();?>\r\n";
        foreach($data as $k=>$v) {
            if(is_array($v)) {
                $content = "[$k]\r\n";
                foreach($v as $_k=>$_v) {
                    $content .= $_k.'="'.str_replace('"', ",", $_v)."\"\r\n";
                }
            } else {
                $content .= $k.'="'.str_replace('"', ",", $v)."\"\r\n";
            }
        }
        file_put_contents(get_realpath($package), $content);
    }
}


function ini($key = null) {
    return INI::get($key);
}

function set_ini($key, $value) {
    return INI::set($key, $value);
}

?>
