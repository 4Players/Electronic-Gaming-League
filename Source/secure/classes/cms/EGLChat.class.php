<?php
# ================================ Copyright © 2005-2006 Inetopia, All rights reserved. ==========================
# 
#
# Purpose:
# ================================================================================================================



# -[ defines ]-




# -[ class ] -
class EGLChat
{
	# -[ variables ]-
	var $pDBInterface	= NULL;

	
	/**
	 * 
	 */
	function EGLChat( &$pDBCon )
	{
		$this->pDBInterface = &$pDBCon;
	}

	/**
	 * 
	 */
	function EstablishRoom( $name ){
		
	}
	
	/**
	 * 
	 */
	function ConnectRoom( $name ){
	}
	
};

?>