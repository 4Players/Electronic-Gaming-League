<?php
# ================================ Copyright © 2005-2006 Inetopia, All rights reserved. ==========================
# 
#
# Purpose:
# ================================================================================================================


/**
* Callback-FunC : premium.team.check
*
* @param <global_vars_t>	reference to global vars
* @param array				parameters
*	array(	
			'current_permission'	=> base_access_t Object
			'permission_list'		=> array<base_access_t Object>
		 )
*
*

*/
function callback( $oVars, $params )
{
	/**************
		Laut notation, d.h. Bei einer Teamseite muss das team in der URL durch 'team_id' spezifiziert sein
	************/
	$iTeamId = (int)$_GET['team_id'];
	$_PREMIUM_CODE_TIME	= 3600;
	
	// fetch,paramlist	
	//$p_str = explode(';', $params['parameters']);
	
	
	# ----------------------------
	# LOGGED IN?
	# ----------------------------
	if( $oVars->bLoggedIn &&
		sizeof($params['permission_list']) > 0 /* access to that page available?*/ )
	{
		// fetch current team-list
		$aTeams = $oVars->cMember->GetTeamAccounts();
		
		# search team in teamlist
		
		for( $t=0; $t < sizeof($aTeams); $t++ )
		{
			# team found => check premium-activation
			if( $aTeams[$t]->id == $iTeamId )
			{
				if( (EGL_TIME-$aTeams[$t]->premium_activation) > $_PREMIUM_CODE_TIME )
				{
					// abgelaufen
					//echo "Premium-Code abgelaufen";
					return -1;
					// -> DO NEW Premium-code activation
				}
				else
				{
					return 0;
				}
			}//if
			
		}//for
	}//if
	

	return -1;
}