<?php

function smarty_compiler_defun($tag_args, &$smarty) {
    $_attrs = $smarty->_parse_attrs($tag_args);
    $smarty->_tag_stack[] = array('defun', $_attrs, $tag_args);
    if (!isset($_attrs['name'])) $smary->syntax_error("defun: missing name parameter");

    $_func_name = $smarty->_dequote($_attrs['name']);
    $_func = 'smarty_fun_'.$_func_name;
    return "if (!function_exists('$_func')) { function $_func(&\$this, \$params) { \$_fun_tpl_vars = \$this->_tpl_vars; \$this->assign(\$params); ";

}
   

function smarty_compiler_defun_close($tag_args, &$smarty) {
    list($_name, $_attrs, $_open_tag_args) = array_pop($smarty->_tag_stack);
    if ($_name!='defun') $smarty->_syntax_error("unexpected {/defun}");
    return " \$this->_tpl_vars = \$_fun_tpl_vars; }} ".smarty_compiler_fun($_open_tag_args, $smarty);
}


function smarty_compiler_fun($tag_args, &$smarty) {
    $_attrs = $smarty->_parse_attrs($tag_args);

    if (!isset($_attrs['name'])) $smarty->_syntax_error("fun: missing name parameter");
    $_func_name = $smarty->_dequote($_attrs['name']);
    $_func = 'smarty_fun_'.$_func_name; 
    $_params = 'array(';
    $_sep = '';
    unset($_attrs['name']);
    foreach ($_attrs as $_key=>$_value) {
        $_params .= "$_sep'$_key'=>$_value";
        $_sep = ',';
    }
    $_params .= ')';
    return "$_func(\$this, $_params); ";

}
?>