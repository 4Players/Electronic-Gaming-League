<?php
	global $gl_oVars;
	
	$iAdminId	= (int) $_GET['admin_id'];
	$iMemberId	= (int) $_GET['member_id'];
	
	
	# declare classes/objects 
	$cAdministrator = new Administrator( $gl_oVars->cDBInterface );

	# declare objects/vars
	$oAdmin				= NULL;
	$aAdminPermissions	= array();

	
	# fetch objects
	if( $iMemberId )
		$oAdmin = $cAdministrator->GetDetailedAdminByMemberId( $iMemberId );
	else if( $iAdminId)
		$oAdmin = $cAdministrator->GetDetailedAdmin( $iAdminId );

		
		
	# admin exists?
	if( !$oAdmin )
	{
		
	}
	else
	{
		if( $_GET['a'] == "attribute" )
		{
			#====================================================================
			# set master
			#====================================================================
			if( $_POST['adminattribute_master'] == 'yes' ) 
			{
				$oPermission = $cAdministrator->GetAdminPermissionByPermission( $iAdminId, 'master' );
				if( !$oPermission ) $cAdministrator->AddPermissions( array( "admin_id" => $iAdminId,
																			"permissions" => "master",
																			"created" => EGL_TIME ) );
				
			}
			else 
			{
				$oPermission = $cAdministrator->GetAdminPermissionByPermission( $iAdminId, 'master' );
				if( $oPermission ) $cAdministrator->DeleteAdminPermission($oPermission->id);
			}
			
			
			#====================================================================
			# set cms
			#====================================================================
			if( $_POST['adminattribute_cms'] == 'yes' ) 
			{
				$oPermission = $cAdministrator->GetAdminPermissionByPermission( $iAdminId, 'cms' );
				if( !$oPermission ) $cAdministrator->AddPermissions( array( "admin_id" => $iAdminId,
																			"permissions" => "cms",
																			"created" => EGL_TIME ) );
				
			}
			else 
			{
				$oPermission = $cAdministrator->GetAdminPermissionByPermission( $iAdminId, 'cms' );
				if( $oPermission ) $cAdministrator->DeleteAdminPermission($oPermission->id);
			}
			
			
			#====================================================================
			# set members
			#====================================================================
			if( $_POST['adminattribute_members'] == 'yes' ) 
			{
				$oPermission = $cAdministrator->GetAdminPermissionByPermission( $iAdminId, 'members' );
				if( !$oPermission ) $cAdministrator->AddPermissions( array( "admin_id" => $iAdminId,
																			"permissions" => "members",
																			"created" => EGL_TIME ) );
				
			}
			else 
			{
				$oPermission = $cAdministrator->GetAdminPermissionByPermission( $iAdminId, 'members' );
				if( $oPermission ) $cAdministrator->DeleteAdminPermission($oPermission->id);
			}
	
			
			
			#====================================================================
			# set clans
			#====================================================================
			if( $_POST['adminattribute_clans'] == 'yes' ) 
			{
				$oPermission = $cAdministrator->GetAdminPermissionByPermission( $iAdminId, 'clans' );
				if( !$oPermission ) $cAdministrator->AddPermissions( array( "admin_id" => $iAdminId,
																			"permissions" => "clans",
																			"created" => EGL_TIME ) );
				
			}
			else 
			{
				$oPermission = $cAdministrator->GetAdminPermissionByPermission( $iAdminId, 'clans' );
				if( $oPermission ) $cAdministrator->DeleteAdminPermission($oPermission->id);
			}
			
			
			#====================================================================
			# set teams
			#====================================================================
			if( $_POST['adminattribute_teams'] == 'yes' ) 
			{
				$oPermission = $cAdministrator->GetAdminPermissionByPermission( $iAdminId, 'teams' );
				if( !$oPermission ) $cAdministrator->AddPermissions( array( "admin_id" => $iAdminId,
																			"permissions" => "teams",
																			"created" => EGL_TIME ) );
				
			}
			else 
			{
				$oPermission = $cAdministrator->GetAdminPermissionByPermission( $iAdminId, 'teams' );
				if( $oPermission ) $cAdministrator->DeleteAdminPermission($oPermission->id);
			}
			
			
			
			#====================================================================
			# set onlinelist
			#====================================================================
			if( $_POST['adminattribute_onlinelist'] == 'yes' ) 
			{
				$oPermission = $cAdministrator->GetAdminPermissionByPermission( $iAdminId, 'onlinelist' );
				if( !$oPermission ) $cAdministrator->AddPermissions( array( "admin_id" => $iAdminId,
																			"permissions" => "onlinelist",
																			"created" => EGL_TIME ) );
				
			}
			else 
			{
				$oPermission = $cAdministrator->GetAdminPermissionByPermission( $iAdminId, 'onlinelist' );
				if( $oPermission ) $cAdministrator->DeleteAdminPermission($oPermission->id);
			}
			

			
			#====================================================================
			# set protests
			#====================================================================
			if( $_POST['adminattribute_protests'] == 'yes' ) 
			{
				$oPermission = $cAdministrator->GetAdminPermissionByPermission( $iAdminId, 'protests' );
				if( !$oPermission ) $cAdministrator->AddPermissions( array( "admin_id" => $iAdminId,
																			"permissions" => "protests",
																			"created" => EGL_TIME ) );
				
			}
			else 
			{
				$oPermission = $cAdministrator->GetAdminPermissionByPermission( $iAdminId, 'protests' );
				if( $oPermission ) $cAdministrator->DeleteAdminPermission($oPermission->id);
			}
						
			
						
			#====================================================================
			# set matches
			#====================================================================
			if( $_POST['adminattribute_matches'] == 'yes' ) 
			{
				$oPermission = $cAdministrator->GetAdminPermissionByPermission( $iAdminId, 'matches' );
				if( !$oPermission ) $cAdministrator->AddPermissions( array( "admin_id" => $iAdminId,
																			"permissions" => "matches",
																			"created" => EGL_TIME ) );
				
			}
			else 
			{
				$oPermission = $cAdministrator->GetAdminPermissionByPermission( $iAdminId, 'matches' );
				if( $oPermission ) $cAdministrator->DeleteAdminPermission($oPermission->id);
			}
			
			PageNavigation::Location( $gl_oVars->sURLFile.'?page='.$gl_oVars->sURLPage.'&admin_id='.$iAdminId );
			
			$gl_oVars->cTpl->assign( "success",		true );
			$gl_oVars->cTpl->assign( "msg_type", 	"success" );
			$gl_oVars->cTpl->assign( "msg_title", 	"Attribute gesetzt" );
			$gl_oVars->cTpl->assign( "msg_text", 	"Attribute wurden gesetzt" );
				
		}
		else if( $_GET['a'] == "delete_permission" )
		{
			$iPermissionId = (int)$_GET['permission_id'];
			if( $cAdministrator->DeleteAdminPermission( $iPermissionId ) )
			{
				PageNavigation::Location( $gl_oVars->sURLFile.'?page='.$gl_oVars->sURLPage.'&admin_id='.$iAdminId );
				
				$gl_oVars->cTpl->assign( "success",		true );
				$gl_oVars->cTpl->assign( "msg_type", 	"success" );
				$gl_oVars->cTpl->assign( "msg_title", 	"Rechte gelöscht" );
				$gl_oVars->cTpl->assign( "msg_text", 	"Die Rechte wurden gelöscht." );
			}
			else
			{
				$gl_oVars->cTpl->assign( "msg_type", 	"error" );
				$gl_oVars->cTpl->assign( "msg_title", 	"Fehler" );
				$gl_oVars->cTpl->assign( "msg_text", 	"Die Rechte konnten nicht gelöscht werden." );
			}
			
		}
		else
		{
			if($oAdmin)
			{
				$aAdminPermissions = $cAdministrator->GetAdminPermissions( $oAdmin->id );
				for( $i=0; $i < sizeof($aAdminPermissions); $i++ )
				{
					if( $aAdminPermissions[$i]->module_id != EGL_NO_ID )
					{
						$aAdminPermissions[$i]->module = $gl_oVars->cModuleManager->GetModule( $aAdminPermissions[$i]->module_id );
					}
				}//for
			}//if
		}//ifelse
		
	
		
		$gl_oVars->cTpl->assign( "admin_permissions", $aAdminPermissions );
		$gl_oVars->cTpl->assign( "admin", $oAdmin );
		
		
	}//if admin exists?

?>