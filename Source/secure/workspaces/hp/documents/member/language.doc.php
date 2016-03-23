<?php
	global $gl_oVars;
	

	$cLanguage = new Language();
	//$cCountry = new Country( $gl_oVars->cDBInterface );
	//$sheet = $gl_oVars->pcRuntimeEngine->cInstallWizard->FirstSheet();
	//PageNavigation::Location( $gl_oVars->sURLFile.'?page=mode' );#
	
	$aSupportedLanguages = $cLanguage->GetSupportedLanguagesFromWorkspace( $gl_oVars->sWorkspace );
	
	//$gl_oVars->pcRuntimeEngine->SelectLanguage( 'eng' );
	//echo $gl_oVars->pcRuntimeEngine->GetSelectedLanguage();
	
	if( isset($_POST['lng'])){
		$member_update = array( 'language'	=> $_POST['lng'] );
		$gl_oVars->cMember->SetMemberDataById( $member_update, $gl_oVars->iMemberId );
		$_SESSION['member']['lng'] = $_POST['lng'];
		
		PageNavigation::Location( $gl_oVars->sURLFile.'?page='.$gl_oVars->sURLPage );
	}
	
	//$_SESSION['usr']['lng'] = 'de';
	//echo $_SESSION['usr']['lng'];
	
	$gl_oVars->cTpl->assign( 'languages', $aSupportedLanguages );
?>