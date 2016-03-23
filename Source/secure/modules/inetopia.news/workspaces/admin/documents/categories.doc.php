<?php
	global $gl_oVars;
	
	$cNews = new News( $gl_oVars->cDBInterface );
	$cMyCategory = new MyCategory( $gl_oVars->cDBInterface );
	$cAdministrator = new Administrator( $gl_oVars->cDBInterface );
	
	# get settings from module, new categorie root-ID
	$iCatRoot = module_sendmessage( $gl_oVars->sModuleId, 'get_settings', $__DATA__, 'cat_root_id' );
	$iCatId		= (int)$iCatRoot;
	
	
	if( isset($_GET['cat_id'])) $iCatId = (int)$_GET['cat_id'];
	if( $_GET['a'] == 'createnews' )
	{
		$news_obj = array( 	'cat_id' => $iCatId,
							'title' => $_POST['news_title'],
							'short_text' => $_POST['news_short_text'],
							'text' => $_POST['news_text'],
							'created' => EGL_TIME,
							'released' => EGL_TIME  );
		$cNews->CreateNews( $news_obj );
	}
	# ---------------------------------------------------------------------
	# D E L E T E    A D M I N - P E R M I S S I O N S
	# ---------------------------------------------------------------------
	elseif( $_GET['a'] == 'delete_admin' )
	{
		$iAdminPermissionId = (int)$_GET['permission_id'];
	
		if( $cAdministrator->DeleteAdminPermission($iAdminPermissionId) )
		{
			$gl_oVars->cTpl->assign( 'success', 	true );
			$gl_oVars->cTpl->assign( 'msg_type', 	'success' );
			$gl_oVars->cTpl->assign( 'msg_title', 	'Admin entfernt' );
			$gl_oVars->cTpl->assign( 'msg_text', 	'Der Administrator wurde erfolgreich aus der Rechteliste des Cups entfernt.' );
			
		}
		else
		{
			$gl_oVars->cTpl->assign( 'msg_type', 	'error' );
			$gl_oVars->cTpl->assign( 'msg_title', 	'Fehler' );
			$gl_oVars->cTpl->assign( 'msg_text', 	'Der Administrator konnte nicht aus der Rechteliste des Cups entfernt werden.' );
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
								"permissions" 	=> "news",
								"module_id"		=> MODULEID_INETOPIA_NEWS,
								"data"			=> $iCatId );
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
					$gl_oVars->cTpl->assign( 'msg_title', 	'Admin hinzugef�gt' );
					$gl_oVars->cTpl->assign( 'msg_text', 	'Der Administrator wurde erfolgreich hinzugef�gt.' );
					
				}
				else
				{
					$gl_oVars->cTpl->assign( 'msg_type', 	'error' );
					$gl_oVars->cTpl->assign( 'msg_title', 	'Fehler' );
					$gl_oVars->cTpl->assign( 'msg_text', 	'Der Administrator konnte nicht der Rechteliste hinzugef�gt werden.' );
				}
			}
			else
			{
				$gl_oVars->cTpl->assign( 'msg_type', 	'error' );
				$gl_oVars->cTpl->assign( 'msg_title', 	'Fehler' );
				$gl_oVars->cTpl->assign( 'msg_text', 	'Die Rechte wurden bereits f�r diesen Admin vergeben' );
			}

		}
		else
		{
			$gl_oVars->cTpl->assign( 'msg_type', 	'error' );
			$gl_oVars->cTpl->assign( 'msg_title', 	'Fehler' );
			$gl_oVars->cTpl->assign( 'msg_text', 	'Die Administrator-ID existiert nicht.' );
		}

	}

	
	// generate tree 
	$oNewsCategories 	= $cMyCategory->GenerateTree( $iCatId );
	$aCategoryNews 		= $cNews->GetCategoryNews( $iCatId, 100, false );

	// define arrays
	$aCategoryAdministrator = array();
	$aAdministrator = array();
	
	# fetch admins
	$aCategoryAdministrator = $cNews->GetCategoryAdministrator( $iCatId );
	$aAdministrator = $cAdministrator->GetAdminList();
	
	
	$gl_oVars->cTpl->assign( "adminlist", $aAdministrator );
	$gl_oVars->cTpl->assign( "categoryadmins", $aCategoryAdministrator );

	
	
	$aPath = $cMyCategory->GetPath( $oNewsCategories->oProperties->id );
	$gl_oVars->cTpl->assign( "path", $aPath );

	$gl_oVars->cTpl->assign( 'newscategories', $oNewsCategories );
	$gl_oVars->cTpl->assign( 'categorynews', $aCategoryNews );
	
?>