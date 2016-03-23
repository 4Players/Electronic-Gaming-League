<?php
# ================================ Copyright © 2005-2006 Inetopia, All rights reserved. ==========================
# 
#
# Purpose:
# ================================================================================================================



# -[ defines ]-




# -[ class ] -
class MapPool
{
	# -[ variables ]-
	var $pDBInterfaceCon	= NULL;

	
	function MapPool( &$pDBCon )
	{
		$this->pDBInterfaceCon = &$pDBCon;
	}

};


?>