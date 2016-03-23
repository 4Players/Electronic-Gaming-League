<?php
	global $gl_oVars;


	#-----------------------
	# Go - Change ?
	#-----------------------
	if( $_GET['a'] == 'go' &&
		strlen($_POST['changed_name']) > 0 )
	{
		$search_obj = NULL;
		$search_obj->login_name = $_POST['changed_name'];
		
		# get member_cnt with current name
		$member_cnt = $gl_oVars->cMember->GetMemberCount( $search_obj );
		
		# -------------------------------------------
		# member with that same currently exists ??
		# -------------------------------------------
		if( $member_cnt )
		{
			$gl_oVars->cTpl->assign( 'msg_type', 	'error' );
			$gl_oVars->cTpl->assign( 'msg_title', 	$g_TplCfgVars['change_loginname_error_title'] );
			$gl_oVars->cTpl->assign( 'msg_text', 	$g_TplCfgVars['change_loginname_error_text'] );
			
		}
		else
		{
			$mem_obj = NULL;
			$mem_obj->login_name = $_POST['changed_name'];
			
			if( $gl_oVars->cMember->SetMemberData( $mem_obj ) )
			{
				$gl_oVars->cTpl->assign( 'msg_type', 	'success' );
				$gl_oVars->cTpl->assign( 'msg_title', 	$g_TplCfgVars['change_loginname_success_title'] );
				$gl_oVars->cTpl->assign( 'msg_text', 	$g_TplCfgVars['change_loginname_success_text'] );
				$gl_oVars->cTpl->assign( 'change_success', 	1 );
				
			}// if setmemberdata
			
			
		}// if $member_cnt == 0
		
	}
	else
	{
		$gl_oVars->cTpl->assign( 'msg_type', 	'warning' );
		$gl_oVars->cTpl->assign( 'msg_title', 	$g_TplCfgVars['change_loginname_warning_title'] );
		$gl_oVars->cTpl->assign( 'msg_text', 	$g_TplCfgVars['change_loginname_warning_text'] );
	}


?>