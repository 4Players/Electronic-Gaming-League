<?php
	global $gl_oVars;

	$cFastChallenge = new FastChallenge( $gl_oVars->cDBInterface );
	$cLadderSystem = new InetopiaLadder( $gl_oVars->cDBInterface );
	
	$iParticipantId	= (int)$gl_oVars->iMemberId;
	$iLadderId		= (int)$_GET['ladder_id'];
	$oFCEntry		= $cFastChallenge->GetParticipantInPool( $iParticipantId, $iLadderId );
	
	
	if( $oFCEntry )	// no item available for that ladder?
	{
		// -----------------------------------
		// insert to 
		// -----------------------------------
		if( $_GET['a'] == 'quit' )
		{
			// try adding current participant (member_id)
			if( $cFastChallenge->DeleteParticipantFromPool( $oFCEntry->id ) ){
				$gl_oVars->cTpl->assign( 'hide_form', 	true );
				
				$gl_oVars->cTpl->assign( 'msg_type', 	'success' );
				$gl_oVars->cTpl->assign( 'msg_text',	$gl_oVars->aLngBuffer['module']['c9853'] );
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
		PageNavigation::Location( $gl_oVars->sURLFile.'?page='.$gl_oVars->sModuleId.':member.fastchallenge.enter&ladder_id='.$iLadderId );
	}
	
?>