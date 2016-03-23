<?php
	global $gl_oVars;
	
	
	$iTeamId	= (int)$_GET['team_id'];
	$iMemberId	= (int)$_GET['member_id'];
	
	

	# declare classes & objects
	$cTeam	= new  Team( $gl_oVars->cDBInterface );

	
	# fetch data
	$oTeam	= $gl_oVars->cMember->GetTeamAccount( $iTeamId );
	$oMember= $cTeam->GetTeamMemberByID( $iTeamId, $iMemberId );
	$bIsTeamMember = $cTeam->TeamSelfTest( $iMemberId, $iTeamId );
	
	
	# clan - permission - tree
	$tpt = new PermissionTree();
	$tpt->SetPermissionFile( EGLFILE_PERMISSIONTREE );
	$tpt->CreateTree( 'team');	# create clan-tree


	$oFirstPermission = $tpt->GetFirst();

	
	#------------------------------------------------------------------
	# Clan joined by member
	#------------------------------------------------------------------
	if( $bIsTeamMember )
	{
		# leader = myself ?
		if( $oTeam && 
			$oMember->member_id != $gl_oVars->iMemberId ) // bin ich es selbst?
		{
				/*
				Warnung - Masterrechte werden vergeben
				(Warning - master-permission will be terminated)
			*/
			
			// dieser spieler bereits leader?
			if( $oMember->permissions == $oFirstPermission->const ){		
				$gl_oVars->cTpl->assign( 'msg_type', 	'error' );
				$gl_oVars->cTpl->assign( 'msg_text', 	$gl_oVars->aLngBuffer['basic']['c2009'] );
				$gl_oVars->cTpl->assign( 'quit', 	true );
				
			}
			else{
				$gl_oVars->cTpl->assign ( 'msg_type',	'warning' );
				$gl_oVars->cTpl->assign ( 'msg_text',	$gl_oVars->aLngBuffer['basic']['c2005'] );
			 
				
				#--------------------------------------------------------
				# Go
				#--------------------------------------------------------
				if( $_GET['a']	== 'go' )
				{
					# SUCCESS (Input)
					if( $_POST['setleader_check'] == 'yes' && $_POST['setleader_key'] == $_GET['key']  )
					{
					
		
						/*
							!= Only allow no master permissions
							ÄNDERUNG:
							Es gibt mehr clan-leader ab sofort!!
							
						*/
						//if( /*$_POST['setleader_new_permission'] != $oFirstPermission->const*/ true  )
						//{
						
							# change my permissions
							$my_perm = array( 'permissions'	=> $_POST['setleader_new_permission'] );
							$cTeam->SetTeamMemberData( $my_perm, (int)$oTeam->id, (int)$gl_oVars->iMemberId );
							
							/*
							NEUE FUNKTION:
							Nur vergenem der Rechte für die andere Person!
							=> Eigene Rechte werden beibehalten
							*/
							
							# change other permissions
							$other_perm = array( 'permissions' => $oFirstPermission->const );
							$cTeam->SetTeamMemberData( $other_perm, (int)$oTeam->id, (int)$iMemberId );
							
							
							
							$gl_oVars->cTpl->assign( 'success', 	true );
						
							$gl_oVars->cTpl->assign( 'msg_type', 	'success' );
							$gl_oVars->cTpl->assign( 'msg_text',	$gl_oVars->aLngBuffer['basic']['c2004'] );	// success
							
						/*}//if
						else
						{
							//$gl_oVars->cTpl->assign( 'quit', 	true );
							
							$gl_oVars->cTpl->assign( 'msg_type', 	'error' );
							$gl_oVars->cTpl->assign( 'msg_text', 	$gl_oVars->aLngBuffer['basic']['c2003'] ); // new permission: no primary permission allowed
						}*/
						
					}
					else 
					{
						/*
							Wrong Inputdata (Key/Check)		(Falsche Eingabedaten)
							
						*/
						//$gl_oVars->cTpl->assign( 'quit', 	true );
						
						$gl_oVars->cTpl->assign( 'msg_type', 	'error' );
						$gl_oVars->cTpl->assign( 'msg_text', 	$gl_oVars->aLngBuffer['basic']['c2002'] ); // wrong security input data
						
					}//if
				}//if
				
			}// noch keine leader-reachte?
			
		}//if
		else 
		{
		/*
			
			Falsches Mitglied! (Wrong Member) 
			Hier ist das Mitglied: Leader(Master)!
			*/
			
			$gl_oVars->cTpl->assign( 'quit', 	true );
			$gl_oVars->cTpl->assign( 'msg_type', 	'error' );
			$gl_oVars->cTpl->assign( 'msg_text', 	$gl_oVars->aLngBuffer['basic']['c2001'] );
		}
		
		
	
		
		# provide template with tpl-vars
		
		$gl_oVars->cTpl->assign( 'member_details',  $oMember ); 
		$gl_oVars->cTpl->assign( 'tpt',  $tpt->GetConstNameArray() ); 
		$gl_oVars->cTpl->assign( 'team',  $oTeam); 
		$gl_oVars->cTpl->assign( 'member_id', $iMemberId ); 
		$gl_oVars->cTpl->assign( 'key', CreateRandomPassword()); 
		$gl_oVars->cTpl->assign( 'team_first_permission', $tpt->GetFirst() );	
		
		
	}// is clanJoined ?
	else 
	{
		// current selected member, by url:member_id=?, has joined the team
		
		$gl_oVars->cTpl->assign( 'quit', 	true );
					
		$gl_oVars->cTpl->assign( 'msg_type', 	'error' );
		$gl_oVars->cTpl->assign( 'msg_text', 	$gl_oVars->aLngBuffer['basic']['c2000'] );
	}
	
?>