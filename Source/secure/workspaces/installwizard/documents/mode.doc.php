<?php
	global $gl_oVars;
		
	// fetch navigation routing
	$next_sheet = $gl_oVars->pcRuntimeEngine->cInstallWizard->NextSheetByName( $gl_oVars->sURLPage );
	$prev_sheet = $gl_oVars->pcRuntimeEngine->cInstallWizard->PrevSheetByName( $gl_oVars->sURLPage );


	if( $_GET['a'] == 'install' )
	{
		$_SESSION['mode'] = 'install';
		PageNavigation::Location( $gl_oVars->sURLFile.'?page='.$gl_oVars->sURLPage.'&a=next' );
	}
	else if( $_GET['a'] == 'configure' )
	{
		// save ...
		$_SESSION['mode'] = 'configure';
		PageNavigation::Location( $gl_oVars->sURLFile.'?page='.$gl_oVars->sURLPage.'&a=next' );
	}
	
	# routing to next page
	if($_GET['a'] == 'next'){
		
		PageNavigation::Location( $gl_oVars->sURLFile.'?page='.$next_sheet['name'] );
	}
	

	//$gl_oVars->cTpl->assign( "URL_PREV", $gl_oVars->sURLFile.'?page='.$prev_sheet['name'] );
	$gl_oVars->cTpl->assign( 'FINISHED',  true );
?>