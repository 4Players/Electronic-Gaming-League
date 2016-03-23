<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */


function smarty_modifier_add_match_sign($string)
{
    if( (int)$string > 0 ) return '+'.$string;
    if( (int)$string < 0 ) return $string;
    if( (int)$string == 0 ) return $string;
}

?>
