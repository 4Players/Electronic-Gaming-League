<?php
# ================================ Copyright © 2004-2006 Inetopia, All rights reserved. ==========================
# 
#
# Purpose:
# ================================================================================================================



# -[ class ] -
class ManagedCronClientBase
{
	# -[ variables ]-
	var $pDBInterfaceCon	= NULL;

	
	/**
	 * constructor
	 * 
	 * 
	 */
	function ManagedCronClientBase( &$pDBCon )
	{
		$this->pDBInterfaceCon = &$pDBCon;
		//DBTB::RegisterTB( '','', '' );
	}
	
};
?>