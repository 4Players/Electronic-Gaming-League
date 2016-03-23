<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */


/**
 * Smarty {lng} function plugin
 *
 * Type:		function<br>
 * Name:		lng_parser <br>
 * Purpose:		fetch language data from array, by evaluation
 * @author 		Inetopia.de
 * @param 		Params
 * @param 		Smarty
 */

function smarty_function_lng_parser($params, &$smarty)
{
	
    if (!isset($params['content'])) {
       // $smarty->trigger_error("eval: missing 'content' parameter");
        return;
    }
    if($params['content'] == '') {
        return;
    }
    $smarty->_compile_source( 'evaluated template', $params['content'], $_var_compiled );
    
	// save language data
	$params['LNG_BASIC'] = $smarty->_tpl_vars['LNG_BASIC'];
	$params['LNG_MODULE'] = $smarty->_tpl_vars['LNG_MODULE'];

    $tmp_tplvar_buffer = $smarty->_tpl_vars;	# => save old tpl-var-smarty buffer
    unset($params ['content'] );	# => del content variable
	$smarty->_tpl_vars = $params ;	# => set overgiven template var-buffer as smarty intra var-buffer
	
    ob_start();
    $smarty->_eval( '?>' . $_var_compiled );
    $_contents = ob_get_contents();
    ob_end_clean();
    
    $smarty->_tpl_vars = $tmp_tplvar_buffer;	# => restore old tpl-var-smarty buffer

    /*
    if (!empty($params['assign'])) 
    { $smarty->assign($params['assign'], $_contents);
    } else 
    {
        return $_contents;
    }//if*/
	
	return $_contents;
}


?>