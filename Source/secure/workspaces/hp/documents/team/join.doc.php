<?php
	#-----------------------------------
	# TEAM JOIN
	#-----------------------------------	
	global $gl_oVars;
	
	
	
	$cClan 	= new Clan( $gl_oVars->cDBInterface );
	$cTeam  = new Team( $gl_oVars->cDBInterface );
	
	/*	
	$oClan	= NULL;
	if( Isset( $_GET['clan_id'] ))
	{
		$iClanId=(int)$_GET['clan_id'];
		
		# get clan object
		$oClan 	=  $gl_oVars->cMember->GetClanAccount( $iClanId );
		
		# clan found ?
		if( $oClan )
		{
			$gl_oVars->cTpl->assign( 'clan', 		$oClan  );
			$gl_oVars->cTpl->assign( 'clan_teams',  $cTeam->GetClanTeams( $oClan->id) );
		}//if
		else
		{
			$gl_oVars->cTpl->assign( 'msg_type', 	'error' );
			$gl_oVars->cTpl->assign( 'msg_title', 	'Fehler' );
			$gl_oVars->cTpl->assign( 'msg_text', 	'Sie sind in keinem Clan registriert.' );
			return 0;
		}//if $oClan
	}//if*/
	
	
	#---------------------------------
	# if = go ?? 
	#---------------------------------
	/*if( strlen($_POST['join_name'])>0 )
	if( strlen($_POST['join_psd'])>0 )*/
	
	if( $_GET['a'] == 'search' )
	{
		$oTeam		= NULL;
		$iTeamId 	= (int)$_POST['join_id'];
		$sTeamName 	= $_POST['join_name'];
		
		
		$aTeamList	= array();
		
		// try searching clan accounts
		if( $iTeamId > 0 ){
			$oTeam = $cTeam->GetTeamById( $iTeamId );
			if( $oTeam ){
				$aTeamList[0] = $oTeam;
			}
		}
		elseif( strlen($sTeamName) > 0 ){
			$aTeamList = $cTeam->GetTeamsByName( $sTeamName );
		}
		
		
		$gl_oVars->cTpl->assign( 'teamlist', $aTeamList );
	}
	# ---------------------------------------------
	# GO ? !!!
	# ---------------------------------------------
	if( $_GET['a'] == 'go' ) 
	{
		# is member currently joined ?
		$team_id	= (int)$_POST['team_id'];
		$oTeam 		= $cTeam->GetTeamById( $team_id );
		$bAccess	= false;
		

		# fetch join data
		if( /*$oClan*/ true )
		{
			# prüfe nur ob gejoint
			/*
				sonst würde das ganze hier nicht zu stande kommen *hoffentlich*
			*/
			$is_joined = (int)$cTeam->GetNumTeamJoins( $gl_oVars->iMemberId, $team_id );
			if( $is_joined )
			{
				// Sie sind bereits Mitglied in diesem Team
				$gl_oVars->cTpl->assign( 'msg_type', 	'error' );
				$gl_oVars->cTpl->assign( 'msg_text', 	$gl_oVars->aLngBuffer['basic']['c5122'] );
			}//if
			else 
			{
				echo $oTeam->join_password;
				
				# CHECK PASSWORD
				if( $oTeam->join_password == md5($_POST['join_psd']) )
				{
					$bAccess = true;
				}// if password
				else
				{
					// Sie haben nicht das korrekte Passwort angegeben!
					$gl_oVars->cTpl->assign( 'msg_type', 	'error' );
					$gl_oVars->cTpl->assign( 'msg_text', 	$gl_oVars->aLngBuffer['basic']['c5123'] );
				} // if password
			} // if joiuned ?
			
		}
		/*
		else
		{
			# search teamname
			$oTeam = $cTeam->GetTeamById( $team_id );
			if( $oTeam )
			{
				#----------------------------------------------
				# Wenn das Team ein ClanTeam ist => verbiete Join
				#----------------------------------------------
				if( $oTeam->clan_id != EGL_NO_ID && !$cClan->ClanJoinedByMemberId($oTeam->clan_id, $gl_oVars->oMemberData->id) )
				{
					$gl_oVars->cTpl->assign( 'msg_type', 	'error' );
					$gl_oVars->cTpl->assign( 'msg_title', 	'Fehler' );
					$gl_oVars->cTpl->assign( 'msg_text', 	'Dieses Team kann erst gejoint werden, wenn du Mitglied in dessen Clan bist!' );
	
				}
				else
				{
					$team_id 	= $oTeam->id;
					$is_joined 	= (int)$cTeam->GetNumTeamJoins( $gl_oVars->iMemberId, (int)$oTeam->id );
					
					
					#-------------------------------------------------------------
					# Currently joined in team ??
					#-------------------------------------------------------------
					if( $is_joined )
					{
						$gl_oVars->cTpl->assign( 'msg_type', 	'error' );
						$gl_oVars->cTpl->assign( 'msg_title', 	'Fehler' );
						$gl_oVars->cTpl->assign( 'msg_text', 	'Sie sind bereits Mitglied in diesem Team!' );
					}
					else
					{
					
						# CHECK PASSWORD
						if( $oTeam->join_password == $_POST['join_team_password'] )
						{
							$bAccess = true;
						}// if password
						else
						{
							$gl_oVars->cTpl->assign( 'msg_type', 	'error' );
							$gl_oVars->cTpl->assign( 'msg_title', 	'Fehler' );
							$gl_oVars->cTpl->assign( 'msg_text', 	'Sie haben nicht das korrekte Passwort angegeben!' );
						} // if password
					} // if currently join in team ?
				} // if clanteam ?
				
				
			} // if Team avaiable ?				
			else
			{
				$gl_oVars->cTpl->assign( 'msg_type', 	'error' );
				$gl_oVars->cTpl->assign( 'msg_title', 	'Fehler' );
				$gl_oVars->cTpl->assign( 'msg_text', 	'Dieses Team existiert nicht!' );
			}//if
		} // if !clan
		*/
		
		
		
		
		if( $bAccess  )
		{
			# team - permission - tree
			$tpt = new PermissionTree();
			$tpt->SetPermissionFile( EGLFILE_PERMISSIONTREE );

			$tpt->CreateTree( 'team');
			
			# read last 
			$join_permission = $tpt->GetLast();
			
			$obj = NULL;
			$obj->member_id		= $gl_oVars->iMemberId;
			#$obj->clan_id		= (int)$oClan->id;
			$obj->team_id		= (int)$team_id;
			$obj->permissions	= $join_permission->const;
			$obj->created		= EGL_TIME;

			# join team
			if( $cTeam->JoinTeam( $obj ) )
			{
				$gl_oVars->cTpl->assign( 'success', true );
				$gl_oVars->cTpl->assign( 'msg_type', 	'success' );
				$gl_oVars->cTpl->assign( 'msg_text', 	$gl_oVars->aLngBuffer['basic']['c5124'] );
				
			}//if
		}
		else
		{
		}
			
	}//if
	
	

	
?>