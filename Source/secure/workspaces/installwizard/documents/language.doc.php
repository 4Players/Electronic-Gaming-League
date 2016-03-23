<?php
	global $gl_oVars;
	

	$cLanguage = new Language();
	//$cCountry = new Country( $gl_oVars->cDBInterface );
	//$sheet = $gl_oVars->pcRuntimeEngine->cInstallWizard->FirstSheet();
	//PageNavigation::Location( $gl_oVars->sURLFile.'?page=mode' );#
	
	$aSupportedLanguages = $cLanguage->GetSupportedLanguagesFromWorkspace( $gl_oVars->sWorkspace );
	
	//$gl_oVars->pcRuntimeEngine->SelectLanguage( 'eng' );
	//echo $gl_oVars->pcRuntimeEngine->GetSelectedLanguage();
	
	
	//$_SESSION['usr']['lng'] = 'de';
	//echo $_SESSION['usr']['lng'];
	
	
	if( $_GET['a'] == 'next' ){
		$gl_oVars->pcRuntimeEngine->SelectLanguage( $_POST['lng'] );
		
		PageNavigation::Location( $gl_oVars->sURLFile.'?page=systemcheck' );
	}
	
	
	$gl_oVars->cTpl->assign( 'languages', $aSupportedLanguages );
?>