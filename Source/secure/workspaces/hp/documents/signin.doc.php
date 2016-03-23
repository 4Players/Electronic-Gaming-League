<?php
# =========================================
# signin.tpl 
# =========================================
	global $gl_oVars;



	# --------------------------------
	# signin into db ?
	# --------------------------------
	if( $_GET['a'] == 'go' )
	{
		$bError 	= false;
		$signin_obj = NULL;
		
		if( Isset( $_POST['signin_email'] ) ) 		$signin_obj->email	 	= $_POST['signin_email'];
		if( Isset( $_POST['signin_nick_name'] ) )	$signin_obj->nick_name 	= $_POST['signin_nick_name'];
		
		
		# email given ?
		if( !(strlen($signin_obj->nick_name) > 3) )
		{
			$bError = true;
			// nick-name min 3 chars
			ADD_PAGE_ERROR( $gl_oVars->aLngBuffer['basic']['c2406'] );
		}
	
		# email given ?
		if( !(strlen( $signin_obj->email )  > 3) || !Check_eMail($signin_obj->email) )
		{
			$bError = true;
			ADD_PAGE_ERROR( $gl_oVars->aLngBuffer['basic']['c2407'] );
		}
		
		
		
		#---------------------------------------------------------------
		# Check		
		#---------------------------------------------------------------
		if( $_POST['signin_terms_of_use'] != 'accepted' || $_POST['signin_terms_of_use'] != 'accepted' )
		{
			$bError = true;
			ADD_PAGE_ERROR( $gl_oVars->aLngBuffer['basic']['c2408'] );
		}

		
		
		# ------------------
		# ERROR 
		# ------------------
		if( !$bError ) 
		{
			# Member currently available ?	
			if( $gl_oVars->cMember->MemberExists( $signin_obj ) )
			{
				$gl_oVars->cTpl->assign( 'msg_type', 		'error' );
				//$gl_oVars->cTpl->assign( 'msg_title', 		'Hinweis');
				$gl_oVars->cTpl->assign( 'msg_text', 		$gl_oVars->aLngBuffer['basic']['c2409'] );
			}
			
			# Signin - Access ?!!
			else
			{
				
				# save selected nationality
				$signin_obj->country_id	 = (int)$_POST['signin_country_id'];
				
				# generate random password (5 chars)
				$_psd 	= CreateRandomPassword();
				
				$signin_obj->created 			= EGL_TIME;
				$signin_obj->password 			= md5($_psd);		# standard 5 chars
				$signin_obj->activation_code 	= md5( EGL_TIME.CreateRandomPassword() ); 
				$signin_obj->activation_time	= 0;
				
				# try signing in !!
				if( !$gl_oVars->cMember->Signin( $signin_obj ) )
				{
					$gl_oVars->cTpl->assign( 'msg_type', 		'error' );
					$gl_oVars->cTpl->assign( 'msg_title', 		'Fehler');
					$gl_oVars->cTpl->assign( 'msg_text', 		$gl_oVars->aLngBuffer['basic']['c2410'] );
					
					DEBUG( MSGTYPE_ERROR, __FILE__, __LINE__, "Member couldn't signin. `".$signin_obj->email."`" );
				}
				else
				{
					// history
				
				
					# fetch current member-id created
					$iMemberId = $gl_oVars->cDBInterface->InsertId();
					
					
					$mails = new Mails( $gl_oVars->sLanguage );
					$mails->IsHTML(false);		# set als HTML
					
				
					// generate activation url
					$sURL = dirname( $_SERVER['HTTP_REFERER']).EGL_DIRSEP.basename($gl_oVars->sURLFile);
					$activation_url = $sURL.'?page=member.activate&member_id='.$iMemberId.'&code='.$signin_obj->activation_code;
					
					
					# register variables
					$mails->Assign( 'password', 		$_psd );
					$mails->Assign( 'member_id',		$iMemberId	);
					$mails->Assign( 'email',			$signin_obj->email	);
					$mails->Assign( 'nick_name', 		$signin_obj->nick_name	);
					$mails->Assign( 'activation_url', 	$activation_url );
					
					$email_header = new egl_email_header_t;
					$mails->SetSenderMail( $email_header->signin, $email_header->signin_sender );
				
							
					# try sending email
					if( !$mails->SendeMail( 'signin.tpl', $gl_oVars->aLngBuffer['basic']['c2416'], $signin_obj->email/*receiver E-Mail*/ ) )
					{
						$gl_oVars->cTpl->assign( 'msg_type', 		'error' );
						$gl_oVars->cTpl->assign( 'msg_text', 		$gl_oVars->aLngBuffer['basic']['c2410']);

						DEBUG( MSGTYPE_ERROR, __FILE__, __LINE__, 	"Couldn't send E-Mail to . `".$signin_obj->email."` ERROR: ".$mails->GetLastError() );
					}
					else
					{
						$gl_oVars->cTpl->assign( 'signin_success', 1 );
				
						$gl_oVars->cTpl->assign( 'msg_type', 		'success' );
						$gl_oVars->cTpl->assign( 'msg_text', 		$gl_oVars->aLngBuffer['basic']['c2411'] );
						
					}//if
					
				}//if
			}//if
		}//if
		# Signin - Errors
		else
		{
			$gl_oVars->cTpl->assign( 'signin_buffer', $_POST );

			$gl_oVars->cTpl->assign( 'msg_type', 	'error' );
			$gl_oVars->cTpl->assign( 'msg_text', 	$gl_oVars->aLngBuffer['basic']['c2412'] );
		}
		
	} // if get=go ?
	
	
	
	if( $gl_oVars->bLoggedIn )
	{
		$gl_oVars->cTpl->assign( 'msg_type', 	'info' );
		$gl_oVars->cTpl->assign( 'msg_text', 	$gl_oVars->aLngBuffer['basic']['c2413'] );
	}

	$gl_oVars->cTpl->assign( 'msg_errors', GET_PAGE_ERRORS() );
	
	
	# countrylist
	$cCountry = new Country( $gl_oVars->cDBInterface );
	$gl_oVars->cTpl->assign( 'countries', $cCountry->GetCountries() );
?>