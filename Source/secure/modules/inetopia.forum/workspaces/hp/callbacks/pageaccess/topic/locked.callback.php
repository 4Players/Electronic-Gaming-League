<?php
# ================================ Copyright  2005-2006 Inetopia, All rights reserved. ==========================
# 
#
# Purpose: Callback-Check for PageAccess Manageer
# ================================================================================================================

function callback( $oVars, $params )
{
	global $gl_oVars;
	/**
	 * $params
	 * 		=> data		: permission-list
	 */	
	if( $gl_oVars->bLoggedIn )
	if( isset($_GET['topic_id']))
	{
		$cForums = new EGLForums( $gl_oVars->cDBInterface );
		$oTopic = $cForums->FetchTopic( (int)$_GET['topic_id'] );
		if( $oTopic && ( $oTopic->locked || $oTopic->link ) )
		{
			return -1;
		}
	}
	return 1;
}//function
?>