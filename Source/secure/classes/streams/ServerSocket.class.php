<?php
# ================================ Copyright � 2005-2006 iNetopia, All rights reserved. ==========================
# 
#
# Purpose:
# ================================================================================================================



# -[ defines ]-


	
# -[ objectlist ] -




# -[ class ] -
class ServerSocket extends Socket 
{
	# -[ variables ]-
	var $iPort			= 0;
	var $sLocalAdress	= "unknown";

	
	# -[ functions ]-
	
	
	# =========================================================================
	# PUBLIC
	# =========================================================================
	
	//-------------------------------------------------------------------------------
	// Purpose: constructor	
	// Output : -
	//-------------------------------------------------------------------------------
	function ServerSocket ( $port )
	{
		$this->iPort = $port;
	}
	
	
	
	//-------------------------------------------------------------------------------
	// Purpose:
	// Output :
	//-------------------------------------------------------------------------------
	function CreateServer()
	{
	}

};



?>