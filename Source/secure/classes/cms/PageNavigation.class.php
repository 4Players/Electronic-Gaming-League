<?php
# ================================ Copyright © 2005-2006 Inetopia, All rights reserved. ==========================
# 
#
# Purpose:
# ================================================================================================================



# -[ defines ]-



# -[ objectlist ] -




# -[ class ] -
class PageNavigation
{
	# -[ variables ]-
	var $pDBCon = NULL;
	
	# -[ functions ]-
	
	
	# =========================================================================
	# PUBLIC
	# =========================================================================
	
	//-------------------------------------------------------------------------------
	// Purpose: constructor
	// Output : -
	//-------------------------------------------------------------------------------
	function PageNavigation (&$pDBCon)
	{
	}

	
	
	/**
	 * try to force forwarding the current page to $link
	 *
	 * @param string $link
	 */
	function Location( $link )
	{
		header( "location: $link" );
	}

	/**
	* read url parms, return as an url pram string
	*
	* @return string
	*/
	function URLParams()
	{
		$p='';
		foreach( $_GET as $key => $value )
			$p .= $key.'='.$value.'&';
		if( strlen($p) > 0 ) return substr( $p, 0, strlen($p)-1);
		return '';
	}
	
	
	/**
	 * 
	 */
	function MyURL(){
		//return dirname( $_SERVER['HTTP_HOST']).EGL_DIRSEP."index.php";
		return 'http://'.$_SERVER['SERVER_NAME'].dirname( $_SERVER['PHP_SELF'] ).'/';	
	}
	
	
	/**
	 * 
	 */
	function MyURLFile(){
		return 'no implementation';
	}
	function MyRootURL(){
		return $_SERVER['SERVER_NAME'];	
	}
			

};
?>