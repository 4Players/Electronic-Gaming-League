<?php
# ================================ Copyright © 2005-2006 Inetopia, All rights reserved. ==========================
# 
#
# Purpose:
# ================================================================================================================



# -[ defines ]-




# -[ class ] -
class Statistics
{
	# -[ variables ]-
	var $pDBInterfaceCon	= NULL;

	
	function Statistics( &$pDBCon )
	{
		$this->pDBInterfaceCon = &$pDBCon;
	}

};


?>