<?php
	global $gl_oVars;
	
	
	$iTeamId	= (int)$_GET['team_id'];
	

	############################################################
	$cTeam = new Team( $gl_oVars->cDBInterface );
	$cClan = new Clan( $gl_oVars->cDBInterface );

	
	# fetch data
	$oTeam = $gl_oVars->cMember->GetTeamAccount( $iTeamId );

	if( $oTeam->clan_id != EGL_NO_ID )
	{
		// Dieses Team ist beretis in einem Clan!
		$gl_oVars->cTpl->assign( 'msg_type', 	'error' );
		$gl_oVars->cTpl->assign( 'msg_text', 	$gl_oVars->aLngBuffer['basic']['c5251'] );
	}//if
	else
	{
		#------------------------------------------
		# SEARCH
		#------------------------------------------
	
		if( $_GET['a'] == 'search' )
		{
			$iClanId 	= (int)$_POST['join_id'];
			$sClanName 	= $_POST['join_name'];

			
			$aClanList	= array();
			
			// try searching clan accounts
			if( $iClanId > 0 ){
				$oClan = $cClan->GetClanById( $iClanId );
				if( $oClan ){
					$aClanList[0] = $oClan;
				}
			}
			elseif( strlen($sClanName) > 0 ){
				$aClanList = $cClan->GetClansByName( $sClanName );
			}
			
			
			$gl_oVars->cTpl->assign( 'clanlist', $aClanList );
		}
		
		#------------------------------------------
		# Change
		#------------------------------------------
		if( $_GET['a'] == 'go' )
		{		
			$oClan = $cClan->GetClanById( $_POST['clan_id'] );
			
			if( $oClan )
			{
				if( $oClan->join_password == md5($_POST['join_psd'])  )
				{
					$gl_oVars->cTpl->assign( 'success', true );
					
					# define update mask
					$change_obj = array( 'clan_id'	=> $oClan->id );
							
					if( $cTeam->SetTeamData( $change_obj, $oTeam->id ) )
					{
						// Das Team ist dem Clan erfolgreich beigetreten
						$gl_oVars->cTpl->assign( 'msg_type', 	'success' );
						$gl_oVars->cTpl->assign( 'msg_text', 	$gl_oVars->aLngBuffer['basic']['c5252'] );
					}
						
				
	
				}
				else
				{
					$gl_oVars->cTpl->assign( 'msg_type', 	'error' );
					$gl_oVars->cTpl->assign( 'msg_text', 	$gl_oVars->aLngBuffer['basic']['c5253'] );
				}
			}
			else
			{
				$gl_oVars->cTpl->assign( 'msg_type', 	'error' );
				$gl_oVars->cTpl->assign( 'msg_text', 	$gl_oVars->aLngBuffer['basic']['c5254'] );
			}
		}

		# provide template with vars
	}//if
	

	$gl_oVars->cTpl->assign( 'team', $oTeam );
?>