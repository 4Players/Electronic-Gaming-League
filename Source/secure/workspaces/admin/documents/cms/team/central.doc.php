<?php

	global $gl_oVars;
	
	# ---------------
	$iTeamId	= (int)$_GET['team_id'];
	


	# define & declare objects & classes
	$cTeam = new Team( $gl_oVars->cDBInterface );
	$oTeam = $cTeam->GetTeam( $iTeamId );
	
	
	$oTeam 			= $cTeam->GetTeam_clandata( $iTeamId );
	$aTempMembers	= $cTeam->GetTeamMembers( $iTeamId );
	
	
	$tpt = new PermissionTree();
	$tpt->SetPermissionFile( EGLFILE_PERMISSIONTREE );
	$tpt->CreateTree( 'team');		# read team permission-tree
		
	# receive a list of all permissions
	$aTPL = $tpt->GetConstNameArray();
	

	$aTeamMembers = array();
	for( $t=0; $t < sizeof($aTPL); $t++ )
	{
		$aTeamMembers [$t] = array();
		for( $i=0; $i < sizeof($aTempMembers); $i++ )
			if( $aTPL[$t]->const == $aTempMembers[$i]->permissions )
				$aTeamMembers [$t][sizeof($aTeamMembers [$t])] = $aTempMembers[$i];
	}//for
	
	
	
	
	
	
	$gl_oVars->cTpl->assign( 'tpl', $aTPL );		#tpl => Team Permission List
			
	$gl_oVars->cTpl->assign( 'team', 			$oTeam );
	$gl_oVars->cTpl->assign( 'team_members',	$aTeamMembers );
			
?>