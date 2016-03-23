<?php
	global $gl_oVars;
	
	# ---------------
	$iClanId	= (int)$_GET['clan_id'];
	


	# define & declare objects & classes
	$cClan = new Clan( $gl_oVars->cDBInterface );

	
	
	$oClan = $cClan->GetClanById( $iClanId );
	if( $oClan )
	{
		$gl_oVars->cTpl->assign( 'clan', $oClan );
		
		# fetch memberdata
		$aClanMembers = $cClan->GetClanMembers( $iClanId );
		$gl_oVars->cTpl->assign( 'clan_members', $aClanMembers );
		
		
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

		
		
		
		
		# ------------------------------------------------------
		# Change permissions
		# ------------------------------------------------------
		if( $_GET['a'] == 'go' )
		{
			$numMembers=sizeof($aClanMembers);
			for( $index=0; $index < $numMembers; $index++ )
			{
				$memb_id 			= (int)$_POST['clan_member_'.$index];
				$memb_permissions 	= $_POST['member_permissions_'.$index];
				
				
				# change data
				$obj_update = array( 'permissions'	=> $memb_permissions );

				
				# define update query
				$update_query = $gl_oVars->cDBInterface->CreateUpdateQuery( $GLOBALS['g_egltb_clan_members'], $obj_update );
				$update_query .= " WHERE member_id=".(int)$memb_id." AND clan_id=".(int)$oClan->id."";
			
				# run query
				$qre = $gl_oVars->cDBInterface->Query( $update_query );
												
				PageNavigation::Location( $gl_oVars->sURLFile.'?page='.$gl_oVars->sURLPage.'&clan_id='.$oClan->id );
				
			}//for
			
			
		} // if $_GET['a'] == 'go'
				
	} // if $oClan
	
?>