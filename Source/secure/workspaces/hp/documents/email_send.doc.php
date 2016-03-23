<?php
	global $gl_oVars;


	
	
	# fetch data
	$oMember	= $gl_oVars->cMember->GetMemberDataById( (int)$_GET['member_id'] );
	
	/*
	ACHTUNG:
		Der Referer muss hie rnoch getestet werden => == $gl_oVars->sURLFile ??
	*/
	
	#-------------------------------------------------
	# ACTIONS
	#-------------------------------------------------
	if( $oMember )
	{
		if( $_GET['a'] == 'go' )
		{
			$subject 	= $_POST['email_subject'];
			$text 		= $_POST['email_text'];
			
			$email_cfg = new egl_email_header_t();
			
			$cMail = new Mails($gl_oVars->sLanguage);
			$cMail->SetSenderMail( $email_cfg->no_response, $email_cfg->sender_name );
			$cMail->IsHTML(false);
			
			if( $cMail->SendMail( $subject, $text, $oMember->email ) )
			{
				$gl_oVars->cTpl->assign( 'success', true );
				
				$gl_oVars->cTpl->assign( 'msg_type', 	'success' );
				$gl_oVars->cTpl->assign( 'msg_text', 	$gl_oVars->aLngBuffer['basic']['c2104'] );
			}
			else
			{
				$gl_oVars->cTpl->assign( 'msg_type', 	'error' );
				$gl_oVars->cTpl->assign( 'msg_text', 	$gl_oVars->aLngBuffer['basic']['c2105'] );
			}
			
		}//if^
	}
	else
	{
		$gl_oVars->cTpl->assign( 'msg_type', 	'error' );
		$gl_oVars->cTpl->assign( 'msg_text', 	$gl_oVars->aLngBuffer['basic']['c2107'] );
	}

	
	$gl_oVars->cTpl->assign( 'member_details', $oMember );
?>