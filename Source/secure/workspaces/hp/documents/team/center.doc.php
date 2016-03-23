<?php
	global $gl_oVars;
	
	$iTeamId 	= (int)$_GET['team_id'];
	
	# classes
	$cTeam	= new Team( $gl_oVars->cDBInterface );


	# fetch data
	$oTeam = $cTeam->GetTeamByMember( $iTeamId, $gl_oVars->oMemberData->id );


	
	$aModules = $gl_oVars->cModuleManager->GetActivatedModules();
	
	# fetch each links
	$aLinks = array();
	for( $i=0; $i < sizeof($aModules); $i++ )
	{
		$aTmpLinks = array();
		module_sendmessage( $aModules[$i]->ID, 'get_team_links', $aTmpLinks/*OUTPUT*/, $iTeamId  );
	
		
		if( sizeof($aTmpLinks) > 0 )
		{
			$pLink = & $aLinks[sizeof($aLinks)];
			$pLink = new module_tpl_links_t;
			$pLink->aLinks 		= $aTmpLinks;
			$pLink->sCaption 	= $aModules[$i]->sName;
			
		}//if
	}//for

	
	# tpl
	$gl_oVars->cTpl->assign( 'team', 				$oTeam );
	$gl_oVars->cTpl->assign( 'modules_links', 		$aLinks );

?>