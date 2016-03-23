<?php
	global $gl_oVars;
	
	
	
	#-----------------------------------------
	# CHECK 
	#-----------------------------------------
	if( $_GET['a'] == 'go' )
	{
		
		$obj_search = NULL;
		$obj_search->email = $_POST['fp_email'];
							
	

		# define sql search query
		$sql_query = $gl_oVars->cDBInterface->CreateSelectQuery( $GLOBALS['g_egltb_members'], $obj_search, 'id,email,nick_name', NULL, ' LIMIT 0,50', false, '$VAR=\'$VALUE\'' );

				# create results
		$aResults = $gl_oVars->cDBInterface->FetchArrayObject(  $gl_oVars->cDBInterface->Query($sql_query) );
		

		# ------------------------
		# check results
		#
		if( sizeof($aResults) == 1 )
		{
			$oCurrMemberData = $aResults[0];

			$cMember 		= new Member( $gl_oVars->cDBInterface );
			
			# create activation code, sent via email
			$obj_member	= array( 	'activation_code' 	=> md5( EGL_TIME.CreateRandomPassword() ),
								);
			
			$mails = new Mails( $gl_oVars->sLanguage );
			$mails->IsHTML(false);		# set als HTML
			
			$email_header = new egl_email_header_t;
			$mails->SetSenderMail( $email_header->password_lost, $email_header->password_lost_sender );

					
			// generate activation url
			$sURL = dirname( $_SERVER['HTTP_REFERER']).EGL_DIRSEP.basename($gl_oVars->sURLFile);
			$activation_url = $sURL.'?page=member.activate&member_id='.$oCurrMemberData->id.'&code='.$obj_member['activation_code'];
			
			
			// update DB:
			$fp_obj = array( 	'activation_code' 	=> md5( EGL_TIME.CreateRandomPassword()),
							
							); 
			$cMember->SetMemberDataById( $fp_obj, $oCurrMemberData->id );
			
			
			#  variables for email template
			$mails->assign( 'member_id', 			$oCurrMemberData->id );
			$mails->assign( 'email',				$oCurrMemberData->email );
			$mails->assign( 'nick_name', 			$oCurrMemberData->nick_name	);
			$mails->assign( 'activation_url',		$activation_url );
			
				
			# try sending email
			if( !$mails->SendeMail( 'forgot_password.tpl', $gl_oVars->aLngBuffer['basic']['c2302'], $oCurrMemberData->email ) )
			{
				$gl_oVars->cTpl->assign( 'msg_type', 		'error' );
				$gl_oVars->cTpl->assign( 'msg_text', 		$gl_oVars->aLngBuffer['basic']['c2310'] );
				
				DEBUG( MSGTYPE_ERROR, __FILE__, __LINE__, "Couldn't send E-Mail to .`".$oCurrMemberData->email."`" );
			}
			else
			{
				if( !$cMember->SetMemberDataById( $obj_member, $oCurrMemberData->id ) )
				{
					$gl_oVars->cTpl->assign( 'msg_type', 		'error' );
					$gl_oVars->cTpl->assign( 'msg_text', 		 $gl_oVars->aLngBuffer['basic']['c2311'] );
					
					DEBUG( MSGTYPE_ERROR, __FILE__, __LINE__, "Couldn't update memberdata .`".$oCurrMemberData->email."`" );
				}
				else
				{
					$gl_oVars->cTpl->assign( 'success',  true );
				
					$gl_oVars->cTpl->assign( 'msg_type', 		'success' );
					$gl_oVars->cTpl->assign( 'msg_text', 		 $gl_oVars->aLngBuffer['basic']['c2303'] );
				}
			}//if

		}// sizeof $aResults
		else
		{
			$gl_oVars->cTpl->assign( 'msg_type', 	'error' );
			$gl_oVars->cTpl->assign( 'msg_text', 	 $gl_oVars->aLngBuffer['basic']['c2304'] );
			
		} // if data found
		
		
	}//if

		
?>