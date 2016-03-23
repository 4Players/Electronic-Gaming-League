<?php
	global $gl_oVars;

	
	
	$cInstallManager = new InstallFactory();
	$aLocalUpdates = $cInstallManager->GetLocalUpdates();

	// filter not installed updates
	$aLatestUpdates = $aLocalUpdates;
	
	
	$gl_oVars->cTpl->assign ( 'latest_updates', $aLatestUpdates);s
	
?>