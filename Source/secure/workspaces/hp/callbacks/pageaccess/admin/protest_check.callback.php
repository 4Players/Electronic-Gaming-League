<?php
# ================================ Copyright © 2005-2006 Inetopia, All rights reserved. ==========================
# 
#
# Purpose:
# ================================================================================================================


/**
* Callback-FunC : admin.matches
*
* @param <global_vars_t>	reference to global vars
* @param array				parameters
*/
function callback( $oVars, $params )
{
	$iProtestId = (int)$_GET['protest_id'];
	$cProtests = new Protests( $oVars->cDBInterface );
	$oProtest = $cProtests->GetProtest($iProtestId);
	
	$adminaccess_time = 600;
	
	if( ($oProtest->adminaccess_member_id != EGL_NO_ID && 	// no member activ?
		$oProtest->adminaccess_member_id == $oVars->iMemberId) ||  // me active?
		(EGL_TIME-$oProtest->adminaccess_time) > $adminaccess_time )
		{
		
		
		return 1;
	}
	return -1;
}