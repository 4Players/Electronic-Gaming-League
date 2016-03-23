<?php
# ================================ Copyright © 2005-2006 iNetopia, All rights reserved. ==========================
# 
#
# Purpose:
# ================================================================================================================



# -[ defines ]-
define( "SOCKET_MAX_BUFFER", 	4096 ); // 4 kb


	
# -[ objectlist ] -

if( !ifclass('inout_package_t') )
{
	class inout_package_t
	{
		var 	$id;		# int
		var 	$type; 		# int
		var 	$length; 	# gg
		var 	$buf;
	};
}





# -[ class ] -
class Socket
{
	# -[ variables ]-
	
	# -[ functions ]-
	
	
	# =========================================================================
	# PUBLIC
	# =========================================================================
	
	//-------------------------------------------------------------------------------
	// Purpose: constructor
	// Output : -
	//-------------------------------------------------------------------------------
	function Socket ()
	{
	}

	
	function ReceiveBuffer( $size=SOCKET_MAX_BUFFER, $type=PHP_BINARY_READ ) {}
	function SendBuffer( $data, $size=0 ) {}
};

?>