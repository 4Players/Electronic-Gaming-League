<?php
	global $gl_oVars;
	
	$iMemberId	= (int) $_POST['member_id'];
	

	$cAdministrator = new Administrator( $gl_oVars->cDBInterface );

	
	if( $_GET['a'] == "add_admin" )
	{
		$bOk=true;
		$aAddObj	= array(	"member_id"	=> $iMemberId,
								"created"	=> EGL_TIME );
								
		# check => member_exists?
		if( !$gl_oVars->cMember->GetMemberDataById( $iMemberId ) )
		{
			$bOk = false;
			
			$gl_oVars->cTpl->assign( "msg_type",  "error" );
			$gl_oVars->cTpl->assign( "msg_title", "Fehler" );
			$gl_oVars->cTpl->assign( "msg_text",   "Diese Mitglied-Id ist nicht bekannt." );
		}//if
		
		# check => member currently in adminlist?
		if( $cAdministrator->GetAdminByMemberId( $iMemberId ))
		{
			$bOk = false;
			
			$gl_oVars->cTpl->assign( "msg_type",  "error" );
			$gl_oVars->cTpl->assign( "msg_title", "Fehler" );
			$gl_oVars->cTpl->assign( "msg_text",  "Dieses Mitglied ist bereits in der Admin-Liste." );
			
		}//if
		
		if( $bOk )
		{
			// add admin
			$new_admin_id = EGL_NO_ID;
			if( ($new_admin_id=$cAdministrator->AddAdministrator( $aAddObj )) != EGL_NO_ID )
			{
				PageNavigation::Location( $gl_oVars->sURLFile.'?page=cms.admin.central&admin_id='.$new_admin_id );
				
				$gl_oVars->cTpl->assign( "success", true );
				
				$gl_oVars->cTpl->assign( "msg_type",  "success" );
				$gl_oVars->cTpl->assign( "msg_title", "Admin hinzugefügt" );
				$gl_oVars->cTpl->assign( "msg_text",   "Dieses Mitglied wurde erfolgreich der Admin-List hinzugefügt." );
			
			}//if
			
		}//if
	
	}//if
?>