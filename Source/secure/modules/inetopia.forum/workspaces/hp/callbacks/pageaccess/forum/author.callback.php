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
	if( isset($_GET['post_id']) && 
		($_GET['a'] == 'edit'||strlen($_GET['a'])==0 ) // only for editing
		)
	{
		$cForums = new EGLForums( $gl_oVars->cDBInterface );
		$oPost = $cForums->FetchPost( (int)$_GET['post_id'] );
		if( $oPost && $oPost->member_id > 0 && $oPost->member_id == $gl_oVars->iMemberId  )
			return 1;
	}
	return 0;
}//function
?>