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
	if( isset($_GET['ladder_id']) )
	{
		$iLadderId = (int)$_GET['ladder_id'];
		
		$cLadderSystem = new InetopiaLadder( $oVars->cDBInterface );
		if( $cLadderSystem->IsEnteredLadder( $iLadderId, $oVars->iMemberId ) )
		{
			return 1;
		}
	}//if
	
	return -1;
}//function
?>