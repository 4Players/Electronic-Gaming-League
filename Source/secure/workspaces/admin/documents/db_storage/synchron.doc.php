<?php
	include( EGL_SECURE.'classes'.EGL_DIRSEP.'core'.EGL_DIRSEP.'db'.EGL_DIRSEP.'SQLMySync.class.php' );
	
	global $gl_oVars;
	$cMySync = new SQLMySync( $gl_oVars->cDBInterface );
	
	# --------------------------------------------
	# SYNC
	# --------------------------------------------
	if( $_GET['a'] == 'sync' )
	{
		$filename 	= $_POST['sync_file'];
	
		$current 	= $cMySync->CreateSyncMaskFromFile( $filename );
		$local		= $cMySync->CreateLocalSyncMask();

		$aSQLBuffer = $cMySync-> UpdateDB( $local, $current );
		//echo nl2br( print_r( $aSQLBuffer, 1));
		if( is_array($aSQLBuffer) )
		{
			$gl_oVars->cTpl->assign( 'SQL_QUERYS', $aSQLBuffer );
		}
	}
	else if( $_GET['a'] == 'do_sync' )
	{
		$filename 	= $_POST['sync_file'];
		
		$current 	= $cMySync->CreateSyncMaskFromFile( $filename );
		$local		= $cMySync->CreateLocalSyncMask();

		// fetch sql-buffer
		$aSQLBuffer = $cMySync-> UpdateDB( $local, $current );
		$querys_ok	= 0;
		
		// execute sql-buffer
		for( $i=0; $i < sizeof($aSQLBuffer); $i++ ){
			//$qre = true;
			$qre = $gl_oVars->cDBInterface->Query( $aSQLBuffer[$i]['query'] );
			if( !$qre ){
				$aSQLBuffer[$i]['error'] = $gl_oVars->cDBInterface->GetLastError();
			}else{
				//$aSQLBuffer[$i]['error'] = 'Mysql konnte irgendwas nicht machen, was uach immer';
				$querys_ok++;
			}
		}//for
		
		
		$gl_oVars->cTpl->assign( 'DO_SYNC', true );
		$gl_oVars->cTpl->assign( 'QUERYS_OK', $querys_ok );
		$gl_oVars->cTpl->assign( 'SQL_QUERYS', $aSQLBuffer );
	}
?>