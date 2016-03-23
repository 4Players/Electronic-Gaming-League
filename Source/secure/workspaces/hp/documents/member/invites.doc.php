<?php
	global $gl_oVars;
	


	# define declare objects /classes
	$cClan = new Clan( $gl_oVars->cDBInterface );
	

	
	# fetch data
	$aClanInvites = $cClan->GetMemberInvites( $gl_oVars->oMemberData->id );
	
	
	$iInviteId	= (int)$_GET['invite_id'];
	if( $_GET['a']	== 'accept' )
	{
		for( $i=0; $i < sizeof($aClanInvites);$i++)
			if( $aClanInvites[$i]->invite_id == $iInviteId )
				break;
		if( $i < sizeof($aClanInvites) )
		{
			# currently joined ?
			$bJoined = $cClan->ClanJoinedByMemberId( $aClanInvites[$i]->id, $gl_oVars->oMemberData->id );		

			# set data as processed & accepted
			$obj = NULL;
			$obj->accepted=1;
			$obj->processed=1;
			
			# set data
			$cClan->SetInvitationData( $iInviteId, $obj );

			
			# currently joined
			if( !$bJoined )
			{
				
				# team - permission - tree
				$cpt = new PermissionTree();
				$cpt->SetPermissionFile( EGLFILE_PERMISSIONTREE );
				$cpt->CreateTree('clan');
			
				# read last 
				$join_permission = $cpt->GetLast();
				
				
				# def. create object 
				$join_obj = NULL;
				$join_obj->member_id 	= $gl_oVars->oMemberData->id;
				$join_obj->clan_id	 	= $aClanInvites[$i]->id;	/* clan_id */
				$join_obj->permissions	= $join_permission->const;
				$join_obj->created		= time(); 
				
				if( $cClan->SignJoin( $join_obj ) )
				{
					# SUCCESS
					$gl_oVars->cTpl->assign( 'msg_type',	'success' );
					//$gl_oVars->cTpl->assign( 'msg_title',	'Clan beigetreten' );
					$gl_oVars->cTpl->assign( 'msg_text',	$gl_oVars->aLngBuffer['basic']['c4626'] );
					
					$gl_oVars->cTpl->assign( 'success',		true );
				} // join
				
			}//if
			else
			{
				# SUCCESS
				$gl_oVars->cTpl->assign( 'msg_type',	'info' );
				//$gl_oVars->cTpl->assign( 'msg_title',	'Info' );
				$gl_oVars->cTpl->assign( 'msg_text',	$gl_oVars->aLngBuffer['basic']['c4627'] );			
			}//if
			
			
		}//if
		
	}//if
	else if( $_GET['a']	== 'deny' )
	{
		for( $i=0; $i < sizeof($aClanInvites);$i++)
			if( $aClanInvites[$i]->invite_id == $iInviteId )
				break;
		if( $i < sizeof($aClanInvites) )
		{
			$obj = NULL;
			$obj->accepted=0;
			$obj->processed=1;
			
			# set data
			$cClan->SetInvitationData( $iInviteId, $obj );
		}//if
	}//if
	
	
	#----------------------------------------------------------------------------------------
	
	$gl_oVars->cTpl->assign( 'clan_invites', $aClanInvites );
?>