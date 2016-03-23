<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */


function smarty_function_url_params($params, &$smarty)
{
	$p='';
	foreach( $_GET as $key => $value )
		$p .= $key.'='.$value.'&';
	if( strlen($p) > 0 ) return substr( $p, 0, strlen($p)-1);
	return '';
}
?>
