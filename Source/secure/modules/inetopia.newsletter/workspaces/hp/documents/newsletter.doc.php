<?php
	global $gl_oVars;

	#---------------------------------------
	# Running 
	#---------------------------------------
	
	#  create newsletter object
	$cNewsletter = new InetNewsletter( $gl_oVars->cDBInterface, "egl_inetopia_newsletter");
	
	
	
	# ADD ?
	if( $_GET['a'] == 'add' )
	{
		if( Check_eMail( $_POST['newsletter_email']))
		{
			$obj = NULL;
			$obj->email = strtolower($_POST['newsletter_email']);
			$obj->code	= CreateRandomPassword(20);
			$obj->created = EGL_TIME;
			
			# mail currently exists ?
			if( !$cNewsletter->MailExists( $obj->email))
			{
				$cNewsletter->AddMail($obj);
				$gl_oVars->cTpl->assign( 'msg_type', 	'success' );
				$gl_oVars->cTpl->assign( 'msg_title', 	'Eingetragen' );
				$gl_oVars->cTpl->assign( 'msg_text', 	'Ihre E-Mail wurde erfolgreich eingetragen!' );
			}
			else
			{
				$gl_oVars->cTpl->assign( 'msg_type', 	'info' );
				$gl_oVars->cTpl->assign( 'msg_title', 	'Info' );
				$gl_oVars->cTpl->assign( 'msg_text', 	'<u>ACHTUNG:</u> Diese E-Mail <i>\''. $obj->email.'\'</i> ist bereits eingetragen! ' );
			}
		}
		else
		{
			$gl_oVars->cTpl->assign( 'msg_type', 	'error' );
			$gl_oVars->cTpl->assign( 'msg_title', 	'Fehler' );
			$gl_oVars->cTpl->assign( 'msg_text', 	'Die angegebene E-Mail ist falsch' );
		}	
		
	}
	# REMOVE ?
	else if( $_GET['a'] == 'remove' )
	{
		# check 
		if( $cNewsletter->CheckMailCode($_GET['email'], $_GET['code']) )
		{
			$cNewsletter->RemoveMail( $_GET['email']);
			$gl_oVars->cTpl->assign( 'msg_type', 	'success' );
			$gl_oVars->cTpl->assign( 'msg_title', 	'Ausgetragen' );
			$gl_oVars->cTpl->assign( 'msg_text', 	'Die E-Mail wurde erfolgreich ausgetragen!' );
		}
		else
		{
			$gl_oVars->cTpl->assign( 'msg_type', 	'error' );
			$gl_oVars->cTpl->assign( 'msg_title', 	'Fehler' );
			$gl_oVars->cTpl->assign( 'msg_text', 	'Die angegebene E-Mail konnte nicht ausgetraen werden!' );
		}
	}
	else
	{
		$gl_oVars->cTpl->assign( 'msg_type', 	'error' );
		$gl_oVars->cTpl->assign( 'msg_title', 	'Fehler' );
		$gl_oVars->cTpl->assign( 'msg_text', 	'Es ist ein unbekannter Fehler aufgetreten' );
	}



?>