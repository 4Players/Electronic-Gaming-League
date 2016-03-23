<?php
	global $gl_oVars;



	# read pm message
	$oMessage = $gl_oVars->cMember->GetMessage( $_GET['pm_id'] );
	if( !$oMessage )
	{
		$gl_oVars->cTpl->assign( 'msg_type', 	'error' );
		$gl_oVars->cTpl->assign( 'msg_title', 	'PM Nachricht' );
		$gl_oVars->cTpl->assign( 'msg_text', 	'Diese PM-Nachricht konnte nicht gefunden werden.' );
	}
	else
	{
		 $gl_oVars->cTpl->assign( 'pm_data', $oMessage );
		 
		 # received message ? => input
		 if( $oMessage->sender_id != $gl_oVars->oMemberData->id )
		 {
		 	$gl_oVars->cTpl->assign( 'pm_input', true );
		 }
		 
		 /*
		 # input message ?
		 if( $oMessage->sender_id != $g_iMemberId )
		 {
			 $gl_oVars->cTpl->assign( 'pm_type_input', 1 ); 
		 }*/
		 
		 
		 # already not read
		 if( !$oMessage->is_read )
		 {
		 	$update_obj = NULL;
		 	$update_obj->is_read = 1;
		 	$gl_oVars->cMember->ChangeMessage( $update_obj, $oMessage->id );
		 }
	}
	
	
	
?>