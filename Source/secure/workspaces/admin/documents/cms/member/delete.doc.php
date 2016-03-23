<?php
	global $gl_oVars;

	$iMemberId		= (int)$_GET['member_id'];
	
	
	# classes/objects
	$cMember = new Member( $gl_oVars->cDBInterface );
	
	
	
	# fetch memberdata
	$oMemberData 	= $cMember->GetMemberDataById( $iMemberId );
	$aModules 		= $gl_oVars->cModuleManager->GetActivatedModules();
	
	if( $oMemberData ){
			
		# --------------------------------------------------
		# DELETE MEMBER
		# --------------------------------------------------
		if( $_GET['a'] == "delete" )
		{
			for( $module=0; $module < sizeof($aModules); $module++ )
			{	
				// delete module-data
				module_sendmessage( $aModules[$module]->ID, 'delete_member', $__DATA__, $iMemberId );
			}//for
			
			// delete member
			$sql_query = " DELETE FROM `".DBTB::GetTB('GLOBAL','EGL_MEMBERS')."` WHERE id=".(int)$oMemberData->id;
			$gl_oVars->cDBInterface->Query( $sql_query );
			//echo mysql_error();
			
			// delete clan-member
			$sql_query = " DELETE FROM `".DBTB::GetTB('GLOBAL','EGL_CLAN_MEMBERS')."` WHERE member_id=".(int)$oMemberData->id;
			$gl_oVars->cDBInterface->Query( $sql_query );
			//echo mysql_error();
			
			// delete team-member
			$sql_query = " DELETE FROM `".DBTB::GetTB('GLOBAL','EGL_TEAM_JOINS')."` WHERE member_id=".(int)$oMemberData->id;
			$gl_oVars->cDBInterface->Query( $sql_query );
			//echo mysql_error();
			
			// delete admin
			$sql_query = " DELETE admins,admin_perm FROM `".DBTB::GetTB('GLOBAL','EGL_ADMINS')."` AS admins, `".DBTB::GetTB('GLOBAL','EGL_ADMIN_PERMISSIONS')."` AS admin_perm WHERE member_id=".(int)$oMemberData->id." && admin_perm.admin_id=admins.id " ;
			$gl_oVars->cDBInterface->Query( $sql_query );
			//echo mysql_error();
			
			// delete written news
			// delete written comments
			
			$gl_oVars->cTpl->assign( 'msg_type', 'success' ); 
			$gl_oVars->cTpl->assign( 'msg_text', 'Das Mitglied wurde unwiderruflich gelöscht' ); 
			$gl_oVars->cTpl->assign( 'success', true );
			
			
			PageNavigation::Location( $gl_oVars->sURLFile.'?page=cms.memberlist' );
			
		}//if
		
		# --------------------------------
		# analysis delete requirements
		# --------------------------------
		
		// (1) module request
		$aRequestStatements = array();
		for( $module=0; $module < sizeof($aModules); $module++ )
		{
			$response_obj = module_sendmessage( $aModules[$module]->ID, 'delete_member_request', $__DATA__, $iMemberId );
			if( !is_array($response_obj) ) $response_obj = array();
			
			$cnt = sizeof($aRequestStatements);
			$aRequestStatements[$cnt] = array();
			$aRequestStatements[$cnt]['module_id'] 		= $aModules[$module]->ID;
			$aRequestStatements[$cnt]['module_name']	= $aModules[$module]->sName;
			$aRequestStatements[$cnt]['responses'] 		= $response_obj;
			
		}//for
		
		$gl_oVars->cTpl->assign( "member_data", $oMemberData );
		$gl_oVars->cTpl->assign( "response_messages", $aRequestStatements );
	}//if member exists?
?>