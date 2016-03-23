<?php
# ================================ Copyright � 2005-2006 Inetopia, All rights reserved. ==========================
# 
#
# Purpose:
# ================================================================================================================



# -[ defines ]-
define( 'DBADDERR_ALIAS_IN_SECTION_EXISITS',	1 );


# -[ objectlist ] -





/**
 * Enter description here...
 *
 */
class DBTB
{
	# -[ variables ]-
	var $global_array_id = 'A9CCDCBF91223A9C22E6';
	var $tb_array = array();
	
	
	# -[ functions ]-
	function GlobalID(){
		return 'A9CCDCBF91223A9C22E6';
	}
	
	
	# =========================================================================
	# PUBLIC
	# =========================================================================

	/**
	 * Enter description here...
	 *
	 * @return DBTB
	 */
	function DBTB ()
	{
		$GLOBALS[DBTB::GlobalID()] = &$this;
	}
	
	
	/**
	 * Enter description here...
	 *
	 * @param string $section
	 * @param string $alias
	 * @param string $name
	 * @return unknown
	 */
	function RegisterTB( $section, $alias, $real_tb_name )
	{
		if( isset($GLOBALS[DBTB::GlobalID()]) ){
			return $GLOBALS[DBTB::GlobalID()]->__RegisterTB( $section, $alias, $real_tb_name );
		}else return 0; 
	}
	
	
	/**
	 * Enter description here...
	 *
	 * @param string $section
	 * @param string $alias
	 */
	function GetTB( $section, $alias )
	{
		//$this = &$GLOBALS[$global_array];
		if( isset($GLOBALS[DBTB::GlobalID()]) ){
			return $GLOBALS[DBTB::GlobalID()]->__GetTB( $section, $alias );
		}else return 0;
	}
	
	
	
	/**
	 * Enter description here...
	 *
	 * @param string $section
	 * @param string $alias
	 * @param string $name
	 */
	function __RegisterTB( $section, $alias, $real_tb_name )
	{
		if( isset($GLOBALS[DBTB::GlobalID()]) ){
			if( isset( $GLOBALS[DBTB::GlobalID()]->tb_array[$section][$alias]) )
				return DBADDERR_ALIAS_IN_SECTION_EXISITS;
			else 
				$GLOBALS[DBTB::GlobalID()]->tb_array[$section][$alias] = $real_tb_name;
		}else return 0;
	}

	
	/**
	 * Enter description here...
	 *
	 * @param string $section
	 * @param string $alias
	 */
	function __GetTB( $section, $alias )
	{
		if( isset($GLOBALS[DBTB::GlobalID()]) ){
			return $GLOBALS[DBTB::GlobalID()]->tb_array[$section][$alias];
		}else return 0;
	}
	
	
};

?>