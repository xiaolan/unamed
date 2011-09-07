<?php
/*
 * @author : Nemo.xiaolan
 * @created: 
 */
 
/*
 * smarty function
 * @param string $action
 * @param array|string  $params
 * @usage:
 * <code>
 *  {%url action='auth.index' params=$array%}
 * </code>
 */
function smarty_function_url($params, $smarty) {
    return DispatcherFactory::get_url($params['action'], $params['params']);
}



?>
