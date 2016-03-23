<?php
	global $gl_oVars;
	
	$cTeam = & new Team( $gl_oVars->cDBInterface );
	$aTeamMembers = $cTeam->GetTeamMembers( (int)$_GET['team_id'] );
	

	#------------------------------
	# delete!!!!
	#------------------------------
	if( $_GET['a'] == 'go' )
	{
		$pMyself = NULL;
		$pKickMember = NULL;
		for($i=0; $i < sizeof($aTeamMembers); $i++ )
		{
			# myself ?
			if( $aTeamMembers[$i]->member_id == $gl_oVars->oMemberData->id )
				$pMyself = $aTeamMembers[$i];
				
			# kick-member ?
			if( $aTeamMembers[$i]->member_id == $_POST['kick_member_id'] )
				$pKickMember = $aTeamMembers[$i];
		}
			
		
		
		# correct data ?
		if( !$pKickMember || !$pMyself )
		{
			// Es ist ein Fehler aufgetreten. Falls der Fehler erneut auftritt, kontaktieren Sie bitte den Webadministrator
			$gl_oVars->cTpl->assign( 'msg_type', 	'error' );
			$gl_oVars->cTpl->assign( 'msg_text', 	$gl_oVars->aLngBuffer['basic']['c5271'] );
		}
		else
		{
			# kick myself ?
			if( $pKickMember->member_id == $gl_oVars->oMemberData->id )
			{
				// Du kannst dich nicht selbst kicken !
				$gl_oVars->cTpl->assign( 'msg_type', 	'error' );
				$gl_oVars->cTpl->assign( 'msg_text', 	$gl_oVars->aLngBuffer['basic']['c527"'] );
			}
			else
			{
			
				#########################################
				# ALL RIGHT ? !!
				#########################################
				if( $_POST['kick_check'] == 'yes' )	# last check
				{
					
					if( $cTeam->SignoutMember( $pKickMember->member_id, $pKickMember->team_id ) )
					{
						$gl_oVars->cTpl->assign( 'msg_type', 	'success' );
						$gl_oVars->cTpl->assign( 'msg_text', 	Templates::ParseContent( $gl_oVars->aLngBuffer['basic']['c5273'],
																$gl_oVars->cTpl,
																array( 'kicked_nickname' => $pKickMember->nick_name ))
																);
																							
						$gl_oVars->cTpl->assign( 'success', true );
					}// id deleted successful ?
				}
				else 
				{
					$gl_oVars->cTpl->assign( 'msg_type', 	'warning' );
					$gl_oVars->cTpl->assign( 'msg_text', 	$gl_oVars->aLngBuffer['basic']['c5274'] );
					
				}
			}
		}//$pKickMember/$pMyself found ?
	}//$_GET['a'] == go
	
	$gl_oVars->cTpl->assign( 'team_members', $aTeamMembers );
?>