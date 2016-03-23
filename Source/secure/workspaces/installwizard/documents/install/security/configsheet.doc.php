<?php
	global $gl_oVars;
		
	// fetch navigation routing
	$next_sheet = $gl_oVars->pcRuntimeEngine->cInstallWizard->NextSheetByName( $gl_oVars->sURLPage );
	$prev_sheet = $gl_oVars->pcRuntimeEngine->cInstallWizard->PrevSheetByName( $gl_oVars->sURLPage );

	
	
	if( $_GET['a'] == 'next' )
	{
		// save ...
		$_SESSION[$gl_oVars->sURLPage]['configsheet']['username'] 	= $_POST['username'];
		$_SESSION[$gl_oVars->sURLPage]['configsheet']['password'] 	= $_POST['password'];
		
		
		
		
		# routing to next page
		if( $next_sheet ){
			PageNavigation::Location( $gl_oVars->sURLFile.'?page='.$next_sheet['name'] );
		}
	}
	

	$gl_oVars->cTpl->assign( "URL_PREV", $gl_oVars->sURLFile.'?page='.$prev_sheet['name'] );
	$gl_oVars->cTpl->assign( "PAGE_ADVICE", $gl_oVars->aLngBuffer['basic']['c2104'] );
?>