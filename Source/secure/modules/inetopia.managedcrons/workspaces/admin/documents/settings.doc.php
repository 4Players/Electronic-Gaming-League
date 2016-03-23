<?php
	global $gl_oVars;
	
	// configs
	$cDBConfigs = new DBConfigs( $gl_oVars->cDBInterface );
	
	
	if( $_GET['a'] == 'change' ){
		
		$cDBConfigs->SetConfig( 'managedcrons_key', 		$_POST['key'] );
		$cDBConfigs->SetConfig( 'managedcrons_server_url',	$_POST['server_url'] );
		
		PageNavigation::Location( $gl_oVars->sURLFile."?page=".$gl_oVars->sURLRealPage );	
	}
	
	
	$aConfigs = $cDBConfigs->FetchConfigArray();
	
	$gl_oVars->cTpl->assign ( 'key',		 $aConfigs['managedcrons_key']  );
	$gl_oVars->cTpl->assign ( 'server_url',  $aConfigs['managedcrons_server_url'] );
?>