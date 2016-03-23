<?php
	global $gl_oVars;
	
	$iTeamId		= (int)$_GET['team_id'];
	$cLadderSystem 	= new InetopiaLadder( $gl_oVars->cDBInterface );
	
	
	// fetch member-data
	$aLadders = $cLadderSystem->GetJoinedTeamLadderByTeamId( $iTeamId);
	$gl_oVars->cTpl->assign( 'LADDERS', $aLadders );
	$gl_oVars->cTpl->assign( 'TEAM_ID', $iTeamId  );
?>