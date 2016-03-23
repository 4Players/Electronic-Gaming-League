<?php
	global $gl_oVars;
		
	// fetch navigation routing
	$next_sheet = $gl_oVars->pcRuntimeEngine->cInstallWizard->NextSheetByName( $gl_oVars->sURLPage );
	$prev_sheet = $gl_oVars->pcRuntimeEngine->cInstallWizard->PrevSheetByName( $gl_oVars->sURLPage );

	
	
	if( $_GET['a'] == 'next' )
	{
		// save ...
		// save ...
		$_SESSION[$gl_oVars->sURLPage]['mails']['support'] 			= $_POST['email_support'];
		$_SESSION[$gl_oVars->sURLPage]['mails']['contact'] 			= $_POST['email_contact'];
		$_SESSION[$gl_oVars->sURLPage]['mails']['webmaster'] 		= $_POST['email_webmaster'];
		$_SESSION[$gl_oVars->sURLPage]['mails']['lostpassword'] 	= $_POST['email_lostpassword'];
		$_SESSION[$gl_oVars->sURLPage]['mails']['signin'] 			= $_POST['email_signin'];
		$_SESSION[$gl_oVars->sURLPage]['mails']['noresponse'] 		= $_POST['email_noreponse'];
		$_SESSION[$gl_oVars->sURLPage]['mails']['sender'] 			= $_POST['sender'];
				
		
		
		# routing to next page
		if( $next_sheet ){
			PageNavigation::Location( $gl_oVars->sURLFile.'?page='.$next_sheet['name'] );
		}
	}
	

	$gl_oVars->cTpl->assign( "URL_PREV", $gl_oVars->sURLFile.'?page='.$prev_sheet['name'] );
	$gl_oVars->cTpl->assign( "PAGE_ADVICE", $gl_oVars->aLngBuffer['basic']['c2104'] );
?>