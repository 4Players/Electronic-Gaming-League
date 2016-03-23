<?php
	global $gl_oVars;
	$cManagedCronsServer = new ManagedCronsServer( $gl_oVars->cDBInterface );
	
	
	
	if( $_GET['a'] == 'go' ){
		$obj_add = 	array( 	'name'					=> $_POST['name'],
							'managedcron_id'		=> $_POST['managedcron_id'],
							'required_moduleid'		=> $_POST['module_id'],
							'required_version'		=> $_POST['version'],
							'ticks'					=> $_POST['ticks'],
							'uri'					=> $_POST['ticks'],
						 );
		if( $cManagedCronsServer->AddManagedCron( $obj_add ) ){
			$gl_oVars->cTpl->assign( 'success', 1 );
			$gl_oVars->cTpl->assign( 'msg_type', 'success' );
			$gl_oVars->cTpl->assign( 'msg_text', 'Der ManagedCron wurde gerade erstellt.' );
		}
		else{
			$gl_oVars->cTpl->assign( 'msg_type', 'error' );
			$gl_oVars->cTpl->assign( 'msg_text', 'Es ist ein Fehler aufgetreten' );
		}
		
	}
?>