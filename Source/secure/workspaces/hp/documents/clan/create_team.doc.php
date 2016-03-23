<?php
	global $gl_oVars;

	$cTeam	= new Team( $gl_oVars->cDBInterface );
	$cClan	= new Clan( $gl_oVars->cDBInterface );
	
	$oClan	=  $gl_oVars->cMember->GetClanAccount( (int)$_GET['clan_id'] );
	
	# save
	if( $oClan ) $gl_oVars->cTpl->assign( 'clan', $oClan  );
	else
	{
		$gl_oVars->cTpl->assign( 'msg_type', 	'error' );
		$gl_oVars->cTpl->assign( 'msg_text', 	$gl_oVars->aLngBuffer['basic']['c4833'] );
		
		return 0;
	}//if


	#--------------------------
	# Go ? !!
	#--------------------------
	if( $_GET['a'] == 'go' )
	{
		$bError = false;
		
		$obj = array( 	'member_id'		=> $gl_oVars->iMemberId,
						'name'			=> $_POST['team_name'],
						'tag'			=> $_POST['team_tag'],
						'created'		=> EGL_TIME,
						'clan_id' 		=> $oClan->id,
						'display_player_logo'	=> 1,
					);
					
		# .... check data content
		

		# .... clan currently exists 
				# .... clan currently exists 
		if( sizeof($cTeam->GetTeamsByName( $obj['name'] )) > 0 ){
			
			$gl_oVars->cTpl->assign( 'msg_type', 	'error' );
			$gl_oVars->cTpl->assign( 'msg_text', 	$gl_oVars->aLngBuffer['basic']['c5103'] );	
		}else
		{		
			 
			
			#=======================
			# create clan / create clan member
			#=======================
			
			$team_id=-1;
			if( ($team_id=$cTeam->CreateTeam( $obj )) )
			{
				if( $team_id != -1 )
				{
					# team - permission - tree
					$tpt = new PermissionTree();
					$tpt->SetPermissionFile( EGLFILE_PERMISSIONTREE );
					$tpt->CreateTree('team');
					
					# read last 
					$join_permission = $tpt->GetFirst();
					
					# define team-join o
					$join_team = array( 'member_id'		=> $gl_oVars->iMemberId,
										'team_id'		=> $team_id,
										'permissions'	=> $join_permission->const,
										'created'		=>	EGL_TIME,
									);
					if( $cTeam->JoinTeam( $join_team ) )
					{
						# create team join 
						
						$gl_oVars->cTpl->assign( 'msg_type', 	'success' );
						$gl_oVars->cTpl->assign( 'msg_text', 	$gl_oVars->aLngBuffer['basic']['c4834'] );
							
						# set success
						$gl_oVars->cTpl->assign( 'success', 	true );
					}// join team
				}
				else
				{
					# ERORR -> creating team
					#DEBUG()
				}
			}# if Signin Clan
			
		}//if team exists?
		
		
	}# if $_GET['a']

?>