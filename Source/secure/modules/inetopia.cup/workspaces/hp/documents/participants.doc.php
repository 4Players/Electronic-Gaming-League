<?php
	global $gl_oVars;

	
	$iCupId			= (int)$_GET['cup_id'];
	#$iParticipantId	= (int)$_GET['part_id'];
	#$iCupPartId		= (int)$_GET['cuppart_id'];
	
	
	
	# declare classes
	$cCup 		= new Cup( $gl_oVars->cDBInterface, (int)$_GET['cup_id'] );
	#$cClan		= new CClan( $gl_oVars->cDBInterface );
	
	# fetch data
	$oCup = $cCup->GetData();
	
	
	
	
	# get participants
	$aParticipants = $cCup->GetDetailedCupParticipants( (int)$_GET['cup_id'], $oCup->participant_type );

	
	
	$gl_oVars->cTpl->assign( 'cup', $oCup );
	$gl_oVars->cTpl->assign( 'participants', $aParticipants );
	$gl_oVars->cTpl->assign( 'num_participants', sizeof($aParticipants) );
?>	