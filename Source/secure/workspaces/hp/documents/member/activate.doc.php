<?php
	global $gl_oVars;
	
	
	# fetch url parameters
	$iMemberId			= (int)$_GET['member_id'];
	$sActivationCode	= (int)$_GET['code'];
	
	
	# objects/classes
	$cMember = new Member( $gl_oVars->cDBInterface );
	
	
	# fetch data
	$oMember = $cMember->GetMemberDataById( $iMemberId );
	if( $oMember )
	{
		if( $sActivationCode == $oMember->activation_code && strlen($oMember->activation_code) > 0 )
		{
			if( $_GET['a'] == 'activate' ){
			// ..
				$bError = false;
				$member_activated = array( 	'activation_time'	=> EGL_TIME,
											'activation_code'	=> md5( EGL_TIME.CreateRandomPassword() ),
										  );
				if( strlen($_POST['newpassword']) > 1 &&
					$_POST['newpassword'] == $_POST['re_newpassword'] )
				{
					$member_activated['password'] = md5( $_POST['newpassword'] );
				}
				else
				{
					$gl_oVars->cTpl->assign( 'msg_type', 'error' );
					$gl_oVars->cTpl->assign( 'msg_text', $gl_oVars->aLngBuffer['basic']['c1081'] );
				}
				
				
				// no errors occured ?
				if( !$bError )
				{
					// execute query
					$qre = $gl_oVars->cDBInterface->Query( $gl_oVars->cDBInterface->CreateUpdateQuery( $GLOBALS['g_egltb_members'], $member_activated ).' WHERE id='.$iMemberId );
					if( $qre )
					{
						//PageNavigation::Location( $gl_oVars->sURLFile.'?page=login' );
						$gl_oVars->cTpl->assign( 'msg_type', 'success' );
						$gl_oVars->cTpl->assign( 'msg_text', $gl_oVars->aLngBuffer['basic']['c1080'] );
						
						$gl_oVars->cTpl->assign( 'SUCCESS', true );
					}//if
					
				}//if
				
			}//if get'a' => activate
			
		}//if
	}
	else
	{
		$gl_oVars->cTpl->assign( 'msg_type', 	'error' );
		$gl_oVars->cTpl->assign( 'msg_type', 	$gl_oVars->aLngBuffer['basic']['c4333'] );
	}
?>