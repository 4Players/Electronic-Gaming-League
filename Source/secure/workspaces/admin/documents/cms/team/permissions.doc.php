<?php
	global $gl_oVars;

	
	# ------------------------------
	# Purpose: 
	# ------------------------------
	$cClan = new Clan( $gl_oVars->cDBInterface );
	$cTeam = new Team( $gl_oVars->cDBInterface );
	$iTeamId = (int)$_GET['team_id'];
	
	# try to get clan members
	$aTeamMembers 	= $cTeam->GetTeamMembers( $iTeamId );
	$oTeam		 	= $cTeam->GetTeamById( $iTeamId );
	
	# .. prüfen, ob team_id zu clan_id gehört :)
	
	# search for mysql
	$pMyself		= NULL;
	
	/*
	# search for mysql, save data
	for( $i=0; $i < sizeof($aTeamMembers); $i++ )
		if( $gl_oVars->oMemberData->id == $aTeamMembers[$i]->member_id )
			$pMyself = $aTeamMembers[$i];
	*/
		
		
	# team - permission - tree
	$tpt = new PermissionTree();
	$tpt->SetPermissionFile( EGLFILE_PERMISSIONTREE );
	$tpt->CreateTree( 'team');
	
	
		
	# receive a list of all permissions
	$aTPL = $tpt->GetConstNameArray();
	$gl_oVars->cTpl->assign( 'tpl', $aTPL );		#cpl => Clan Permission List	
	
	#----------------------------------------
	# Go
	#----------------------------------------
	if( true )
	{
		if( $_GET['a'] == 'go' )
		{
			$aErrors = array();
			$index=0;
			while(true)
			{
			
				
			# -----------------------------------------
			# list all members containing the clan => overgiven
			# -----------------------------------------
			if( Isset( $_POST['team_member_'.$index] ) )
			{
				#$clan_id			= (int)$oClan->id;
				$team_id			= (int)$iTeamId;
				$memb_id 			= (int)$_POST['team_member_'.$index];
				$memb_permissions 	= $_POST['team_permissions_'.$index];
				
				# get current member data
				$pTeamMember=NULL;
				for( $i=0; $i < sizeof($aTeamMembers); $i++ )
					if( $memb_id == $aTeamMembers[$i]->member_id )
						$pTeamMember = $aTeamMembers[$i];
						
				
				
				#echo "<br>".$memb_id."->".$team_id." : perm /".$memb_permissions;

				# permission changed ?
				$bContinue = false;
				if( $pTeamMember->permissions != $memb_permissions )
				{
					
					# receive access types, by which getting the access !!
					
					# schaue, ob es 'irgendwelche' clanrechte für diese seite gibt
					$aPageClanAccess = $gl_oVars->cPageAccess->GetLastAccessList('clan');
					
				
					# check for clan access
					
					/*
				
						ACHTUNG: Falls keine Clan-rechte für diese Seite vorhanden sind => ganz normaler stamm-baum rechte überprüfen
									==> Clans, die dafür berechtigt sind haben VOLLE RECHTE !! (AUCH GEGENSEITIG !!)
					
					*/
					#if( sizeof($aPageClanAccess) == 0 )
					#{
						# my own right has been chaned ? !!
						/*if( $pTeamMember->member_id == $pMyself->member_id )
						{
							$aErrors[sizeof($aErrors)] = "Du kannst deine Rechte nicht verändern !";
							$bContinue = true;
						}*/					

						# check permissoion
						//$chk_permission = $tpt->Check( $pMyself->permissions, $pTeamMember->permissions );
						
						/*
						switch( $chk_permission )
						{
							#--------------------------------
							# equal
							#--------------------------------
							case 0:
							{
								$aErrors[sizeof($aErrors)] = "Du kannst keine gleichberechtigen Mitglieder verwalten !";
								$bContinue = true;
							}break;
							#--------------------------------
							# failed
							#--------------------------------
							case -1:
							{

								$aErrors[sizeof($aErrors)] = "Du kannst keine übergeordneten Mitglieder verwalten !";
								$bContinue = true;
							}break;
							#--------------------------------
							# looks good !!!
							#--------------------------------
							case 1:
							{
								# check given permissions
								$chk_per2 = $tpt->Check( $pMyself->permissions, $memb_permissions );
								
								
								# Checken ob globale clan-rechte vorhanden sind :)
								if( $chk_per2 == 0 || $chk_per2 == -1 )
								{
									$aErrors[sizeof($aErrors)] = "Du kannst keine übergeordneten Rechte vergeben !";
									$bContinue = true;
								}
							}break;
							default:
							{
						
								# UNKNOWN !!!
								$bContinue = true;
							}break;
						}//switch
						*/
					
						
						# CONTINUE ?? !!
						if( $bContinue )
						{
							$index++;
							continue;
						}
					
					#}//clann access ?
					
				}
				# permission not changed ?
				else
				{
					$index++;	
					continue;
				}
				
				#-------------------------------
				# Soweit gekommen, hat man zugriff !!
				#-------------------------------
				
				# create permission object
				$obj  = NULL;
				$obj->permissions = $memb_permissions;
				
				
				# define update query
				$update_query 	= 	$gl_oVars->cDBInterface->CreateUpdateQuery( $GLOBALS['g_egltb_team_joins'], $obj );
				$update_query 	.= 	" WHERE member_id=$memb_id AND team_id=$team_id";
			
				
				# run query
				$qre = $gl_oVars->cDBInterface->Query( $update_query );
				

				if( !$qre )
				{
					$gl_oVars->cTpl->assign( 'msg_type', 	'error' );
					$gl_oVars->cTpl->assign( 'msg_title', 	'Fehler' );
					$gl_oVars->cTpl->assign( 'msg_text', 	'Es ist ein schwehrer Fehler aufgetreten, bitte melden Sie das umgehend dem Admin !' );	
					$gl_oVars->cTpl->assign( 'msg_errors', 	NULL );					}
				else
				{
					# save new permissions
					#$pClanMember->permissions = $memb_permissions;
				}
					
				
			}
			else break;
			
			#secure check
			if( $index >= 1000) break;
			$index++;# inc. index counter
			
			# ----
			# END TRUE
			# ----
			}#while(true)
			
		
			#----------------------
			# errors ?
			#----------------------
			if( sizeof($aErrors) > 0 )
			{
				$gl_oVars->cTpl->assign( 'msg_type', 	'error' );
				$gl_oVars->cTpl->assign( 'msg_title', 	'Fehler' );
				$gl_oVars->cTpl->assign( 'msg_text', 	'Die Rechte wurden nicht oder nur teilweise gesetzt' );
				$gl_oVars->cTpl->assign( 'msg_errors', 	$aErrors );
			}
			else
			{
				$gl_oVars->cTpl->assign( 'msg_type', 	'success' );
				$gl_oVars->cTpl->assign( 'msg_title', 	'Erfolgreich' );
				$gl_oVars->cTpl->assign( 'msg_text', 	'Die Rechte wurden erfolgreich gesetzt' );
				
				$gl_oVars->cTpl->assign( 'success', 	true );

				PageNavigation::Location( $gl_oVars->sURLFile.'?page='.$gl_oVars->sURLPage.'&team_id='.$iTeamId );
			}
			
		}# if _get == 'go' ?
		
		
	}//if $oClan	


	$gl_oVars->cTpl->assign( 'team',  			$oTeam );		# clan-data
	$gl_oVars->cTpl->assign( 'team_members', 	$aTeamMembers );		#cpl => Clan Permission List	
	
	
	if( sizeof($aTeamMembers) == 0 )
	{
		$gl_oVars->cTpl->assign( 'msg_type', 	'info' );
		$gl_oVars->cTpl->assign( 'msg_title', 	'Keine Member vorhanden' );
		$gl_oVars->cTpl->assign( 'msg_text', 	'Dieses Team beinhlatet keine angemeldeten Member !' );	
		
		$gl_oVars->cTpl->assign( 'success', 	true );
	}
	
	
?>