<?php
	global $gl_oVars;
	
	require( EGL_SECURE.'classes'.EGL_DIRSEP.'core'.EGL_DIRSEP.'managedcrons'.EGL_DIRSEP.'ManagedCronBase.class.php' );
	
	
	$cDBConfigs = new DBConfigs( $gl_oVars->cDBInterface );
	$cManagedCronBase = new ManagedCronBase( $gl_oVars->cDBInterface );
	
	$aConfigs = $cDBConfigs->FetchConfigArray();
	
	$mc_server_url = $aConfigs['managedcrons_server_url']; 
	$cMCClient = new ServiceClient( $gl_oVars->cDBInterface, $mc_server_url );
	$cMCClient->SetKey( $aConfigs['managedcrons_key'] );
	
	
	$bError = false;
	
	#---------------------------------------
	# REGISTER ManagedCron
	#---------------------------------------
	if( $_GET['a'] == 'register' )
	{
		$managedcron_id = $_GET['managedcron_id'];
		$result = $cMCClient->Call( 'managedcrons.register', array('managedcron_id' => $managedcron_id ) );
		
		if( $cMCClient->IsFault() )
		{
			if(  $cMCClient->GetFaultCode() == 'unknownkey_request' ){
				$gl_oVars->cTpl->assign( 'msg_type', 'error' );
				$gl_oVars->cTpl->assign( 'msg_text', $gl_oVars->aLngBuffer['module']['c1011'] );
			}//if
			else{
				$gl_oVars->cTpl->assign( 'msg_type', 'error' );
				$gl_oVars->cTpl->assign( 'msg_text', 'Code: '.$cMCClient->GetFaultCode().'<br/>Detail:'.$cMCClient->GetFaultString() );
			}
		}else
		{
			if( $result )
			{
				// get cronlist
				PageNavigation::Location( $gl_oVars->sURLFile."?page=".$gl_oVars->sURLRealPage );
			}
			else
			{
				if( $cMCClient->GetError() ){
					$bError = true;
				}//if
			}//if
		}//if
	}
	#---------------------------------------
	# REGISTER ManagedCron
	#---------------------------------------
	else if( $_GET['a'] == 'unregister' )
	{
		$managedcron_id = $_GET['managedcron_id'];
		$result = $cMCClient->Call( 'managedcrons.unregister', array('managedcron_id' => $managedcron_id ) );
		if( $cMCClient->IsFault() )
		{
			if(  $cMCClient->GetFaultCode() == 'unknownkey_request' ){
				$gl_oVars->cTpl->assign( 'msg_type', 'error' );
				$gl_oVars->cTpl->assign( 'msg_text', $gl_oVars->aLngBuffer['module']['c1011'] );
			}//if
			else{
				$gl_oVars->cTpl->assign( 'msg_type', 'error' );
				$gl_oVars->cTpl->assign( 'msg_text', 'Code: '.$cMCClient->GetFaultCode().'<br/>Detail:'.$cMCClient->GetFaultString() );
			}
		}else
		{
			if( $result )
			{
				// get cronlist
				PageNavigation::Location( $gl_oVars->sURLFile."?page=".$gl_oVars->sURLRealPage );
			}
			else
			{
				if( $cMCClient->GetError() ){
					$bError = true;
				}//if
			}//if
		}//if
	}
	else
	{
		
		// fetch services		
		$aManagedCrons = $cMCClient->Call( 'managedcrons.list' );
		// fault?
		if( $cMCClient->IsFault() )
		{
			if(  $cMCClient->GetFaultCode() == 'unknownkey_request' ){
				$gl_oVars->cTpl->assign( 'msg_type', 'error' );
				$gl_oVars->cTpl->assign( 'msg_text', $gl_oVars->aLngBuffer['module']['c1011'] );
			}//if
			else{
				$gl_oVars->cTpl->assign( 'msg_type', 'error' );
				$gl_oVars->cTpl->assign( 'msg_text', 'Code: '.$cMCClient->GetFaultCode().'<br/>Detail:'.$cMCClient->GetFaultString() );
			}
		}else
		{
			if( $aManagedCrons )
			{
				for( $i=0; $i < sizeof($aManagedCrons); $i++ ){
					if( $cManagedCronBase->VersionCheck( $aManagedCrons[$i]['required_moduleid'], $aManagedCrons[$i]['required_version'] ) ){
						$aManagedCrons[$i]['system_requirements'] = true;
					}
					else{
						// fetch module data, if necessary
						if( $aManagedCrons[$i]['required_moduleid'] != EGL_NO_ID ){
							$oModule = $gl_oVars->cModuleManager->GetModule( $aManagedCrons[$i]['required_moduleid'] );
							if( $oModule ){
								$aManagedCrons[$i]['available_module']['id'] 		= $oModule->ID;
								$aManagedCrons[$i]['available_module']['name'] 		= $oModule->sName;
								$aManagedCrons[$i]['available_module']['version'] 	= $oModule->sVersion;
							}//if
						}//if
						$aManagedCrons[$i]['system_requirements'] = false;
					}
				}//for
				
				// get cronlist
				$gl_oVars->cTpl->assign( "managedcrons", $aManagedCrons );
			}
			else
			{
				if( $cMCClient->GetError() ){
					$bError = true;
				}
			}//if no error
		}//if fault
	}//if
	
	// on error - output
	if( $bError ){
				// errror? => no xml point?
		$gl_oVars->cTpl->assign( 'msg_type', 'error' );
		$gl_oVars->cTpl->assign( 'msg_text', $cMCClient->GetError() );
	}
?>