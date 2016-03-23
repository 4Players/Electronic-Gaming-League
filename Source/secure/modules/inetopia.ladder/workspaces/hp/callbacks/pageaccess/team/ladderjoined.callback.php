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
	if( isset($_GET['ladder_id']) && isset($_GET['team_id']) )
	{
		$iLadderId 	= (int)$_GET['ladder_id'];
		$iTeamId	= (int)$_GET['team_id'];
		
		$cLadderSystem = new InetopiaLadder( $oVars->cDBInterface );
		// fetch current(OWN) team-list
		$aTeams = $oVars->cMember->GetTeamAccounts();
		
		# search team in teamlist
		for( $t=0; $t < sizeof($aTeams); $t++ )
		{
			# team found => check premium-activation
			if( $aTeams[$t]->id == $iTeamId )
			{
				if( $cLadderSystem->IsEnteredLadder( $iLadderId, $iTeamId ) )
				{

					return 1;
				}
			}//if
			
		}//for

	}//if
	
	return -1;
}//function
?>