<?php
	global $gl_oVars;
	
	# declare classes
	$cMemberHistory		= new MemberHistory( $gl_oVars->cDBInterface );
	$cPM 				= new PM( $gl_oVars->cDBInterface );
	$cOnlineList	 	= new OnlineList( $gl_oVars->cDBInterface );
	$cLogin 			= new Login( $gl_oVars->cDBInterface );
	$cTeam 				= new Team( $gl_oVars->cDBInterface );
	$cClan			 	= new Clan( $gl_oVars->cDBInterface );
	
	# fetch data
	$iTeamId			= (int)$_GET['team_id'];
	$oTeam 				= $cTeam->GetTeamById( $iTeamId );
	# get current activated cmods ..
	$aModules = $gl_oVars->cModuleManager->GetActivatedModules();
	if( !isset($_GET['show'])) $_GET['show'] = 'running';
	
	#------------------------------------------------------------
	# Member exists?
	#------------------------------------------------------------
	if( $oTeam )
	{
		$part_id 	= $iTeamId;
		$part_type 	= PARTTYPE_TEAM;
		
		
		# -------------------------------------------
		# fetch match challenge, entrylist
		# -------------------------------------------
		$aEntryList	= array();
		for( $i=0; $i < sizeof($aModules); $i++ )
		{
			$aEntryList[sizeof($aEntryList)] = module_sendmessage( $aModules[$i]->ID, 'entry_list',  $__DATA__, $part_id, $part_type );
		}
			
		# ---------------------------------------------------------
		# SELECT MATCHES
		# ---------------------------------------------------------
		if( isset( $_GET['mid'] ) )
		{
			# try catching cmod data
			$oModule = $gl_oVars->cModuleManager->GetModule( $_GET['mid'] );
			if( $oModule && $oModule->bActivated )
			{
				# define matchlist
				$matchlist_data = new matchlist_data_t;
				$matchlist_data->entry_id 	= $_GET['entry_id'];
				$matchlist_data->part_type 	= $part_type;
				$matchlist_data->part_id 	= $part_id;
				$matchlist_data->status 	= $_GET['show']; /* all,reported,closed,open  */
				
				# get matchlist
				$aMatchList = module_sendmessage( $_GET['mid'], 'match_list', $matchlist_data, NULL, NULL );
				
				//echo nl2br( print_r( $aMatchList, 1));
			
				$gl_oVars->cTpl->assign( 'module', 		$oModule );
				$gl_oVars->cTpl->assign( 'matches',		$aMatchList );
				$gl_oVars->cTpl->assign( 'NUM_MATCHES',	sizeof($aMatchList) );
			}
			else
			{
			}//if
		}//if isset( $_GET['mid']		
	
		$gl_oVars->cTpl->assign( 'entrylist',			$aEntryList);
		$gl_oVars->cTpl->assign( 'modules',				$aModules);
		$gl_oVars->cTpl->assign( 'selected_module', 	$_GET['mid'] );
		$gl_oVars->cTpl->assign( 'selected_entry', 		$_GET['entry_id'] );
		$gl_oVars->cTpl->assign( "team", 				$oTeam );
	}
?>