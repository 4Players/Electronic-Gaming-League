<?php
	global $gl_oVars;

	# ------------------------------
	# Purpose: 
	# ------------------------------
	$cClan = & new Clan( $gl_oVars->cDBInterface );
	
	# try to get clan members
	$aClanMembers 	= $cClan->GetClanMembers( (int)$_GET['clan_id'] );
	$oClan		 	= $gl_oVars->cMember->GetClanAccount( (int)$_GET['clan_id'] );
	
	
	# Clannot found
	if( !$oClan )
	{
		$gl_oVars->cTpl->assign( 'msg_type', 	'error' );
		$gl_oVars->cTpl->assign( 'msg_text', 	$gl_oVars->aLngBuffer['basic']['c4736'] );

		return 0;
	}
	
	# search for mysql
	$pMyself		= NULL;
	
	# search for mysql, save data
	for( $i=0; $i < sizeof($aClanMembers); $i++ )
		if( $gl_oVars->oMemberData->id == $aClanMembers[$i]->member_id )
			$pMyself = $aClanMembers[$i];
			
			
			
	# echo 
	if( !$pMyself )
	{
		DEBUG( MSGTYPE_ERROR, __FILE__, __LINE__, "ERROR: clan.permissions.doc.php 'Myself not found'" );
		return 0;
	}
	
	#----------------------------------
	# load permission tree
	#----------------------------------
	#$gl_oVars->cTpl->config_load( "permission_tree.conf", 'clan' );
		
	# clan - permission - tree
	$cpt = new PermissionTree();
	$cpt->SetPermissionFile( EGLFILE_PERMISSIONTREE );
	
	$cpt->CreateTree( 'clan');
		
	# receive a list of all permissions
	$aCPL = $cpt->GetConstNameArray();
	$gl_oVars->cTpl->assign( 'cpl', $aCPL );		#cpl => Clan Permission List
	
			
	
			
	#----------------------------------------
	# Go
	#----------------------------------------
	if( $oClan )
	{
		if( $_GET['a'] == 'go' )
		{
			$aErrors = array();
			$index=0;
			while(true)
			{
			
				/*
					ACHTUNG könnte durch while schleife Probleme geben.
					=> ausbessern durch for-schleife
				
				*/

			# -----------------------------------------
			# list all members containing the clan => overgiven
			# -----------------------------------------
			if( Isset( $_POST['clan_member_'.$index] ) )
			{
				$clan_id			= (int)$oClan->id;
				$memb_id 			= (int)$_POST['clan_member_'.$index];
				$memb_permissions 	= $_POST['member_permissions_'.$index];
				
				
			
				# get current member data
				$pClanMember=NULL;
				for( $i=0; $i < sizeof($aClanMembers); $i++ )
					if( $memb_id == $aClanMembers[$i]->member_id )
						$pClanMember = $aClanMembers[$i];
				
				# member not found ?
				if( !$pClanMember )
				{
					# break update
					$index++;
					continue;
				}//if
				
				# permission changed ?
				$bContinue = false;
				if( $pClanMember->permissions != $memb_permissions )
				{
					if( $pClanMember->member_id == $pMyself->member_id )
					{
						
						// Du kannst deine Rechte nicht verändern
						$aErrors[sizeof($aErrors)] = $gl_oVars->aLngBuffer['basic']['c4857'];
						$bContinue = true;
					}
					
					# check permissoion
					$chk_permission = $cpt->Check( $pMyself->permissions, $pClanMember->permissions );
	
	
					switch( $chk_permission )
					{
						#--------------------------------
						# equal
						#--------------------------------
						case 0:
						{
							// Du kannst keine gleichberechtigen Mitglieder verwalten
							$aErrors[sizeof($aErrors)] = $gl_oVars->aLngBuffer['basic']['c4858'];
							$bContinue = true;
						}break;
						#--------------------------------
						# Test Fehlgeschlagen ... 
						#--------------------------------
						case -1:
						{
							// Du kannst keine übergeordneten Mitglieder verwalten
							$aErrors[sizeof($aErrors)] = $gl_oVars->aLngBuffer['basic']['c4859'];
							$bContinue = true;
						}break;
						case -2:		# if nothing defined ??
						{
							// Es ist ein Fehler aufgetreten - PermissionTree nicht richtig definiert!
							$aErrors[sizeof($aErrors)] = $gl_oVars->aLngBuffer['basic']['c4860'];
							$bContinue = true;
							
							DEBUG( MSGTYPE_ERROR, __FILE__, __LINE__, "PermissionTree CheckError [{$pMyself->permissions}, `{$pClanMember->permissions}`] - Result [-2] Permission not in PermissionTree defined " );							
						}break;
						#--------------------------------
						# Test Erfolgreich
						#--------------------------------
						case 1:
						{
							# check given permissions
							$check_given_permissions = $cpt->Check( $pMyself->permissions, $memb_permissions );
							
							#echo $chk_per2;
							if( $check_given_permissions == 0 ||	# gleiche bereechtigung 
								$check_given_permissions == -1 )	# obemdr+b
							{
								// Du kannst keine übergeordneten Rechte vergeben 
								$aErrors[sizeof($aErrors)] = $gl_oVars->aLngBuffer['basic']['c4859'];
								$bContinue = true;
							}
							
						}break;
						default:
						{
							
						
							# UNKNOWN !!!
							$bContinue = true;
						}break;
					}//switch
					
					if( $bContinue )
					{
						$index++;
						continue;
					}
					
				}else
				{
					$index++;	
					continue;
				}
				
				
				
				# create permission object
				$obj  = array( 'permissions'	=> $memb_permissions );
				
				# define update query
				$update_query = $gl_oVars->cDBInterface->CreateUpdateQuery( $GLOBALS['g_egltb_clan_members'], $obj );
				$update_query .= " WHERE member_id=$memb_id AND clan_id=$clan_id";
			
				
				
				# run query
				$qre = $gl_oVars->cDBInterface->Query( $update_query );
				
				if( !$qre )
				{
					echo "ERROR";
				}
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
			
			}#while(true)
		
			# errors ?
		
			if( sizeof($aErrors) > 0 )
			{
				// Die Rechte wurden nicht oder nur teilweise gesetzt'
				$gl_oVars->cTpl->assign( 'msg_type', 	'error' );
				$gl_oVars->cTpl->assign( 'msg_text', 	$gl_oVars->aLngBuffer['basic']['c4856'] );
				$gl_oVars->cTpl->assign( 'msg_errors', 	$aErrors );
			}
			else
			{
				// 'Die Rechte wurden erfolgreich gesetzt'
				$gl_oVars->cTpl->assign( 'msg_type', 	'success' );
				$gl_oVars->cTpl->assign( 'msg_text', 	$gl_oVars->aLngBuffer['basic']['c4861'] );
				$gl_oVars->cTpl->assign( 'success', 	'true' );
			}
		}# if _get == 'go' ?
		
		
	}//if $oClan	


	# -----------------------
	# clan members found ?
	# -----------------------
	if( $oClan)
	if( $aClanMembers )
	{
		$gl_oVars->cTpl->assign( 'clan', 			$oClan );
		$gl_oVars->cTpl->assign( 'clan_members', 	$aClanMembers );
	
	}
?>