<?php
	global $gl_oVars;
	
	$aModules = $gl_oVars->cModuleManager->GetModules();
	
	// fetch url data
	$module_id = $_GET['mid'];
	
	# --------------------------------------
	# Install cMod
	# --------------------------------------
	
	# install cmod
	if( $_GET['a'] == 'install' )
	{
		if( $gl_oVars->cModuleManager->InstallModule( $module_id ) )
		{
			$gl_oVars->cTpl->assign( 'msg_type', 	'success' ); 
			$gl_oVars->cTpl->assign( 'msg_title', 	'Module Installiert!' ); 
			$gl_oVars->cTpl->assign( 'msg_text', 	'Das Module wurde erfolgreich installiert! {forwarding sec=1}' ); 
			
			$gl_oVars->cTpl->assign( 'success', true );
		}
	}
	elseif( $_GET['a'] == 'uninstall' )
	{
		
		# uninstall cmod
		if( $gl_oVars->cModuleManager->UninstallModule( $module_id ) )
		{
			$gl_oVars->cTpl->assign( 'msg_type', 	'success' ); 
			$gl_oVars->cTpl->assign( 'msg_title', 	'Module Deinstalliert!' ); 
			$gl_oVars->cTpl->assign( 'msg_text', 	'Das Module wurde erfolgreich deinstalliert! {forwarding sec=1}' ); 

			$gl_oVars->cTpl->assign( 'success', true );
			
		
		}//if
	}
	elseif( $_GET['a'] == 'activate' )
	{
		# activate cmod
		if( $gl_oVars->cModuleManager->ActivateModule( $module_id ) )
		{
			$gl_oVars->cTpl->assign( 'msg_type', 	'success' ); 
			$gl_oVars->cTpl->assign( 'msg_title', 	'Module aktiviert!' ); 
			$gl_oVars->cTpl->assign( 'msg_text', 	'Der Module wurde erfolgreich aktiviert! {forwarding sec=1}' ); 

			$gl_oVars->cTpl->assign( 'success', true );
		}		
	}
	elseif( $_GET['a'] == 'deactivate' )
	{
		# activate cmod
		if( $gl_oVars->cModuleManager->DeactivateModule( $module_id ) )
		{
			$gl_oVars->cTpl->assign( 'msg_type', 	'success' ); 
			$gl_oVars->cTpl->assign( 'msg_title', 	'Module deaktiviert!' ); 
			$gl_oVars->cTpl->assign( 'msg_text', 	'Das Module wurde erfolgreich deaktiviert! {forwarding sec=1}' ); 

			$gl_oVars->cTpl->assign( 'success', true );
		}		
	}	

	$gl_oVars->cTpl->assign( "modules", $aModules );
?>