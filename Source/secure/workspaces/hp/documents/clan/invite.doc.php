<?php
	global $gl_oVars;

	
	
	# decöare ocjects and classes
	$cClan = new Clan( $gl_oVars->cDBInterface );
	

		
	# -----------------------------------------------------
	# ACTIONS 
	# -----------------------------------------------------
	if( $_GET['a'] == 'go' )
	{
		$iMemberId 		= (int)$_POST['invite_id'];
		$sMemberNick 	= $_POST['invite_nick_name'];
		$oMember		= NULL;
		

		# try fetching memberdata
		if( $iMemberId ) $oMember = $gl_oVars->cMember->GetMemberDataById( $iMemberId );
		if( !$oMember && $sMemberNick ) $gl_oVars->cMember->GetMemberDataByNickname( $sMemberNick );
		
		# member found ?
		if( $oMember )
		{
			# inviter - - - clan_id
			$iClanId	= (int)$_GET['clan_id'];
			$bJoined	= (int)$cClan->ClanJoinedByMemberId( $iClanId, $oMember->id );

					
			# currently in ?
			if( $bJoined )
			{
				// Dieses Mitglied ist dem Clan bereits beigetreten
				$gl_oVars->cTpl->assign( 'msg_type',	'info' );
				$gl_oVars->cTpl->assign( 'msg_text',	 $gl_oVars->aLngBuffer['basic']['c4635']);
			}
			else
			{
				# active invitations ??
				if( $cClan->ActiveInvitationAvailable( $iClanId, $oMember->id ))
				{
					// Dieses Mitglied hat bereits eine unverarbeitete Einladung
					$gl_oVars->cTpl->assign( 'msg_type',	'info' );
					$gl_oVars->cTpl->assign( 'msg_text',	$gl_oVars->aLngBuffer['basic']['c4636'] );
				}
				else 
				{
					#-----------------------------------------
					# A D D 
					#-----------------------------------------
					
					# define invitation
					$obj = array( 	'member_id'		=> (int)$oMember->id,
									'clan_id' 		=> $iClanId,
									'inviter_id' 	=> $gl_oVars->oMemberData->id,
									'accepted' 		=> 0,
									'processed'		=> 0,
									'text'			=> $_POST['invite_text'],
									'created'		=> EGL_TIME
								);
				
					# create invitation	
					if( $cClan->CreateInvitation( $obj ) )
					{
						// Die Einladung wurde erfolgreich erstellt
						$gl_oVars->cTpl->assign( 'success',	true );
						$gl_oVars->cTpl->assign( 'msg_type',	'success' );
						$gl_oVars->cTpl->assign( 'msg_text',	$gl_oVars->aLngBuffer['basic']['c4637'] );
					}
					else
					{
						// Es ist ein unbekannter Fehler aufgetreten. Bitte melden Sie dies den zuständigen Administratoren
						$gl_oVars->cTpl->assign( 'msg_type',	'error' );
						$gl_oVars->cTpl->assign( 'msg_text',	$gl_oVars->aLngBuffer['basic']['c4638'] );
					}//if
							
				}//if activeinvitationavailable
			} // if joined
		}//if
		else
		{
			// Es konnte kein Mitglied mit diesen Daten gefunden werden
			$gl_oVars->cTpl->assign( 'msg_type',	'error' );
			$gl_oVars->cTpl->assign( 'msg_text',	$gl_oVars->aLngBuffer['basic']['c4639'] );
		}
		
	}//if

	
?>