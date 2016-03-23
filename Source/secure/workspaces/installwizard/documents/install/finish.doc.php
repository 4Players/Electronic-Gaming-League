<?php
	global $gl_oVars;
		
	// fetch navigation routing
	$next_sheet = $gl_oVars->pcRuntimeEngine->cInstallWizard->NextSheetByName( $gl_oVars->sURLPage );
	$prev_sheet = $gl_oVars->pcRuntimeEngine->cInstallWizard->PrevSheetByName( $gl_oVars->sURLPage );


	#	$aModules = $gl_oVars->cModuleManager->GetModules();

	/*
	NOT AVAIABLE
	if( $_GET['a'] == 'next' )
	{
		// save ...
		
		
		
		# routing to next page
		if( $next_sheet ){
			PageNavigation::Location( $gl_oVars->sURLFile.'?page='.$next_sheet['name'] );
		}
	}*/
	
	
	
	
	
	
	

	$gl_oVars->cTpl->assign( "URL_PREV", $gl_oVars->sURLFile.'?page='.$prev_sheet['name'] );
	$gl_oVars->cTpl->assign( 'FINISHED',  true );
?>