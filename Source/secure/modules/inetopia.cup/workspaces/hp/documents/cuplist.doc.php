<?php
	global $gl_oVars;
	

	# create cup object
	$cCup = new Cup( $gl_oVars->cDBInterface, NULL /*cup_id NOT USED*/ );
	
	
	$iParticipantId 	= -1;
	$iCupId				= -1;
	$iParttype			= -1;
	
	if( Isset($_GET['team_id']) )
	{
		# team exists ?

		$iCupId				= (int)$_GET['cup_id'];
		$iParticipantId 	= (int)$_GET['team_id'];
		$iParttype 			= PARTTYPE_TEAM;		# set as team_id

	}
	else
	{
		# member 
		
		$iCupId				= (int)$_GET['cup_id'];
		$iParticipantId 	= (int)$gl_oVars->oMemberData->id;
		$iParttype 			= PARTTYPE_MEMBER;	# set as member_id
	}
	

	# --------------------------------------------
	# List upcoming cups
	# --------------------------------------------
	
	# gets all upcoming Cups
	$aCups = $cCup->GetUpComingCups_ByParticipant( EGL_TIME, $iParttype, $iParticipantId );
	$gl_oVars->cTpl->assign( 'cups',		$aCups );
	$gl_oVars->cTpl->assign( 'cup_games',	$aGames );
		
	return 1;
?>