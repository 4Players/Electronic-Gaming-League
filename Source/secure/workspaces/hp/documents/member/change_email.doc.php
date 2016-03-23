<?php
	global $gl_oVars;

	# get memberdata
	$oMemberData = $gl_oVars->cMember->GetData();


	#-----------------------
	# Go - Change ?
	#-----------------------
	if( $_GET['a'] == 'go' &&
		strlen($_POST['changed_email']) > 0 &&
		Check_eMail( $_POST['changed_email'] ) )
	{
		$search_obj = NULL;
		$search_obj->email = $_POST['changed_email'];
		
		# get member_cnt with current name
		$member_cnt = $gl_oVars->cMember->GetMemberCount( $search_obj );
		
		# -------------------------------------------
		# member with that same currently exists ??
		# -------------------------------------------
		if( $member_cnt )
		{
			$gl_oVars->cTpl->assign( 'msg_type', 	'error' );
			//$gl_oVars->cTpl->assign( 'msg_title', 	$gl_['change_email_error_title'] );
			$gl_oVars->cTpl->assign( 'msg_text', 	$gl_oVars->aLngBuffer['basic']['c4505'] );
		}
		else
		{
			$mem_obj = NULL;
			$mem_obj->email = $_POST['changed_email'];
			
			if( $gl_oVars->cMember->SetMemberData( $mem_obj ) )
			{
				$gl_oVars->cTpl->assign( 'msg_type', 	'success' );
				//$gl_oVars->cTpl->assign( 'msg_title', 	$g_TplCfgVars['change_email_success_title'] );
				$gl_oVars->cTpl->assign( 'msg_text', 	$gl_oVars->aLngBuffer['basic']['c4504'] );
				$gl_oVars->cTpl->assign( 'change_success', 	1 );

					# ACHTUNG: change psd `??? ;P
				
			}// if setmemberdata
			
			
		}// if $member_cnt == 0
		
	}
	else
	{
		$gl_oVars->cTpl->assign( 'current_email',	$oMemberData->email );
		$gl_oVars->cTpl->assign( 'msg_type', 		'warning' );
		//$gl_oVars->cTpl->assign( 'msg_title', 		$g_TplCfgVars['change_email_warning_title'] );
		$gl_oVars->cTpl->assign( 'msg_text', 		$gl_oVars->aLngBuffer['basic']['c4503'] );
	}


?>