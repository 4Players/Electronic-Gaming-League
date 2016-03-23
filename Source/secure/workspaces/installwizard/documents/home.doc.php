<?php
	global $gl_oVars;
	$gl_oVars->pcRuntimeEngine->SelectLanguage( 'de' ); // set default language
	
	//$sheet 	= $gl_oVars->pcRuntimeEngine->cInstallWizard->FirstSheet();
		
	PageNavigation::Location( $gl_oVars->sURLFile.'?page=language' );
?>