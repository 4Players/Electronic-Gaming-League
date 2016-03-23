<?php
	global $gl_oVars;
	
	$cGamePool 	= new GamePool( $gl_oVars->cDBInterface );
	$cCountry	= new Country( $gl_oVars->cDBInterface );
	
	$cTeam		= new Team( $gl_oVars->cDBInterface );
	
	
	/*
	Beschreibung:
	---------------
	In $aTeamDetails sind die daten der Team-Members incl. 
	
	*/
	$iTeamId		= (int)$_GET['team_id'];
	
	
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
	
	


	# ----------------------------------------------------------------------------------------------------------
	# C O M M E N T S 
	# ----------------------------------------------------------------------------------------------------------
	
	# create comment manage object for members
	$cComments = new Comments( $gl_oVars->cDBInterface, $GLOBALS['g_egltb_team_comments'], 'team_id' );
	
	
	#----------------------------------------------------
	# comment input detected ?
	#----------------------------------------------------
	if( Isset( $_POST['comment_text'] ) &&
		strlen($_POST['comment_text']) > 0 &&
		$gl_oVars->bLoggedIn )
	{
		$msg_obj = NULL;
		$msg_obj->team_id 	= $iTeamId;
		$msg_obj->author_id = $gl_oVars->oMemberData->id;
		$msg_obj->text 		= $_POST['comment_text'];	
		$msg_obj->created 	= time();
		
		# try to create obj
		if( $cComments->CreateComment($msg_obj) )
		{
			# successful
			PageNavigation::Location( $gl_oVars->sURLFile.'?page='.$gl_oVars->sURLRealPage.'&team_id='.$iTeamId.'&comment=show' );
		}
		
	}#/if

	

	$aTeamComments			= NULL;
	$iTeamCommentsCounter  	= -1;
	
	# get comment buffer
	if( $_GET['comment'] == 'write' ||
		$_GET['comment'] == 'show' )
	{
		# try to catch the comments of current displayed member
		$aTeamComments = $cComments->GetComments( (int)$iTeamId );
		$iTeamCommentsCounter = sizeof($aTeamComments);
	}
		
	
	# counter already read, else => read
	if( $iTeamCommentsCounter == -1 )
		$iTeamCommentsCounter = $cComments->GetCommentsCount( (int)$iTeamId );
			
		
	# save data as a var into template
	$gl_oVars->cTpl->assign( 'comments',		$aTeamComments ); 
	$gl_oVars->cTpl->assign( 'comment_count', 	$iTeamCommentsCounter );
			
	
	
	# ----------------------------------------------------------------------------------------------------------

	
	$gl_oVars->cTpl->assign( 'tpl', $aTPL );		#tpl => Team Permission List
			
	$gl_oVars->cTpl->assign( 'team_games', 		$cGamePool->GetGameList($oTeam->games) );
	$gl_oVars->cTpl->assign( 'team', 			$oTeam );
	$gl_oVars->cTpl->assign( 'team_members',	$aTeamMembers );
	
	$gl_oVars->cTpl->assign( 'countries', 		$cCountry->GetCountries() );	
	

	
	return 1;
?>