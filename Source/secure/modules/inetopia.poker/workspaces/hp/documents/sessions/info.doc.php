<?php

	global $gl_oVars;
	
	
	$iSessionId = (int)$_GET['session_id'];
	

	$cPokerOrganiser = new PokerOrganiser( $gl_oVars->cDBInterface );
	$cPokerSessions = new PokerSessions( $gl_oVars->cDBInterface );
	
	# fetch data
	$oSession = $cPokerSessions->GetSession( $iSessionId );
	$aSessionParticipants = $cPokerSessions->GetSessionParticipants( $iSessionId );
	
	/*$aOrganiser = $cPokerOrganiser->GetOrganiser($gl_oVars->iMemberId);
	$gl_oVars->cTpl->assign( 'organiser', $aOrganiser );*/

		
	$gl_oVars->cTpl->assign( 'session', $oSession );
	$gl_oVars->cTpl->assign( 'session_participants', $aSessionParticipants );
?>