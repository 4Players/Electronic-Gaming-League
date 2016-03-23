<?php
	global $gl_oVars;

	$cTeam	= new Team( $gl_oVars->cDBInterface );	
	
	
	#--------------------------
	# Go ? !!
	#--------------------------
	if( $_GET['a'] == 'go' )
	{	
		$obj_create = array( 	'member_id' 			=> $gl_oVars->oMemberData->id,
								'name'					=> $_POST['team_name'],
								'tag'					=> $_POST['team_tag'],
								'created'				=> EGL_TIME,
								'clan_id'				=> EGL_NO_ID,
								'join_password'			=> md5( CreateRandomPassword() ),
								'display_player_logo'	=> 1,
							);
					
		# .... check data content
		
		# .... clan currently exists 
		if( sizeof($cTeam->GetTeamsByName( $obj_create['name'] )) > 0 ){
			
			$gl_oVars->cTpl->assign( 'msg_type', 	'error' );
			$gl_oVars->cTpl->assign( 'msg_text', 	$gl_oVars->aLngBuffer['basic']['c5103'] );	
		}else
		{
			#=======================
			# create clan / create clan member
			#=======================
			
			$team_id=-1;
			if( ($team_id=$cTeam->CreateTeam( $obj_create )) )
			{
				if( $team_id != -1 )
				{
					# team - permission - tree
					$cpt = new PermissionTree();
					$cpt->SetPermissionFile( EGLFILE_PERMISSIONTREE );
					$cpt->CreateTree('team');
					
					# read last 
					$join_permission = $cpt->GetFirst();
					
					
					# define team-join
					$join_team = array( 	'member_id'		=> $gl_oVars->oMemberData->id,
											'team_id'		=> $team_id,
											'permissions'	=> $join_permission->const,
											'created'		=> EGL_TIME,
										);				
					if( $cTeam->JoinTeam( $join_team ) )
					{
						# create team join 
						
						$gl_oVars->cTpl->assign( 'msg_type', 	'success' );
						$gl_oVars->cTpl->assign( 'msg_text', 	$gl_oVars->aLngBuffer['basic']['c5101'] );
							
						# set success
						$gl_oVars->cTpl->assign( 'success', 	true );
						
						PageNavigation::Location( $gl_oVars->sURLFile.'?page=team.center&team_id='.$team_id );
					}// join team
				}
				else
				{
					# ERORR -> creating team
	
					$gl_oVars->cTpl->assign( 'msg_type', 	'error' );
					$gl_oVars->cTpl->assign( 'msg_text', 	$gl_oVars->aLngBuffer['basic']['c5102'] );
	
				}
			}# if Signin Clan
		}//team not exists?
		
		
	}# if $_GET['a']

?>