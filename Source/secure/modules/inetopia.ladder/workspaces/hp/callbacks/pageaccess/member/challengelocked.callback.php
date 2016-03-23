<?php
# ================================ Copyright  2005-2006 Inetopia, All rights reserved. ==========================
# 
#
# Purpose: Callback-Check - Checking LadderJoined
# ================================================================================================================

function callback( $oVars, $params )
{
	/**
	 * $params
	 * 		=> data		: permission-list
	 */
	if( $oVars->bLoggedIn )
	if( isset($_GET['ladderpart_id']) )
	{
		$iLadderPartId = (int)$_GET['ladderpart_id'];
		
		$cLadderSystem = new InetopiaLadder( $oVars->cDBInterface );
		if( $cLadderSystem->IsLadderChallengeLocked( $iLadderPartId ) )
		{
			return -1;
		}
	}//if
	
	return 1;
}//function
?>