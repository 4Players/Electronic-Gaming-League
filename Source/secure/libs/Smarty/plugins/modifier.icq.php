<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */


/**
 * Smarty count_characters modifier plugin
 *
 * Type:     modifier<br>
 * Name:     count_characteres<br>
 * Purpose:  count the number of characters in a text
 * @link http://smarty.php.net/manual/en/language.modifier.count.characters.php
 *          count_characters (Smarty online manual)
 * @param string
 * @param boolean include whitespace in the character count
 * @return integer
 */
function smarty_modifier_icq( $string )
{
	$mod_text = str_replace( '-', '', $string );
	$mod_text = str_replace( ' ', '', $mod_text );
	return $mod_text;
}

/* vim: set expandtab: */

?>