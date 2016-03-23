<?php
	global $gl_oVars;
	
	$cFastChallenge = new FastChallenge( $gl_oVars->cDBInterface );
	$cFastChallenge->GenerateMatchesFromPool( 1 );
	
	
	/*
	$mod_root = $gl_oVars->cModuleManager->GetModuleRoot( 'A9CCDCBF-C696-422c-A0D8-91223A9C22E6' );
	$mod_root .= 'templates'.EGL_DIRSEP.'emails'.EGL_DIRSEP;
	$cMails = new Mails( $gl_oVars->sLanguage, $mod_root );
	if( !$cMails->SendeMail( 'fc_no_match_generation.tpl', 'test', 'kay.fleischmann@gmx.de' ) ){
		echo "error";
	}*/
?>