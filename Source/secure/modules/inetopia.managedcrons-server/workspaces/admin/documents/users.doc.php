<?php
	global $gl_oVars;
	$cManagedCronsServer = new ManagedCronsServer( $gl_oVars->cDBInterface );
	
	
	$aUsers = $cManagedCronsServer->GetUsers();
	$gl_oVars->cTpl->assign( 'users', $aUsers );
?>