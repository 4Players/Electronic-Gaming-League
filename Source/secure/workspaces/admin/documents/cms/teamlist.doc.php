<?php
	global $gl_oVars;
	
	
	$teams_per_page		= 50; # set members per page
	$limit_start		= (int)$_GET['pos'];
	$limit_cnt			= $teams_per_page;
	$order				= $_GET['order'];
	$order_type			= $_GET['order_type'];

	// check input
	if( strlen($order) == 0 ) $order = "id";
	if( $order_type != 'asc' && $order_type != 'desc' ) $order_type = ' desc ';
	
	
	$aTeams	  			= array();
	
	
	# declare classes 
	$cCountry = new Country( $gl_oVars->cDBInterface );
	$cTeam = new Team( $gl_oVars->cDBInterface );
	

	// get number of teams in db
	$numTeams = $cTeam->GetNumTeams();
	

	if( $_GET['a'] == "listall" )
	{
		# fetch memberdata from
		$aTeams = $cTeam->GetDetailedTeamlist();
		//$teams_per_page = $numTeams;
	}
	else if( $_GET['a'] == 'search' )
	{
		$aSearchObj = array();
		
		if( strlen($_POST['search_id']) > 0 )$aSearchObj['teams.id']			= $_POST['search_id'];
		if( strlen($_POST['search_name']) > 0 )$aSearchObj['teams.name']		= $_POST['search_name'];
		if( strlen($_POST['search_tag']) > 0 )$aSearchObj['teams.tag']			= $_POST['search_tag'];
		if( strlen($_POST['search_clanid']) > 0 )$aSearchObj['teams.clan_id']	= $_POST['search_clanid'];
		
	
		// set standard filter
		$filter = '$VAR=\'$VALUE\'';		
		if( $_POST['similar_filter'] == 'yes' ) $filter = 'INSTR($VAR,\'$VALUE\')';
		
		$where_clausel = $gl_oVars->cDBInterface->Create_WHERE_String($filter,$aSearchObj);
		if( strlen($where_clausel) > 0 ) $where_clausel = " WHERE {$where_clausel}";
		$aTeams = $cTeam->GetDetailedTeamlist( $where_clausel, $order, $order_type );
	}//if
	else
	{
		# fetch memberdata from
		$aTeams = $cTeam->GetLimitedTeamlist( $limit_start, $limit_cnt, $order, $order_type );
	}
	
	
	$num_pages	= ($numTeams/$teams_per_page);
	if( !is_int($num_pages) ) $num_pages = ((int)$num_pages)+1;	
	if( $limit_start == 0 ) $curr_page=0;
	else $curr_page = (int)($limit_start/$teams_per_page);
	

	$gl_oVars->cTpl->assign( 'teams_per_page', $teams_per_page );
	$gl_oVars->cTpl->assign( 'num_pages', $num_pages );
	$gl_oVars->cTpl->assign( 'curr_page', $curr_page );
	
		
	$gl_oVars->cTpl->assign( 'countries',	$cCountry->GetCountries() );
	$gl_oVars->cTpl->assign( 'teamlist',	$aTeams );
	$gl_oVars->cTpl->assign( 'num_teams',	$numTeams );
	
?>