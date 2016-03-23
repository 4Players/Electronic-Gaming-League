<?php
	global $gl_oVars;

	$cManagedCronsServer = new ManagedCronsServer( $gl_oVars->cDBInterface );
	$aManagedCrons = $cManagedCronsServer->GetManagedCrons();
	

	$gl_oVars->cTpl->assign( 'managedcrons', 	$aManagedCrons );
?>