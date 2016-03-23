<?php
	global $gl_oVars;


	# define classes/objects
	$cClan	= new Clan( $gl_oVars->cDBInterface );	

	
	
	#--------------------------
	# Go ? !!
	#--------------------------
	if( $_GET['a'] == 'go' )
	{
		$obj_create = array(	'name'					=> $_POST['clan_name'],
								'tag' 					=> $_POST['clan_tag'],
								'hp'					=> $_POST['clan_hp'],
								'created'				=> EGL_TIME,
								'join_password'			=> md5(CreateRandomPassword()),	# create random password, hidden
								'display_player_logo'	=> 1,
							);
		
		# .... check data content

		# .... clan currently exists 
		if( sizeof($cClan->GetClansByName( $obj_create['name'] )) > 0 ){
			$gl_oVars->cTpl->assign( 'msg_type', 	'error' );
			$gl_oVars->cTpl->assign( 'msg_text', 	$gl_oVars->aLngBuffer['basic']['c4727'] );	
			
			
		}else
		{
			
			#=======================
			# create clan / create clan member
			#=======================
			
			$clan_id=-1;
			if( ($clan_id=$cClan->SignIn( $obj_create )) )
			{
				
				# id correct ?
				if( $clan_id > 0 )
				{
					# team - permission - tree
					$cpt = new PermissionTree();
					$cpt->SetPermissionFile( EGLFILE_PERMISSIONTREE );
					$cpt->CreateTree('clan');
					
				
					# read first 
					$first_permission = $cpt->GetFirst();
					
					$obj_join = array( 		'member_id'		=> (int)$gl_oVars->oMemberData->id,
											'clan_id'		=> $clan_id,	// X problemzone1
											'permissions'	=> $first_permission->const,
											'created'		=> EGL_TIME,
										);
				
					#  member
					if( $cClan->SigninMember( $obj_join ) )
					{
						$gl_oVars->cTpl->assign( 'msg_type', 	'success' );
						$gl_oVars->cTpl->assign( 'msg_text', 	$gl_oVars->aLngBuffer['basic']['c4724'] );
						
						# set success
						$gl_oVars->cTpl->assign( 'success', 	true );
						
						PageNavigation::Location( $gl_oVars->sURLFile.'?page=clan.center&clan_id='.$clan_id );
					}
					else
					{	
						# delete current created clan
						$cClan->DeleteClan( $clan_id );
						
						$gl_oVars->cTpl->assign( 'msg_type', 	'error' );
						//$gl_oVars->cTpl->assign( 'msg_title', 	'Fehler' );
						$gl_oVars->cTpl->assign( 'msg_text', 	$gl_oVars->aLngBuffer['basic']['c4725'] );
					}
				}# if clan_id != -1
				
			}# if  Clan
		}//if noz clan exists
		
	}# if $_GET['a']

	
	

?>