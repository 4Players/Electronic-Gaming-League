<?php
	global $gl_oVars;


	$cTeam = new Team( $gl_oVars->cDBInterface );
	
	
	# set members per page
	$teams_per_page	= 30;
	
	
	$limit_start		= (int)$_GET['pos'];
	$limit_cnt			= $teams_per_page;
	
	
	# fetch memberdata from
	$aTeams = $cTeam->GetLimitedTeamlist( $limit_start, $limit_cnt, ' teams.created ', ' DESC ' );
	$numTeams = $cTeam->GetNumTeams();


	$num_pages	= ($numTeams/$teams_per_page);
	if( !is_int($num_pages) ) $num_pages = ((int)$num_pages)+1;	
	if( $limit_start == 0 ) $curr_page=0;
	else $curr_page = (int)($limit_start/$teams_per_page);
	

	$gl_oVars->cTpl->assign( 'teams_per_page', $teams_per_page );
	$gl_oVars->cTpl->assign( 'num_pages', $num_pages );
	$gl_oVars->cTpl->assign( 'curr_page', $curr_page );
	
	
	$gl_oVars->cTpl->assign( 'num_teams', $numTeams );
	$gl_oVars->cTpl->assign( 'teams', $aTeams );
?>