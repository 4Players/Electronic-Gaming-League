<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */


function smarty_modifier_match_points($string)
{
	if( (int)$string > 0 )
		return "<font color='#00A800'>".$string."</font>";
	else if( (int)$string < 0 )
		return "<font color='#A80000'>".$string."</font>";
	else if( (int)$string == 0 )
		return $string;
	else return $string;
}

?>
