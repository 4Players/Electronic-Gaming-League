<?php
	global $gl_oVars;
	
	$cTeam 		= new Team( $gl_oVars->cDBInterface );
	$aTeams 	= $cTeam->GetJoinedTeamlist( (int)$gl_oVars->iMemberId );
	
	$iTeamId	= (int)$_POST['team_id'];
	
	# team - permission - tree
	$tpt = new PermissionTree();
	$tpt->SetPermissionFile( EGLFILE_PERMISSIONTREE );
	$tpt->CreateTree( 'team');	

	$oFirstPermissions = $tpt->GetFirst();
	
	
	if( sizeof($aTeams) == 0 )
	{
		// disable leave-team form
		$gl_oVars->cTpl->assign( 'success', true );
		
		$gl_oVars->cTpl->assign( 'msg_type', 'warning' );
		$gl_oVars->cTpl->assign( 'msg_text', $gl_oVars->aLngBuffer['basic']['c5524'] );
	}
	else
	{
		// ..
		if( $_GET['a']	== 'go' ){
			// fetch team permissions
			$oJoinedTeam = $cTeam->GetTeamPermissions( (int)$gl_oVars->iMemberId, (int)$iTeamId );

			
			// no squad-leader??
			if( $oJoinedTeam->permissions != $oFirstPermissions->const )
			{
				// is in team
				if( $cTeam->GetNumTeamJoins( (int)$gl_oVars->iMemberId, (int)$iTeamId ) > 0 )
				{
					// leave team
					if( $cTeam->RemoveTeamMemberByMemberId( $iTeamId, $gl_oVars->iMemberId ) )
					{
						$gl_oVars->cTpl->assign( 'success', true );
						
						$gl_oVars->cTpl->assign( 'msg_type', 'success' );
						$gl_oVars->cTpl->assign( 'msg_text', $gl_oVars->aLngBuffer['basic']['c5523'] );
					}
				}
				else
				{
					$gl_oVars->cTpl->assign( 'msg_type', 'error' );
					$gl_oVars->cTpl->assign( 'msg_text', $gl_oVars->aLngBuffer['basic']['c5521'] );
				}
			}
			else
			{
				// mehr als 1 clanleader?
				if( sizeof($cTeam->GetTeamMemberByPermissions( $iTeamId, $oFirstPermissions->const )) > 1  )
				{				
					// is in team
					if( $cTeam->GetNumTeamJoins( (int)$gl_oVars->iMemberId, (int)$iTeamId ) > 0 )
					{
						// leave team
						if( $cTeam->RemoveTeamMemberByMemberId( $iTeamId, $gl_oVars->iMemberId ) )
						{
							$gl_oVars->cTpl->assign( 'success', true );
							
							$gl_oVars->cTpl->assign( 'msg_type', 'success' );
							$gl_oVars->cTpl->assign( 'msg_text', $gl_oVars->aLngBuffer['basic']['c5523'] );
						}
					}
					else
					{
						$gl_oVars->cTpl->assign( 'msg_type', 'error' );
						$gl_oVars->cTpl->assign( 'msg_text', $gl_oVars->aLngBuffer['basic']['c5521'] );
					}				
				}
				else
				{
					$gl_oVars->cTpl->assign( 'msg_type', 'error' );
					$gl_oVars->cTpl->assign( 'msg_text', 	Templates::ParseContent( $gl_oVars->aLngBuffer['basic']['c5525'],
															$gl_oVars->cTpl,
															array( 'permissions' => $oFirstPermissions->name ))
															);
				}// more than 1 leader?
			}//if 
		}
		else
		{
			$gl_oVars->cTpl->assign( 'msg_type', 'warning' );
			$gl_oVars->cTpl->assign( 'msg_text', $gl_oVars->aLngBuffer['basic']['c5522'] );
		}
	
		$gl_oVars->cTpl->assign( 'teams', $aTeams );	
	}//if teams-joins available
?>