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
	 * CHALLENGESTATE_CHALLENGING: 	2
	 * CHALLENGESTATE_ACCEPTED: 	4
	 * CHALLENGESTATE_DENIED: 		8
	 * 
	 * 
	 */

	if( $oVars->bLoggedIn )
	if( isset($_GET['challenge_id']) && isset($_GET['team_id']) )
	{
		// fetch,paramlist, given in the pageaccessmanagement
		$oparam = parseParameterString($params['parameters']);
		
		$iState = (int)$oparam['state'];
		$cLadderSystem = new InetopiaLadder( $oVars->cDBInterface );
		
		// function CheckChallengeAccess( $participant_type, $participant_id, $challenge_id, $state )
		if( $cLadderSystem->CheckChallengeAccess( PARTTYPE_TEAM, $_GET['team_id'], $_GET['challenge_id'], $iState ) )
		{
			return 1;
		}
	}//if
	
	return -1;
}//function
?>