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
function smarty_modifier_url($data, $params = null) {
    return DispatcherFactory::get_url($data, $params);
}

function smarty_modifier_lang($lang, $package = 'common') {
    return _g($lang, $package);
}

function smarty_modifier_as_table($data) {
    if(!$data['content']) {
        return false;
    }
    foreach($data['content'] as $key=>$value) {
        $class = __get_class_name($data['fields'][$key]['type']);
        $form_html.= <<<EOF
            <tr>
                <td class="as-table-label"><label for="{$key}">{$data['label'][$key]}</label></td>
                <td class="as-table-data {$class}">{$value}</td>
            </tr>
EOF;
    }

    return $form_html;
}

function smarty_modifier_as_p($data) {
    foreach($data['content'] as $key=>$value) {
        $class = __get_class_name($data['fields'][$key]['type']);
        $form_html.= <<<EOF
            <p class="as-p-label"><label for="{$key}">{$data['label'][$key]}</label></p>
            <p class="as-p-data {$class}">{$value}</p>
EOF;
    }

    return $form_html;
}

function smarty_modifier_as_ul($data) {
    foreach($data['content'] as $key=>$value) {
        $class = __get_class_name($data['fields'][$key]['type']);
        $form_html.= <<<EOF
            <li class="as-p-label"><label for="{$key}">{$data['label'][$key]}</label></li>
            <li class="as-p-data {$class}">{$value}</li>
EOF;
    }

    return $form_html;
}


function smarty_modifier_as_div($data) {
    foreach($data['content'] as $key=>$value) {
        $class = __get_class_name($data['fields'][$key]['type']);
        $form_html.= <<<EOF
            <div class="{$class}">
                <label for="{$key}">{$data['label'][$key]}</label>
        {$value}
            </div>
EOF;
    }

    return $form_html;
}


function smarty_function_csrf_protected($params, $smarty) {

    import('lib.org.security');
    $name = $params['name'] ? $params['name'] : 'CSRF_TOKEN';
    $csrf_token = CSRF::generate($name);
    return <<<EOF
        <input type="hidden" name="{$name}" value="{$csrf_token}" />
EOF;
}

function __get_class_name($type) {
    switch($type) {
        case 'text':
        case 'password':
        case 'textarea':
        case 'editor':
            $class = 'type-text';
            break;
        case 'select':
            $class = 'type-select';
            break;
        case 'radio':
        case 'checkbox':
            $class = 'type-check';
            break;
        default:
            break;
    }
    return $class;
}


?>
