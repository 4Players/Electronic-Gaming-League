<?php
	global $gl_oVars;
		
	// fetch navigation routing
	$next_sheet = $gl_oVars->pcRuntimeEngine->cInstallWizard->NextSheetByName( $gl_oVars->sURLPage );
	$prev_sheet = $gl_oVars->pcRuntimeEngine->cInstallWizard->PrevSheetByName( $gl_oVars->sURLPage );

	
	# fetch objects/ other data
	$aModules = $gl_oVars->cModuleManager->GetModules();

	
	
	if( $_GET['a'] == 'next' )
	{
		// save ...
		$aModulesInstalled = array();
		for( $mod=0; $mod < sizeof($aModules); $mod++ )
		{
			if( $_POST['installmodule_'.$mod] == 'yes' ){
				$aModulesInstalled[sizeof($aModulesInstalled)] = $aModules[$mod]->ID;
			}
		}
		
		
		# routing to next page
		if( $next_sheet ){
			
			$_SESSION[$gl_oVars->sURLPage]['modules']['install'] 			= $aModulesInstalled;
					
			
			PageNavigation::Location( $gl_oVars->sURLFile.'?page='.$next_sheet['name'] );
		}
	}
	

	
	

	$gl_oVars->cTpl->assign( 'modules', $aModules );
	$gl_oVars->cTpl->assign( "URL_PREV", $gl_oVars->sURLFile.'?page='.$prev_sheet['name'] );
		
?>