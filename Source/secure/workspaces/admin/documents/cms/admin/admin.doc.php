<?php
	global $gl_oVars;
	
	$iAdminId	= (int) $_GET['admin_id'];
	$iMemberId	= (int) $_GET['member_id'];

	# administrator
	$cAdministrator = new Administrator( $gl_oVars->cDBInterface );

	
	if( $_GET['a'] == "delete_admin" )
	{
		if( $cAdministrator->DeleteAdministrator( $iAdminId ) )
		{
			PageNavigation::Location( $gl_oVars->sURLFile.'?page=cms.adminlist');
			
			$gl_oVars->cTpl->assign( "success", 	true );
			$gl_oVars->cTpl->assign( "msg_type",  	"success" );
			$gl_oVars->cTpl->assign( "msg_title", 	"Admin gelöscht" );
			$gl_oVars->cTpl->assign( "msg_text",  	"Der Administrator wurde erfolgreich aus der Admin-List entfernt." );
			
		}//if
		else
		{
			$gl_oVars->cTpl->assign( "msg_type",  "error" );
			$gl_oVars->cTpl->assign( "msg_title", "Fehler" );
			$gl_oVars->cTpl->assign( "msg_text",  "Der Administrator konnte nicht entfernt werden." );
		}//if
	
	}//if
?>