<?php
	global $gl_oVars;
	
	$iForumId		= (int)$_GET['forum_id'];
	if( $iForumId == 0 ) $iForumId = EGL_NO_ID;

	// declare objects	
	$cForums 			= new EGLForums( $gl_oVars->cDBInterface );
	$cAdministrator		= new Administrator( $gl_oVars->cDBInterface );
	
	// fetch data
	$aTopics			= array();
	$oForum				= $cForums->FetchForum( $iForumId );
	
	// topics available?
	if( $iForumId != EGL_NO_ID ){
		$aTopics = $cForums->FetchForumTopics( $iForumId );
	}
	
	#----------------------------------------------------------------
	# ADD-FORUM
	#----------------------------------------------------------------
	if( $_GET['a'] == 'addforum' && strlen($_POST['name']) > 0){
		$iSectionId = (int)$_GET['section_id'];
		if( $iSectionId <= 0 ) $iSectionId = EGL_NO_ID;
		
		$new_f 	= array(	'name'			=> $_POST['name'],
							'section_id'	=> $iSectionId,
							'forum_id'		=> $iForumId,
							'index'			=> $cForums->GetMaxForumIndex( $iSectionId )+1,
							'created'		=> EGL_TIME,
						);
						
		$cForums->NewForum( $new_f );
		PageNavigation::Location( $gl_oVars->sURLFile.'?page='.$gl_oVars->sModuleId.':'.$gl_oVars->sURLPage.'&forum_id='.$iForumId );
		
	}
	#----------------------------------------------------------------
	# ADD-SECTION
	#----------------------------------------------------------------
	else if( $_GET['a'] == 'addsection' && strlen($_POST['name']) > 0){
		
		$new_s 	= array(	'name'			=> $_POST['name'],
							'index'			=> $cForums->GetMaxSectionIndex()+1,
							'created'		=> EGL_TIME,
						);
						
		$cForums->NewSection( $new_s );
		PageNavigation::Location( $gl_oVars->sURLFile.'?page='.$gl_oVars->sModuleId.':'.$gl_oVars->sURLPage.'&forum_id='.$iForumId );
		
	}	
	#----------------------------------------------------------------
	# FORUM-UP
	#----------------------------------------------------------------
	else if( $_GET['a'] == 'fup' ){
		$fid = (int)$_GET['fid'];
		
		$oForumB = $cForums->FetchForum( $fid );
		if( $oForumB && $oForumB->index > 0 ){
			$oForumA = $cForums->FetchForumByIndex( $oForumB->section_id, $oForumB->index-1 );
			if( $oForumA ){
				$cForums->UpdateForum( array( 'index' => $oForumA->index+1 ),  $oForumA->id );
				$cForums->UpdateForum( array( 'index' => $oForumB->index-1 ),  $oForumB->id );
			} else{
				$cForums->UpdateForum( array( 'index' => $oForumB->index-1 ),  $oForumB->id );
			}
		}
		
	}//if
	#----------------------------------------------------------------
	# FORUM-DOWN
	#----------------------------------------------------------------
	else if( $_GET['a'] == 'fdown' ){
		$fid = (int)$_GET['fid'];
		
		$oForumB = $cForums->FetchForum( $fid );
		if( $oForumB->index < $cForums->GetMaxForumIndex( $oForumB->section_id )){
			$oForumA = $cForums->FetchForumByIndex( $oForumB->section_id, $oForumB->index+1 );
			if( $oForumA ){
				$cForums->UpdateForum( array( 'index' => $oForumA->index-1 ),  $oForumA->id );
				$cForums->UpdateForum( array( 'index' => $oForumB->index+1 ),  $oForumB->id );
			} else{
				$cForums->UpdateForum( array( 'index' => $oForumB->index+1 ),  $oForumB->id );
			}//if
		}
		
	}//if
	#----------------------------------------------------------------
	# SECTION-UP
	#----------------------------------------------------------------
	else if( $_GET['a'] == 'sup' ){
		$sid = (int)$_GET['sid'];
		
		$oSectionB = $cForums->FetchSection( $sid );
		if( $oSectionB && $oSectionB->index > 0 ){
			$oSectionA = $cForums->FetchSectionByIndex( $oSectionB->index-1 );
			if( $oSectionA ){
				$cForums->UpdateSection( array( 'index' => $oSectionA->index+1 ),  $oSectionA->id );
				$cForums->UpdateSection( array( 'index' => $oSectionB->index-1 ),  $oSectionB->id );
			} else{
				$cForums->UpdateSection( array( 'index' => $oSectionB->index-1 ),  $oSectionB->id );
			}
		}
		
	}//if
	#----------------------------------------------------------------
	# SECTION-DOWN
	#----------------------------------------------------------------
	else if( $_GET['a'] == 'sdown' ){
		$sid = (int)$_GET['sid'];
		
		$oSectionB = $cForums->FetchSection( $sid );
		if( $oSectionB->index < $cForums->GetMaxSectionIndex()){
			$oSectionA = $cForums->FetchSectionByIndex( $oSectionB->index+1 );
			if( $oSectionA ){
				$cForums->UpdateSection( array( 'index' => $oSectionA->index-1 ),  $oSectionA->id );
				$cForums->UpdateSection( array( 'index' => $oSectionB->index+1 ),  $oSectionB->id );
			} else{
				$cForums->UpdateSection( array( 'index' => $oSectionB->index+1 ),  $oSectionB->id );
			}//if
		}
		
	}//if
	
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
		if( $cAdministrator->DeleteAdminPermission($iAdminPermissionId) )
		{
			$gl_oVars->cTpl->assign( 'success', 	true );
			$gl_oVars->cTpl->assign( 'msg_type', 	'success' );
			$gl_oVars->cTpl->assign( 'msg_text', 	'Die Rechte wurden efolgreich entfernt' );
			
			PageNavigation::Location( $gl_oVars->sURLFile.'?page='.$gl_oVars->sURLRealPage.'&forum_id='.$oForum->id  );
		}
		else
		{
			$gl_oVars->cTpl->assign( 'msg_type', 	'error' );
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
			$add_obj =  array(		"admin_id"		=> $iAdminId,
									"permissions" 	=> $_POST['permissions'],
									"module_id"		=> MODULEID_INETOPIA_FORUMS,
									"data"			=> $iForumId,
									"created"		=> EGL_TIME,
								);
			// admin exists?
			$oAdminPermission = $gl_oVars->cDBInterface->FetchObject( $gl_oVars->cDBInterface->Query($gl_oVars->cDBInterface->CreateSelectQuery( $GLOBALS['g_egltb_admin_permissions'], $add_obj) ));
			//$add_obj["created"]	= EGL_TIME;
			
			// execute query
			if( !$oAdminPermission )
			{
				$sql_query = $gl_oVars->cDBInterface->CreateInsertQuery( $GLOBALS['g_egltb_admin_permissions'], $add_obj );
				$qre = $gl_oVars->cDBInterface->Query( $sql_query );
				if( $qre )
				{
					$gl_oVars->cTpl->assign( 'success', 	true );
					$gl_oVars->cTpl->assign( 'msg_type', 	'success' );
					$gl_oVars->cTpl->assign( 'msg_text', 	'Der Administrator wurde erfolgreich hinzugefügt.' );
					
					PageNavigation::Location( $gl_oVars->sURLFile.'?page='.$gl_oVars->sURLRealPage.'&forum_id='.$oForum->id  );
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

	
	$aForumAdministrator 	= array();
	$aAdministrator 		= array();
	
	$aGlobalAdministrator 	= $cForums->GetForumAdministrator( $iForumId, 'forum.global.moderator' );
	$aForumAdministrator 	= $cForums->GetForumAdministrator( $iForumId, 'forum.moderator' );
	$aAdministrator 		= $cAdministrator->GetAdminList();
	
	$gl_oVars->cTpl->assign( 'adminlist', 				$aAdministrator );
	$gl_oVars->cTpl->assign( 'forumadministrator', 		$aForumAdministrator );
	$gl_oVars->cTpl->assign( 'globaladministrator', 	$aGlobalAdministrator );
		
	
	
	# --------------------------------------------------------
	# FETCH FORUMS
	$aForums 			= $cForums->FetchForums( $iForumId );
	$aEmptySections 	= $cForums->FetchEmptySections();
	if( is_array($aEmptySections) && is_array($aForums)) $aForums = array_merge( $aForums, $aEmptySections );
	if( is_array($aEmptySections) && !is_array($aForums)  ) $aForums = $aEmptySections;
	

	
		$gl_oVars->cTpl->assign( 'forums', $aForums );
	$gl_oVars->cTpl->assign( 'topics', $aTopics );
	
	if( !$oForum ){
		$gl_oVars->cTpl->assign( 'TOPICS_DISABLED', true );
	} else{
		$gl_oVars->cTpl->assign( 'forum', $oForum );
	}
	
	$aPath = $cForums->GetPath( $iForumId );
	$gl_oVars->cTpl->assign( 'forum_path', $aPath );
?>