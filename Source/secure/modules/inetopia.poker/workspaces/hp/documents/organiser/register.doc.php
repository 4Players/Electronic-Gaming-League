<?php
	global $gl_oVars;

	$cPokerOrganiser = new PokerOrganiser( $gl_oVars->cDBInterface );
	
	$opt = new PermissionTree();
	$opt->SetPermissionFile( EGLFILE_PERMISSIONTREE );
	if( !$opt->CreateTree('organiser') )
	{
		
	}

	#-------------------------------------------	
	# ON REGISTER
	#-------------------------------------------	
	if( $_GET['a'] == 'register' )
	{
		$aRegOrganiser = array( 'name'			=> $_POST['name'],
								'member_id'		=> $gl_oVars->iMemberId,
								'hp'			=> $_POST['hp'],
								'created'		=> EGL_TIME,
								);
		$iOrganiserId = -1;
		if( $iOrganiserId=$cPokerOrganiser->RegisterOrganiser( $aRegOrganiser ) ){
			
			if( $iOrganiserId ){
				$opt = new PermissionTree();
				$opt->SetPermissionFile( EGLFILE_PERMISSIONTREE );
				$opt->CreateTree('organiser');				

				$head_permissions =  $opt->GetFirst();

				// define headmaster for organiser
				$aRegOrgaMember = 
							array( 	'member_id'		=> $gl_oVars->iMemberId,
									'organiser_id' 	=> $iOrganiserId,
									'permissions'	=> $head_permissions->const,
									'created'		=> EGL_TIME,
							);
				if( $cPokerOrganiser->RegisterOrganiserMember($aRegOrgaMember) ){
					// success
					$gl_oVars->cTpl->assign( 'msg_type', 'success' );
					$gl_oVars->cTpl->assign( 'msg_text', 'Versntalter wurde erstellt' );
				}else{
					// error
					$gl_oVars->cTpl->assign( 'msg_type', 'error' );
					$gl_oVars->cTpl->assign( 'msg_text', 'Versntalter konnte nicht erstellt werden' );
				}//if
				
			}//if
		}else{
			// error
			$gl_oVars->cTpl->assign( 'msg_type', 'error' );
			$gl_oVars->cTpl->assign( 'msg_text', 'Versntalter konnte nicht erstellt werden' );
		}//if
	}
	else
	{
	}
	
?>	