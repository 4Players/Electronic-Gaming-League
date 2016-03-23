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
		
		$register_input = array( 	'nick_name'		=> $_POST['display_name'],
									'email'			=> $_POST['email'],
									'password' 		=> $_POST['password'],
									'repassword'	=> $_POST['repassword'],
									'register_key'	=> $_POST['register_key'],
									);
		
		
		# email given ?
		if( !Check_eMail($register_input['email'])  )
		{
			$bError = true;
			// email
			ADD_PAGE_ERROR( $gl_oVars->aLngBuffer['basic']['c2407'] );
		}
	
		# email given ?
		if( md5( $register_input['password']) != md5( $register_input['repassword']) )
		{
			$bError = true;
			ADD_PAGE_ERROR( $gl_oVars->aLngBuffer['basic']['c2406'] );
		}
		
		
		# ------------------
		# ERROR 
		# ------------------
		if( !$bError ) 
		{
			# Member currently available ?	
			if( $gl_oVars->cMember->MemberExists( array( 'email' => $register_input['email'], 'nick_name' => $register_input['nick_name']) ) )
			{
				$gl_oVars->cTpl->assign( 'msg_type', 		'error' );
				//$gl_oVars->cTpl->assign( 'msg_title', 		'Hinweis');
				$gl_oVars->cTpl->assign( 'msg_text', 		$gl_oVars->aLngBuffer['basic']['c2409'] );
			}
			# Signin - Access ?!!
			else
			{
				
				# save selected nationality
				//$signin_obj->country_id	 = (int)$_POST['signin_country_id'];
				
				# generate random password (5 chars)
				
				$register_obj  = array( 'nick_name'			=> $register_input['nick_name'],
										'email'				=> $register_input['email'],
										'created'			=> EGL_TIME,
										'password'			=> md5($register_input['password']),
										'activation_code'	=> md5( EGL_TIME.CreateRandomPassword() ),
										'activation_time'	=> 0,
										);
										
				# try signing in !!
				if( !$gl_oVars->cMember->Signin( $register_obj ) )
				{
					$gl_oVars->cTpl->assign( 'msg_type', 		'error' );
					$gl_oVars->cTpl->assign( 'msg_title', 		'Fehler');
					$gl_oVars->cTpl->assign( 'msg_text', 		$gl_oVars->aLngBuffer['basic']['c2410'] );
					
					DEBUG( MSGTYPE_ERROR, __FILE__, __LINE__, "Member couldn't signin. `".$register_obj['email']."`" );
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
					$activation_url = $sURL.'?page=member.activate&member_id='.$iMemberId.'&code='.$register_obj['activation_code'];
					
					
					# register variables
					$mails->Assign( 'password', 		$_psd );
					$mails->Assign( 'member_id',		$iMemberId	);
					$mails->Assign( 'email',			$register_obj['email']	);
					$mails->Assign( 'activation_url', 	$activation_url );
					
					$email_header = new egl_email_header_t;
					$mails->SetSenderMail( $email_header->signin, $email_header->signin_sender );
				
							
					# try sending email
					if( !$mails->SendeMail( 'signin.tpl', $gl_oVars->aLngBuffer['basic']['c2502'], $register_obj['email']/*receiver E-Mail*/ ) )
					{
						$gl_oVars->cTpl->assign( 'msg_type', 		'error' );
						//$gl_oVars->cTpl->assign( 'msg_title', 		'Fehler' );
						$gl_oVars->cTpl->assign( 'msg_text', 		$gl_oVars->aLngBuffer['basic']['c2410']);

						DEBUG( MSGTYPE_ERROR, __FILE__, __LINE__, 	"Couldn't send E-Mail to . `".$register_obj['email']."` ERROR: ".$mails->GetLastError() );
					}
					else
					{
						$gl_oVars->cTpl->assign( 'signin_success', 1 );
				
						$gl_oVars->cTpl->assign( 'msg_type', 		'success' );
						//$gl_oVars->cTpl->assign( 'msg_title', 		'Anmeldung erfolgt' );
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