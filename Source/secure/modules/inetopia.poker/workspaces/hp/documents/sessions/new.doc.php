<?php

	global $gl_oVars;

	$cPokerOrganiser = new PokerOrganiser( $gl_oVars->cDBInterface );
	$cPokerSessions = new PokerSessions( $gl_oVars->cDBInterface );
	
	#------------------------------------
	# TEST	
	#------------------------------------
	if( $_GET['a'] == 'create' ){
		$aRegSession = array(
						'name'				=> $_POST['name'],
						'member_id'			=> $gl_oVars->iMemberId,
						//'organiser_id'		=> $_POST['organiser_id'],
						'organiser_id'		=> EGL_NO_ID,
						'tables'			=> $_POST['tables'],
						'max_players'		=> $_POST['max_players'],
						'session_type'		=> $_POST['session_type'],
						'tables'			=> $_POST['tables'],
						'date'				=> $_POST['date'],	// convert
						'country'			=> 'de',
						'city'				=> $_POST['city'],
						'plz'				=> $_POST['plz'],
						'street'			=> $_POST['street'],
						'created'			=> EGL_TIME,
						);
			
		//if( $_POST['organiser_id'] != EGL_NO_ID ) $aRegSession['member_id'] = EGL_NO_ID;
			
		if( $cPokerSessions->RegisterSession( $aRegSession ) ){
			$gl_oVars->cTpl->assign( 'msg_type', 'success' );
			$gl_oVars->cTpl->assign( 'msg_text', 'Pokersession wurde erstellt.' );
		}
	}
	
	
	$aOrganiser = $cPokerOrganiser->GetOrganiser($gl_oVars->iMemberId);
	
	$gl_oVars->cTpl->assign( 'organiser', $aOrganiser );
	
?>