<?php
	global $gl_oVars;
	

	# create cup object
	$cCup 		= new Cup( $gl_oVars->cDBInterface, NULL /*cup_id NOT USED*/ );
	$cGamePool 	= new GamePool( $gl_oVars->cDBInterface );
	
	
	$iParticipantId 	= -1;
	$iCupId				= -1;
	$iParttype			= -1;
	
	
	
	#echo nl2br( print_r( $cCup->GetUpcomingCups( time(), PARTTYPE_MEMBER ), 1));
	
	
	#exit;
?>