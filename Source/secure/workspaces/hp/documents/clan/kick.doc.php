<?php
	global $gl_oVars;

	$iClanId	= (int)$_GET['clan_id'];
		
	$cClan = & new Clan( $gl_oVars->cDBInterface );
	$aClanMembers = $cClan->GetClanMembers( $iClanId  );
	

	
	#------------------------------
	# delete!!!!
	#------------------------------
	if( $_GET['a'] == 'go' )
	{
		$pMyself = NULL;
		$pKickMember = NULL;
		for($i=0; $i < sizeof($aClanMembers); $i++ )
		{
			# myself ?
			if( $aClanMembers[$i]->member_id == $gl_oVars->oMemberData->id )
				$pMyself = $aClanMembers[$i];
				
			# kick-member ?
			if( $aClanMembers[$i]->member_id == $_POST['kick_member_id'] )
				$pKickMember = $aClanMembers[$i];
		}
			
		
		
		# correct data ?
		if( !$pKickMember || !$pMyself )
		{
			// Es ist ein Fehler aufgetreten. Falls der Fehler erneut auftritt, kontaktieren Sie bitte den Webadministrator
			$gl_oVars->cTpl->assign( 'msg_type', 	'error' );
			$gl_oVars->cTpl->assign( 'msg_text', 	$gl_oVars->aLngBuffer['basic']['c5022'] );
		}
		else
		{
			# kick myself ?
			if( $pKickMember->member_id == $gl_oVars->oMemberData->id )
			{
				// Du kannst dich nicht selbst kicken
				$gl_oVars->cTpl->assign( 'msg_type', 	'error' );
				$gl_oVars->cTpl->assign( 'msg_text', 	$gl_oVars->aLngBuffer['basic']['c5023'] );
			}
			else
			{
			

				#########################################
				# ALL RIGHT ? !!
				#########################################
				if( Isset( $_POST['kick_check'] ) )	# last check
				if( $cClan->SignoutMember( $pKickMember->member_id, $iClanId ) )
				{
					$gl_oVars->cTpl->assign( 'msg_type', 	'success' );
					$gl_oVars->cTpl->assign( 'msg_text', 	Templates::ParseContent( $gl_oVars->aLngBuffer['basic']['c5024'],
															$gl_oVars->cTpl,
															array( 'kicked_nickname' => $pKickMember->nick_name ))
															);
													
					$gl_oVars->cTpl->assign( 'success', true );
				}// id deleted successful ?
			}//if
		}//$pKickMember/$pMyself found ?
	}//$_GET['a'] == go
	
	
	
	
	
	$gl_oVars->cTpl->assign( 'clan_members', $aClanMembers );
	
	
?>