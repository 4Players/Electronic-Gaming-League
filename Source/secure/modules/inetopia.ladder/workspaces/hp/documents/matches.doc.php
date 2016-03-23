<?php
	global $gl_oVars;
	
	# read header/url data
	//$iLadderId			= (int)$_GET['ladder_id'];
	//$iParticipantId 	= (int)$_GET['participant_id'];
	$iLadderpartId 		= (int)$_GET['ladderpart_id'];
	
	
	# declare objects/classes
	$cLadderSystem = new InetopiaLadder( $gl_oVars->cDBInterface );
	$cMember = new Member( $gl_oVars->cDBInterface );
	$cTeam = new Team( $gl_oVars->cDBInterface );
	
	
	#fetch ladderdata
	$oLadder = $cLadderSystem->GetLadderbyPartID( $iLadderpartId );
	
	$oParticipant = NULL;
	if( $oLadder->participant_type == PARTTYPE_TEAM )
	{
		$oParticipant = $cTeam->GetTeam_clandata( (int)$oLadder->participant_id );
	}
	elseif( $oLadder->participant_type == PARTTYPE_MEMBER )
	{
		# fetch data
		$oParticipant = $cMember->GetMemberDataById( (int)$oLadder->participant_id );
	}

	# fetch matches
	$aMatches = $cLadderSystem->GetLadderMatchesByParticipantId( $oLadder->participant_type, (int)$oLadder->participant_id, (int)$oLadder->id, 0, 20 );
	

	# provide template with data
	$gl_oVars->cTpl->assign( "ladder", $oLadder );
	$gl_oVars->cTpl->assign( "matches", $aMatches );
	$gl_oVars->cTpl->assign( "participant_id", $oLadder->participant_id );
	$gl_oVars->cTpl->assign( "participant", $oParticipant );
?>