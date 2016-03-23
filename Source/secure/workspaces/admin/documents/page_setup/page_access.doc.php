<?php

	global $gl_oVars;

	
	# get work directory
	$sWorkspace 	= $_GET['ws'];


	/*
	# get workspaces
	$aWorkspaces = array();
	$cWorkspaceDir = new CDirectory();
	if( $cWorkspaceDir->Open( EGL_SECURE ."templates" ) )
	{
		
		$aWorkspaces = $cWorkspaceDir->GetDirs();
		$cWorkspaceDir->Close();
	}//if
	
	
	
	# get workspace files
	$aWorkspaceFiles = array();
	$cWorkspaceFiles = new CDirectory();
	if( $cWorkspaceFiles->Open( WORKSPACE_DIR ."/{$sWorkspace}/templates/" ) )
	{
		
		$aWorkspaceFiles = $cWorkspaceFiles->GetFiles();
		$cWorkspaceFiles->Close();
		
		
	}//if

	
	$cPageAccess = new CPageAccess( $__DATA__, $__DATA__ );
	$cPageAccess->SetAccessFile( EGL_SECURE . 'gc/pages.access.gc');
	
	$aPageAccessVarBuffer = $cPageAccess->GetVarBuffer();
	
	$aWorkspaceFileAcess = array();
	for( $i=0; $i < sizeof($aWorkspaceFiles); $i++ )
	{
		if( get_file_extension( $aWorkspaceFiles[$i], 1 ) == 'TPL' )
		{
			$aWorkspaceFiles[$i] = substr( $aWorkspaceFiles[$i], 0, strlen($aWorkspaceFiles[$i])-4);
			$aWorkspaceFileAcess[$i] = $aPageAccessVarBuffer[$sWorkspace][$aWorkspaceFiles[$i]];
		}//if
	}//for	
	
	$gl_oVars->cTpl->assign( 'curr_workspace',	 		$sWorkspace);

	
	$gl_oVars->cTpl->assign( 'workspaces',	 			$aWorkspaces);
	$gl_oVars->cTpl->assign( 'workspacefiles',			$aWorkspaceFiles);
	$gl_oVars->cTpl->assign( 'workspacefileaccess',		$aWorkspaceFileAcess);
	*/
	
?>