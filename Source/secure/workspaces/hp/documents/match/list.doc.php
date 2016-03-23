<?php
	global $gl_oVars;


	# get current activated cmods ..
	$aModules = $gl_oVars->cModuleManager->GetActivatedModules();
	
	if( !isset($_GET['show'])) $_GET['show'] = 'running';
	
	

	$part_id 	= EGL_NO_ID;
	$part_type 	= EGL_NO_ID;
	

	# ---------------------------------------
	# Team ?
	# ---------------------------------------
	if( Isset( $_GET['team_id'] ) )
	{
		$part_id 	= $_GET['team_id'];
		$part_type 	= PARTTYPE_TEAM;
		
		$gl_oVars->cTpl->assign( '_TEAM_ID_', "&team_id=".(int)$_GET['team_id']."" );
	}
	# ---------------------------------------
	# Myself ??
	# ---------------------------------------
	else
	{
		$part_id 	= $gl_oVars->oMemberData->id;
		$part_type 	= PARTTYPE_MEMBER;
	}
	
	
	# -------------------------------------------
	# fetch match challenge, entrylist
	# -------------------------------------------
	$aEntryList	= array();
	for( $i=0; $i < sizeof($aModules); $i++ )
	{
		$aEntryList[sizeof($aEntryList)] = module_sendmessage( $aModules[$i]->ID, 'entry_list',  $__DATA__, $part_id, $part_type );
	}

	$gl_oVars->cTpl->assign( 'entrylist',	$aEntryList);
	$gl_oVars->cTpl->assign( 'modules',		$aModules);
	
	
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
		
			$gl_oVars->cTpl->assign( 'module', 	$oModule );
			$gl_oVars->cTpl->assign( 'matches', $aMatchList );
			$gl_oVars->cTpl->assign( 'NUM_MATCHES', sizeof($aMatchList) );
		}
		else
		{
		}//if
	}//if isset( $_GET['mid']
	

	
	$gl_oVars->cTpl->assign( 'selected_module', $_GET['mid'] );
	$gl_oVars->cTpl->assign( 'selected_entry', $_GET['entry_id'] );
	
	
	$gl_oVars->cTpl->assign( '_PARTTYPE_MEMBER_', PARTTYPE_MEMBER ); 
	$gl_oVars->cTpl->assign( '_PARTTYPE_TEAM_', PARTTYPE_TEAM ); 
	
	
	$gl_oVars->cTpl->assign( 'participant_type',	$part_type );
	$gl_oVars->cTpl->assign( 'participant_id',		$part_id );
	
?>