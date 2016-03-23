<?php
	include( EGL_SECURE.'classes'.EGL_DIRSEP.'core'.EGL_DIRSEP.'db'.EGL_DIRSEP.'SQLMySync.class.php' );
	
	global $gl_oVars;
	$cMySync 	= new SQLMySync( $gl_oVars->cDBInterface );
	$local		= $cMySync->CreateLocalSyncMask();
	
	$num_tables = (int)$_POST['num_tables'];

	$aExportTables = array();	
	for( $t=0; $t < $num_tables; $t++ ){
		if( $_POST['tb_'.$t] == 'yes' ){
			$tb_name = $_POST['tb_name_'.$t];
			for( $i=0; $i < sizeof($local); $i++ ){
				if( $local[$i]['name'] == $tb_name ){
					$aExportTables[sizeof($aExportTables)] = $local[$i];
					break;
				}//if
			}//for
		}//if
	}//for
	
	$params = array();
	$export = false;
	if( isset($_POST['export_data'])){
		$export = true;
		if( isset( $_POST['auto_increment']))
			$params['auto_increment'] = true;
	}//if
	
	if( $_POST['export_type'] == 'file' )
	{
		$export = $cMySync->ExportMask( $aExportTables, $export, $params );
		header( 'Content-type: application/octet-stream' );
		header( 'Content-Length: ' . strlen( $export ) );
		header( 'Content-Disposition: attachment; filename="egl-mask.xml"' );
		echo $export;
		exit;
	}
	else if( $_POST['export_type'] == 'text' )
	{
		$export = $cMySync->ExportMask( $aExportTables, $export, $params );
		$export = htmlspecialchars( $export );
		$export = str_replace( '	', '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;', $export );
		
		$gl_oVars->cTpl->assign( 'EXPORT', $export );
	}
?>