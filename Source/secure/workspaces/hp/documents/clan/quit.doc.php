<?php
	global $gl_oVars;
	
	$cClan 		= new Clan( $gl_oVars->cDBInterface );
	$aClans 	= $cClan->GetJoinedClans( (int)$gl_oVars->iMemberId );
	$iClanId	= (int)$_POST['clan_id'];
	
	# clan - permission - tree
	$cpt = new PermissionTree();
	$cpt->SetPermissionFile( EGLFILE_PERMISSIONTREE );
	$cpt->CreateTree( 'clan');		
	
	$oFirstPermissions = $cpt->GetFirst();

	if( sizeof($aClans) == 0 )
	{
		// disable leave-clan form
		$gl_oVars->cTpl->assign( 'success', true );
		
		$gl_oVars->cTpl->assign( 'msg_type', 'warning' );
		$gl_oVars->cTpl->assign( 'msg_text', $gl_oVars->aLngBuffer['basic']['c5554'] );
	}
	else
	{
		// ..
		if( $_GET['a']	== 'go' ){
			
			// fetch clan permissions
			$oJoinedClan = $cClan->GetClanPermissions( (int)$gl_oVars->iMemberId, (int)$iClanId );

			// no squad-leader??
			if( $oJoinedClan->permissions != $oFirstPermissions->const )
			{
				// is in clan
				if( $cClan->ClanJoinedByMemberId( (int)$iClanId, (int)$gl_oVars->iMemberId ) > 0 )
				{
					// leave clan
					if( $cClan->RemoveclanMemberByMemberId( $iClanId, $gl_oVars->iMemberId ) )
					{
						$gl_oVars->cTpl->assign( 'success', true );
						
						$gl_oVars->cTpl->assign( 'msg_type', 'success' );
						$gl_oVars->cTpl->assign( 'msg_text', $gl_oVars->aLngBuffer['basic']['c5553'] );
					}
				}
				else
				{
					$gl_oVars->cTpl->assign( 'msg_type', 'error' );
					$gl_oVars->cTpl->assign( 'msg_text', $gl_oVars->aLngBuffer['basic']['c5551'] );
				}
			}
			else
			{
				// mehr als 1 clanleader?
				if( sizeof($cClan->GetClanMemberByPermissions( $iClanId, $oFirstPermissions->const )) > 1  )
				{
					// member in clan?
					if( $cClan->ClanJoinedByMemberId( (int)$iClanId, (int)$gl_oVars->iMemberId ) > 0 )
					{
						// leave clan now!
						if( $cClan->RemoveclanMemberByMemberId( $iClanId, $gl_oVars->iMemberId ) )
						{
							$gl_oVars->cTpl->assign( 'success', true );
							
							$gl_oVars->cTpl->assign( 'msg_type', 'success' );
							$gl_oVars->cTpl->assign( 'msg_text', $gl_oVars->aLngBuffer['basic']['c5553'] );
						}
					}
					else
					{
						$gl_oVars->cTpl->assign( 'msg_type', 'error' );
						$gl_oVars->cTpl->assign( 'msg_text', $gl_oVars->aLngBuffer['basic']['c5551'] );
					}					
				}
				else
				{
					// nur eine leader => kann nicht verlassen
					$gl_oVars->cTpl->assign( 'msg_type', 'error' );
					$gl_oVars->cTpl->assign( 'msg_text', 	Templates::ParseContent( $gl_oVars->aLngBuffer['basic']['c5555'],
															$gl_oVars->cTpl,
															array( 'permissions' => $oFirstPermissions->name ))
											);
				}//if
			}
		}
		else
		{
			$gl_oVars->cTpl->assign( 'msg_type', 'warning' );
			$gl_oVars->cTpl->assign( 'msg_text', $gl_oVars->aLngBuffer['basic']['c5552'] );
		}
	
		$gl_oVars->cTpl->assign( 'clans', $aClans );	
	}//if clans-joins available
?>