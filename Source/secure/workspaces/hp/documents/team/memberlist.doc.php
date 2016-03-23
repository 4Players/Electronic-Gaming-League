<?php
	global $gl_oVars;

	$iTeamId		= (int)$_GET['team_id'];
	$iGameAccTypeId	= (int)$_GET['gameacctype_id'];
	
	# define & declare classes/objects
	$cTeam 	= new Team( $gl_oVars->cDBInterface );
	$cGameAccounts = new GameAccounts( $gl_oVars->cDBInterface );
	
	$aGameAccTypes = $cGameAccounts->GetGameAccountTypes();
	if( !$iGameAccTypeId && sizeof($aGameAccTypes) > 0 ) $iGameAccTypeId = $aGameAccTypes[0];

	# fetch data
	$aTeamMembers = $cTeam->GetTeamMembersSortedByGameAccounts($iTeamId, $iGameAccTypeId );
	$oTeam = $cTeam->GetTeamById( $iTeamId );
	
	$gl_oVars->cTpl->assign( 'memberlist', 		$aTeamMembers );
	$gl_oVars->cTpl->assign( 'gameaccounts', 	$aGameAccTypes );
	$gl_oVars->cTpl->assign( 'team_id', 		$iTeamId );
	$gl_oVars->cTpl->assign( 'team', 			$oTeam );
?>