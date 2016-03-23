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
	
	
	

	$gl_oVars->cTpl->assign( 'cup', $oCup );
?>	