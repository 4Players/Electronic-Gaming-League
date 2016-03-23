<?php
	global $gl_oVars;

	# declare classes/objects
	$cLadderSystem	= new InetopiaLadder( $gl_oVars->cDBInterface );
	
	
	$aInChallenges	= array();
	$aOutChallenges	= array();
	
	$aInChallenges	= $cLadderSystem->GetIncomingChallenges( PARTTYPE_MEMBER, $gl_oVars->oMemberData->id );
	$aOutChallenges	= $cLadderSystem->GetOutcomingChallenges( PARTTYPE_MEMBER, $gl_oVars->oMemberData->id );
	
	
	# provide templatesystem with data
	$gl_oVars->cTpl->assign( "in_challenges", $aInChallenges );
	$gl_oVars->cTpl->assign( "out_challenges", $aOutChallenges );
	
?>