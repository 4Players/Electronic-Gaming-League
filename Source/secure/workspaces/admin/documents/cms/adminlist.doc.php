<?php
	global $gl_oVars;
	
	
	
	// create admin instance
	$cAdministrator = new Administrator( $gl_oVars->cDBInterface );
	
	// fetch adminlist
	$aAdminList = $cAdministrator->GetAdminList();

	$gl_oVars->cTpl->assign( "adminlist", $aAdminList );
?>