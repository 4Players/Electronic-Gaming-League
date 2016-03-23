<?php
	global $gl_oVars;


	$aModulesPrev = $gl_oVars->cModuleManager->GetModules();
	$aModules	  = array();
	for( $i=0; $i < sizeof($aModulesPrev); $i++ )
	{
		$aModules[$i] = array( 	'data' => $aModulesPrev[$i],
								'icon' => module_sendmessage( $aModulesPrev[$i]->ID, 'get_configsheet_icon', $__DATA__ )
							  );
	}//for
	
	$aActivatedModules = array();
	$aDeactivatedModules = array();
	$aUninstalledModules = array();

	
	for( $i=0; $i < sizeof($aModules); $i++ )
	{
		# activated 
		if( $aModules[$i]['data']->bActivated )
			$aActivatedModules[sizeof($aActivatedModules)] = $aModules[$i];
		# deactivated
		else if( !$aModules[$i]['data']->bActivated && $aModules[$i]->bInstalled )
			$aDeactivatedModules[sizeof($aDeactivatedModules)] = $aModules[$i];
		# uninstalled
		else if( !$aModules[$i]['data']->bInstalled ) 
			$aUninstalledModules[sizeof($aUninstalledModules)] = $aModules[$i];
	}//for
	$gl_oVars->cTpl->assign( "modules", $aModules );
	

		
	$gl_oVars->cTpl->assign( "modules_activated", $aActivatedModules );
	$gl_oVars->cTpl->assign( "modules_deactivated", $aDeactivatedModules );
	$gl_oVars->cTpl->assign( "modules_uninstalled", $aUninstalledModules );
?>