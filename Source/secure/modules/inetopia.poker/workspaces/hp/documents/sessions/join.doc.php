<?php
	global $gl_oVars;
	
	$iSessionId		= (int)$_GET['session_id'];

	// ........
	$cPokerSessions 	= new PokerSessions( $gl_oVars->cDBInterface );
	
	// fetch data
	$oSession			= $cPokerSessions->GetSession( $iSessionId );
	$oParticipant 		= $cPokerSessions->GetSessionParticipant( $iSessionId, $gl_oVars->iMemberId );
	
	if( $oSession && !$oParticipant  )
	{
		$obj_part	= array(  	'member_id'		=> $gl_oVars->iMemberId,
								'session_id'	=> $iSessionId,
								'created'		=> EGL_TIME,
							);
		// create poker-session-participants
		if( $cPokerSessions->CreatePokerSessionParticipant( $obj_part ) )
		{
			$gl_oVars->cTpl->assign( 'success', true );
			
			$gl_oVars->cTpl->assign( 'msg_type', 'success' );
			$gl_oVars->cTpl->assign( 'msg_text', 'Der Eintritt in die Poker-Session war erfolgreich!' );
		}else{
			$gl_oVars->cTpl->assign( 'msg_type', 'error' );
			$gl_oVars->cTpl->assign( 'msg_text', 'Es ist ein Fehler aufgetreten. Bitte melde dem Admin' );
		}
	}
	else
	{
		$gl_oVars->cTpl->assign( 'msg_type', 'error' );
		$gl_oVars->cTpl->assign( 'msg_text', 'Dieser bereich ist von ihnen nicht zugänglich' );
	}
	
?>