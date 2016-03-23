<?php
# ================================ Copyright © 2005-2006 Inetopia, All rights reserved. ==========================
# 
#
# Purpose:
# ================================================================================================================
define( 'EGL_BASICS_LOADED',	true );



#----------------------------------------------------------------------
# Purpose:
#  Output:
#----------------------------------------------------------------------
function egl_require( $location )
{
	if( file_exists( $location ) )
	{
		return require( FIX_URL_SEP($location));
	}
	else
	{
		DEBUG( MSGTYPE_ERROR, __FILE__, __LINE__,  "Couldn't include file located `{$location}` - file not found"  );
		echo '<br/>file not available '.$location;
		exit;
	}//if
}


?>