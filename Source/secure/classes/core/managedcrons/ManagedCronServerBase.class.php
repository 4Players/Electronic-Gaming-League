<?php
# ================================ Copyright © 2004-2006 Inetopia, All rights reserved. ==========================
# 
#
# Purpose:
# ================================================================================================================



# -[ class ] -
class ManagedCronServerBase
{
	# -[ variables ]-
	var $pDBInterfaceCon	= NULL;

	
	/**
	 * constructor
	 * 
	 * 
	 */
	function ManagedCronServerBase( &$pDBCon )
	{
		$this->pDBInterfaceCon = &$pDBCon;
		//DBTB::RegisterTB( '','', '' );
	}
};
?>