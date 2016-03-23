<?php
	global $gl_oVars;

	$iCupId		= (int)$_GET['cup_id'];

	# declare classes and objects
	$cCup 				= new Cup( $gl_oVars->cDBInterface, $iCupId );
	$cGamePool			= new GamePool( $gl_oVars->cDBInterface );
	$cAdministrator		= new Administrator( $gl_oVars->cDBInterface );


	# fetch cup data
	$oCup = $cCup->GetData();
	$oGame = $cGamePool->GetGameById( (int)$oCup->game_id );
	
	
	if( $_GET['a'] == '' )
	{
	}
	
	# ---------------------------------------------------------------------
	# D E L E T E    A D M I N - P E R M I S S I O N S
	# ---------------------------------------------------------------------
	elseif( $_GET['a'] == 'delete_admin' )
	{
		// $iAdminId = (int)$_GET['admin_id'];
		$iAdminPermissionId = (int)$_GET['permission_id'];
		# 
		# execute sql-query directly
		#
		/*
		$sql_query =" DELETE FROM `{$GLOBALS['g_egltb_admin_permissions']}` ".
					" WHERE module_id='".MODULEID_INETOPIA_CUP."' && data='{$iCupId}' && admin_id={$iAdminId} && permissions='cup' ";
		$qre = $gl_oVars->cDBInterface->Query( $sql_query );*/
		
		
		if( $cAdministrator->DeleteAdminPermission($iAdminPermissionId) )
		{
			$gl_oVars->cTpl->assign( 'success', 	true );
			$gl_oVars->cTpl->assign( 'msg_type', 	'success' );
			$gl_oVars->cTpl->assign( 'msg_title', 	'Admin entfernt' );
			$gl_oVars->cTpl->assign( 'msg_text', 	'Die Rechte wurden efolgreich entfernt' );
			
		}
		else
		{
			$gl_oVars->cTpl->assign( 'msg_type', 	'error' );
			$gl_oVars->cTpl->assign( 'msg_title', 	'Fehler' );
			$gl_oVars->cTpl->assign( 'msg_text', 	'Die Rechte konnten nicht entfernt werden.' );
		}
	}
	# ---------------------------------------------------------------------
	# A D D   A D M I N (only permissions) 
	# ---------------------------------------------------------------------
	elseif( $_GET['a'] == 'add_admin' )
	{
		// add by Admin-ID
		$iAdminId = (int)$_POST['admin_id'];
		

		$oAdmin = $cAdministrator->GetAdmin( $iAdminId );
		if( $oAdmin )
		{
			// define object
			$add_obj =  array(	"admin_id"		=> $iAdminId,
								"permissions" 	=> "cup",
								"module_id"		=> MODULEID_INETOPIA_CUP,
								"data"			=> $oCup->id );
			// admin exists?
			$oCupAdminPermission = $gl_oVars->cDBInterface->FetchObject( $gl_oVars->cDBInterface->Query($gl_oVars->cDBInterface->CreateSelectQuery( $GLOBALS['g_egltb_admin_permissions'], $add_obj) ));
			$add_obj["created"]	= EGL_TIME;
			
			// execute query
			if( !$oCupAdminPermission )
			{
				$sql_query = $gl_oVars->cDBInterface->CreateInsertQuery( $GLOBALS['g_egltb_admin_permissions'], $add_obj );
				$qre = $gl_oVars->cDBInterface->Query( $sql_query );
				if( $qre )
				{
					$gl_oVars->cTpl->assign( 'success', 	true );
					$gl_oVars->cTpl->assign( 'msg_type', 	'success' );
					$gl_oVars->cTpl->assign( 'msg_title', 	'Admin hinzugefügt' );
					$gl_oVars->cTpl->assign( 'msg_text', 	'Der Administrator wurde erfolgreich hinzugefügt.' );
					
				}
				else
				{
					$gl_oVars->cTpl->assign( 'msg_type', 	'error' );
					$gl_oVars->cTpl->assign( 'msg_title', 	'Fehler' );
					$gl_oVars->cTpl->assign( 'msg_text', 	'Der Administrator konnte nicht der Rechteliste hinzugefügt werden.' );
				}
			}
			else
			{
				$gl_oVars->cTpl->assign( 'msg_type', 	'error' );
				$gl_oVars->cTpl->assign( 'msg_title', 	'Fehler' );
				$gl_oVars->cTpl->assign( 'msg_text', 	'Die Rechte wurden bereits für diesen Admin vergeben' );
			}

		}
		else
		{
			$gl_oVars->cTpl->assign( 'msg_type', 	'error' );
			$gl_oVars->cTpl->assign( 'msg_title', 	'Fehler' );
			$gl_oVars->cTpl->assign( 'msg_text', 	'Die Administrator-ID existiert nicht.' );
		}

	}

	
	$aCupAdministrator = array();
	$aAdministrator = array();
	
	if( $oCup )$aCupAdministrator = $cCup->GetCupAdministrator( $iCupId );
	if( $oCup )$aAdministrator = $cAdministrator->GetAdminList();
	

	$gl_oVars->cTpl->assign( 'adminlist', $aAdministrator );
	$gl_oVars->cTpl->assign( 'cupadministrator', $aCupAdministrator );
	$gl_oVars->cTpl->assign ( 'cup', $oCup );
	$gl_oVars->cTpl->assign ( 'game', $oGame );
?>