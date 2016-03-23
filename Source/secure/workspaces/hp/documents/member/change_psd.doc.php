<?php
	global $gl_oVars;


	#-----------------------
	# Go - Change ?
	#-----------------------
	if( $_GET['a'] == 'go' &&
		strlen($_POST['old_psd']) > 0 &&
		strlen($_POST['new_psd']) > 0 &&
		strlen($_POST['re_new_psd']) > 0  )
	{
		
		$oMemberData = $gl_oVars->cMember->GetData();

		
		if( md5($_POST['old_psd']) == $oMemberData->password  &&
			$_POST['new_psd'] == $_POST['re_new_psd'] )
		{
			$mem_obj = NULL;
			$mem_obj->password = md5( $_POST['new_psd'] );
		
			# update	
			if( $gl_oVars->cMember->SetMemberData( $mem_obj ) )
			{
				$gl_oVars->cTpl->assign( 'change_success', 	1 );
				$gl_oVars->cTpl->assign( 'msg_type', 	'success' );
				$gl_oVars->cTpl->assign( 'msg_text', 	$gl_oVars->aLngBuffer['basic']['c4516'] );
		
			}// if $member_cnt == 0
		}
		else 
		{
			$gl_oVars->cTpl->assign( 'msg_type', 	'error' );
			$gl_oVars->cTpl->assign( 'msg_text', 	$gl_oVars->aLngBuffer['basic']['c4515'] );
			
		}
		
			
	}
	else
	{
		
		$gl_oVars->cTpl->assign( 'msg_type', 	'warning' );
		$gl_oVars->cTpl->assign( 'msg_text', 	$gl_oVars->aLngBuffer['basic']['c4514'] );
	}


?>