<?php
	global $gl_oVars;


	#-----------------------------------
	# 
	#-----------------------------------	
	$iClanId 	= (int)$_GET['clan_id'];
	$oClan 		= $gl_oVars->cMember->GetClanAccount($iClanId);
	$aClanTeams = NULL;
	
	
	$cClan		= new Clan( $gl_oVars->cDBInterface );
	$cTeam		= new Team( $gl_oVars->cDBInterface );
	
	
	# ------------------
	# data found ?
	# ------------------
	if( $oClan )
	{
		$aClanTeams = $cTeam->GetClanTeams( $iClanId );
		

		$gl_oVars->cTpl->assign( 'clan', $oClan );
		$gl_oVars->cTpl->assign( 'clan_teams',  $aClanTeams );
	}


	

	#------------------------------------------------------------------------
	# Get Team-cMod Link data
	#------------------------------------------------------------------------

	$aCModTeamLinks = array();
	$aCMods = $gl_oVars->cModuleManager->GetActivatedModules();

	for( $t=0; $t < sizeof($aClanTeams); $t++ )
	{
		$pTeamLinks = &$aCModTeamLinks[sizeof($aCModTeamLinks)];
		
		# fetch each links
		for( $i=0; $i < sizeof($aCMods); $i++ )
		{
			$aLinks = array();
			module_sendmessage( $aCMods[$i]->ID, 'get_team_links', $aLinks/*OUTPUT*/, $aClanTeams[$t]->team_clan_id, $aClanTeams[$t]->team_id  );
		
			if( sizeof($aLinks) > 0 )
			{
				$pCModLinks = & $pTeamLinks[sizeof($pTeamLinks)];
				$pCModLinks = new module_tpl_links_t;
				$pCModLinks->aLinks =  $aLinks;
				$pCModLinks->sCaption = $aCMods[$i]->sName;
			
			}//if
		}//for

	}//for
	#----------------------------------------------------------------------------------
	#----------------------------------------------------------------------------------
	
	
	
	# add to tpl
	$gl_oVars->cTpl->assign( 'cmod_links', 	$aCModTeamLinks );
		

	
	?>