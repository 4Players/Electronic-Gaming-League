<?php
	global $gl_oVars;

	$iMemberId		= (int)$_GET['member_id'];
	$iHistoryId		= (int)$_GET['history_id'];
	
	
	# declare classes
	$cMemberHistory	= new MemberHistory( $gl_oVars->cDBInterface );
	
	

	# fetch memberdata
	$oMemberData = $gl_oVars->cMember->GetMemberDataById( $iMemberId );
	
	
	# history-id
	if( $_GET['a'] == "delete" )
	{
		if( $cMemberHistory->DeleteHistoryEntry( $iHistoryId ) )
		{
			$gl_oVars->cTpl->assign( "success", true );
			
			$gl_oVars->cTpl->assign( "msg_type", 	"success" );
			$gl_oVars->cTpl->assign( "msg_title", 	"Gelöscht" );
			$gl_oVars->cTpl->assign( "msg_text", 	"Der History Eingtrag wurde erfolgreich gelöscht" );
			
		}//if
		else
		{
			$gl_oVars->cTpl->assign( "msg_type", 	"error" );
			$gl_oVars->cTpl->assign( "msg_title", 	"Fehler" );
			$gl_oVars->cTpl->assign( "msg_text", 	"Der Eingtrag konnte nicht gelöscht werden" );
		}
	}//if
	
		
	
	$gl_oVars->cTpl->assign( "member_data", $oMemberData );
	$gl_oVars->cTpl->assign( "historylist", $cMemberHistory->GetHistoryList( $iMemberId, 0, 15 ) );
	
?>