<?php
	global $gl_oVars;
	
	$iTeamId		= (int)$_GET['team_id'];
	

	# declare classes/objects
	$cLadderSystem	= new InetopiaLadder( $gl_oVars->cDBInterface );
	$cTeam = new Team( $gl_oVars->cDBInterface );
	
	# fetch participantdata
	$oTeam = $cTeam->GetTeam( $iTeamId );
	
	
	$aInChallenges	= array();
	$aOutChallenges	= array();
	
	$aInChallenges	= $cLadderSystem->GetIncomingChallenges( PARTTYPE_TEAM, (int)$oTeam->id );
	$aOutChallenges	= $cLadderSystem->GetOutcomingChallenges( PARTTYPE_TEAM, (int)$oTeam->id );
	
	
	# provide templatesystem with data
	$gl_oVars->cTpl->assign( "in_challenges", $aInChallenges );
	$gl_oVars->cTpl->assign( "out_challenges", $aOutChallenges );
	
?>