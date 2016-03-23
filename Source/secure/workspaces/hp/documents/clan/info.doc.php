<?php
	global $gl_oVars;

	$cGamePool 	= new GamePool( $gl_oVars->cDBInterface );
	$cCountry	= new Country( $gl_oVars->cDBInterface );
	
	
	# global ids
	$iClanId	= (int)$_GET['clan_id'];
	
	

	#-----------------------------------
	# fetch clan data
	#-----------------------------------	
	$cClan 		= new Clan( $gl_oVars->cDBInterface );
	$cTeam		= new Team( $gl_oVars->cDBInterface );

	
	#---------------------------------------------------------------
	$oClan				= $cClan->GetClanById( $iClanId );
	$aTeams				= $cClan->GetClanTeams( $iClanId );	/* read teams with clan informations */
	$aTmpClanMembers	= $cClan->GetClanMembers( $iClanId );
	
	/*
	#$oClanBuf 	= new clan_buffer_t;
	# get clan informations
	$oClanBuf = $cClan->GetClanData( $iClanId );
	*/
	
	$cpt = new PermissionTree();
	$cpt->SetPermissionFile( EGLFILE_PERMISSIONTREE );
	$cpt->CreateTree( 'clan');		# read clan permission-tree
	$aCPL = $cpt->GetConstNameArray(); # receive a list of all permissions
		
	
	$gl_oVars->cTpl->assign( 'cpl', $aCPL );		#cpl => Clan Permission List

	##
	# Clan exists ?
	## 
	if( $oClan )
	{

		# Sort members to right clan-structure
		$aClanMembers = array();
		for( $c=0; $c < sizeof($aCPL); $c++ )  
		{
			$aClanMembers [$c] = array();
			for( $i=0; $i < sizeof($aTmpClanMembers); $i++ )
				if( $aCPL[$c]->const == $aTmpClanMembers[$i]->permissions )
					$aClanMembers [$c][sizeof($aClanMembers [$c])] = $aTmpClanMembers[$i];
		}//for

	
		# create necessary game buffer
		$aGamesPool = $cGamePool->GetGameList( db_create_array_string($aGameIdPool) );
		$gl_oVars->cTpl->assign( 'games_pool',	$aGamesPool );
		
		# create comment manage object for members
		$cComments = new Comments( $gl_oVars->cDBInterface, $GLOBALS['g_egltb_clan_comments'], 'clan_id' );
	
	
		#----------------------------------------------------
		# comment input detected ?
		#----------------------------------------------------
		if( Isset( $_POST['comment_text'] ) &&
			strlen($_POST['comment_text']) > 0 &&
			$gl_oVars->bLoggedIn )
		{
			$msg_obj = array( 	'clan_id' 	=> $iClanId,
								'author_id' => $gl_oVars->oMemberData->id,
								'text' 		=> $_POST['comment_text'],
								'created' 	=> EGL_TIME
							);
		
			# try to create obj
			if( $cComments->CreateComment($msg_obj) )
			{
				# successful
				PageNavigation::Location( $gl_oVars->sURLFile.'?page='.$gl_oVars->sURLRealPage.'&clan_id='.$iClanId.'&comment=show' );
			}
			
		}#/if

		$aClanComments			= NULL;
		$iClanCommentCounter  	= -1;
	
		# get comment buffer
		if( $_GET['comment'] == 'write' ||
			$_GET['comment'] == 'show' )
		{
			# try to catch the comments of current displayed member
			$aClanComments = $cComments->GetComments( (int)$iClanId );
			$iClanCommentCounter = sizeof($aClanComments);
		}
		
		# counter already read, else => read
		if( $iClanCommentCounter == -1 )
			$iClanCommentCounter = $cComments->GetCommentsCount( (int)$iClanId );
			
		
		# save data as a var into template
		$gl_oVars->cTpl->assign( 'comments',		$aClanComments ); 
		$gl_oVars->cTpl->assign( 'comment_count', 	$iClanCommentCounter );

		
		
		###########################################
		# take member 0 for clan informations
		###########################################
		/*
			ATTENTION: 
			----------
			
			Evt. kann man das in ein array schreiben und im template auslesen lasen !!!
		*/
		
		
				
		# teams
		/*
			DESCRiPTION:
			----------------
			Da die daten als team/-clan daten vorliegen muss die 'clan_id' in 'id' gespeichert werden
		*/
		
		
		
		$gl_oVars->cTpl->assign( 'clan',  			$oClan );
		$gl_oVars->cTpl->assign( 'clan_members',	$aClanMembers );
		$gl_oVars->cTpl->assign( 'clan_teams',		$aTeams );
		
		
		$gl_oVars->cTpl->assign( 'countries', $cCountry->GetCountries() );
		
	
	}
	else
	{
		$gl_oVars->cTpl->assign( 'msg_type', 	'error' );
		$gl_oVars->cTpl->assign( 'msg_title', 	'Fehler' );
		$gl_oVars->cTpl->assign( 'msg_text', 	'Der Clan konnte nicht gefunden werden.' );
	}



	#--------------------------------------
	# save constants to tpl
	#--------------------------------------
	
?>