<?php
	include( EGL_SECURE.'classes'.EGL_DIRSEP.'core'.EGL_DIRSEP.'db'.EGL_DIRSEP.'SQLMySync.class.php' );
	
	global $gl_oVars;
	$cMySync 	= new SQLMySync( $gl_oVars->cDBInterface );
	$local		= $cMySync->CreateLocalSyncMask();
	

	$gl_oVars->cTpl->assign ( 'LOCAL_MASK', $local );
?>