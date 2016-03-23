<?php
	global $gl_oVars;

	$cFastChallenge = new FastChallenge( $gl_oVars->cDBInterface );
	$cLadderSystem = new InetopiaLadder( $gl_oVars->cDBInterface );
	
	$iParticipantId	= (int)$_GET['team_id'];
	$iLadderId		= (int)$_GET['ladder_id'];
	$oFCEntry		= $cFastChallenge->GetParticipantInPool( $iParticipantId, $iLadderId );
	
	$gl_oVars->cTpl->assign( 'team_id', $iParticipantId );
	

	
	if( !$oFCEntry )	// no item available for that ladder?
	{
		// -----------------------------------
		// insert to 
		// -----------------------------------
		if( $_GET['a'] == 'add' )
		{
			$part_add = array(	'ladder_id'			=> $iLadderId,
								'participant_id'	=> $iParticipantId,
								'created'			=> EGL_TIME,
							);
	
			// try adding current participant (member_id)
			if( $cFastChallenge->AddParticipantToFastChallengePool( $part_add ) ){
				$gl_oVars->cTpl->assign( 'hide_form', 	true );
				
				$gl_oVars->cTpl->assign( 'msg_type', 	'success' );
				$gl_oVars->cTpl->assign( 'msg_text',	$gl_oVars->aLngBuffer['module']['c9851'] );
			}
			else
			{
				$gl_oVars->cTpl->assign( 'msg_type', 	'error' );
				$gl_oVars->cTpl->assign( 'msg_text',	$gl_oVars->aLngBuffer['module']['c9852'] );
			}
		}
	}//if
	else
	{
		// currently sign in ..
		/*$gl_oVars->cTpl->assign( 'hide_form', 	true );
				
		$gl_oVars->cTpl->assign( 'msg_type', 	'error' );
		$gl_oVars->cTpl->assign( 'msg_text',	$gl_oVars->aLngBuffer['module']['c9850'] );*/
		
		PageNavigation::Location( $gl_oVars->sURLFile.'?page='.$gl_oVars->sModuleId.':team.fastchallenge.quit&ladder_id='.$iLadderId.'&team_id='.$iParticipantId );
	}
	
?>