<?php
	global $gl_oVars;
	
	
	$iClanId	= (int)$_GET['clan_id'];
	$iMemberId	= (int)$_GET['member_id'];
	
	

	# declare classes & objects
	$cClan	= new  Clan( $gl_oVars->cDBInterface );

	
	# fetch data
	$oClan	= $gl_oVars->cMember->GetClanAccount( $iClanId );
	$oMember= $cClan->GetClanMemberByID( $iClanId, $iMemberId );
	$bIsClanMember = $cClan->ClanJoinedByMemberId( $oClan->id, $iMemberId );
	
	
	# clan - permission - tree
	$cpt = new PermissionTree();
	$cpt->SetPermissionFile( EGLFILE_PERMISSIONTREE );
	$cpt->CreateTree( 'clan');	# create clan-tree
	
	$oFirstPermission = $cpt->GetFirst();

	#------------------------------------------------------------------
	# Clan joined by member
	#------------------------------------------------------------------
	if( $bIsClanMember )
	{
		# leader = myself ?
		if( $oClan && // clan gefunden
			//$oClan->member_id == $gl_oVars->oMemberData->id  && 	// bin ich leader?
			$iMemberId != $gl_oVars->iMemberId ) // bin ich es selbst?
		{
			/*
				Warnung - Masterrechte werden vergeben
				(Warning - master-permission will be terminated)
			*/
			
			// dieser spieler bereits leader?
			if( $oMember->permissions == $oFirstPermission->const ){		
				$gl_oVars->cTpl->assign( 'msg_type', 	'error' );
				$gl_oVars->cTpl->assign( 'msg_text', 	$gl_oVars->aLngBuffer['basic']['c5013'] );
				$gl_oVars->cTpl->assign( 'quit', 	true );
				
			}
			else{
				$gl_oVars->cTpl->assign ( 'msg_type',	'warning' );
				$gl_oVars->cTpl->assign ( 'msg_text',	$gl_oVars->aLngBuffer['basic']['c5009'] );
				
				#--------------------------------------------------------
				# Go
				#--------------------------------------------------------
				if( $_GET['a']	== 'go' )
				{
					# SUCCESS (Input)
					if( $_POST['setleader_check'] == 'yes' && $_POST['setleader_key'] == $_GET['key']  )
					{
						
						// bislang noch kein leader?
						if( $oMember->permissions != $oFirstPermission->const ){
						/*
							Only allow no master permissions
						*/
						//if( /*$_POST['setleader_new_permission'] != $oFirstPermission->const*/ true  )
						//{
						
							# change my permissions
							$my_perm->permissions	= $_POST['setleader_new_permission'];
							$cClan->SetClanMemberData( $my_perm, (int)$oClan->id, (int)$gl_oVars->oMemberData->id );
							
							# change other permissions
							$other_perm->permissions = $oFirstPermission->const;
							$cClan->SetClanMemberData( $other_perm, (int)$oClan->id, (int)$iMemberId );
							
							
							
							$gl_oVars->cTpl->assign( 'success', 	true );
						
							$gl_oVars->cTpl->assign( 'msg_type', 	'success' );
							$gl_oVars->cTpl->assign( 'msg_text',	$gl_oVars->aLngBuffer['basic']['c5012'] );
							
						//}//if
						}
						else{
							$gl_oVars->cTpl->assign( 'msg_type', 	'error' );
							$gl_oVars->cTpl->assign( 'msg_text',	$gl_oVars->aLngBuffer['basic']['c5013'] );
							
						}
						
					}
					else 
					{
						/*
							Wrong Inputdata (Key/Check)		(Falsche Eingabedaten)
							
						*/
						$gl_oVars->cTpl->assign( 'quit', 	true );
						
						$gl_oVars->cTpl->assign( 'msg_type', 	'error' );
						$gl_oVars->cTpl->assign( 'msg_text', 	$gl_oVars->aLngBuffer['basic']['c5010'] );
						
					}//if
				}//if
				
				
			}//if member not leader
		}//if
		else 
		{
			/*
			
			Falsches Mitglied! (Wrong Member) 
			Hier ist das Mitglied: Leader(Master)!
			*/
			
			$gl_oVars->cTpl->assign( 'quit', 	true );
			
			$gl_oVars->cTpl->assign( 'msg_type', 	'error' );
			$gl_oVars->cTpl->assign( 'msg_text', 	$gl_oVars->aLngBuffer['basic']['c5011'] );
		}
		
		
	
		
		# provide template with tpl-vars
		$gl_oVars->cTpl->assign( 'member_details',  $oMember ); 
		$gl_oVars->cTpl->assign( 'cpt',  $cpt->GetConstNameArray() ); 
		$gl_oVars->cTpl->assign( 'clan',  $oClan); 
		$gl_oVars->cTpl->assign( 'member_id', $iMemberId ); 
		$gl_oVars->cTpl->assign( 'key', CreateRandomPassword()); 
		$gl_oVars->cTpl->assign( 'clan_first_permission', $cpt->GetFirst() );	
		
		
	}// is clanJoined ?
	else 
	{
		$gl_oVars->cTpl->assign( 'quit', 	true );

		$gl_oVars->cTpl->assign( 'msg_type', 	'error' );
		$gl_oVars->cTpl->assign( 'msg_text', 	$gl_oVars->aLngBuffer['basic']['c5011'] );
	}
	
?>