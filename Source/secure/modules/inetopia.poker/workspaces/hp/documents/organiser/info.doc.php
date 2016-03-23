<?php
	global $gl_oVars;
	$cPokerOrganiser = new PokerOrganiser( $gl_oVars->cDBInterface );
	
	// header params
	$iOrganiserId = (int)$_GET['organiser_id'];

	// fetch data
	$oOrganiser 	= $cPokerOrganiser->GetOrganiserById( $iOrganiserId );
	$aTempMembers	= $cPokerOrganiser->GetOrganiserMembers( $iOrganiserId );
	
	

	$opt = new PermissionTree();
	$opt->SetPermissionFile( EGLFILE_PERMISSIONTREE );
	if( !$opt->CreateTree('organiser') )
	{
		// error
	}

	# receive a list of all permissions
	$aTPL = $opt->GetConstNameArray();


	$aOrganiserMembers = array();
	for( $t=0; $t < sizeof($aTPL); $t++ )
	{
		$aOrganiserMembers [$t] = array();
		for( $i=0; $i < sizeof($aTempMembers); $i++ )
			if( $aTPL[$t]->const == $aTempMembers[$i]->permissions )
				$aOrganiserMembers [$t][sizeof($aOrganiserMembers [$t])] = $aTempMembers[$i];
	}//for
		
	//echo nl2br( print_r($aOrganiserMembers,1));
		
	// provide template with data
	$gl_oVars->cTpl->assign( 'organiser', $oOrganiser );
	$gl_oVars->cTpl->assign( 'org_sessions', $oLastSessions );
	
	$gl_oVars->cTpl->assign( 'tpl', $aTPL );		#tpl => Team Permission List
	$gl_oVars->cTpl->assign( 'organiser_members',	$aOrganiserMembers );
	
?>