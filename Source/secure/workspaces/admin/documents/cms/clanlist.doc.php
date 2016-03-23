<?php
	global $gl_oVars;
	$clans_per_page	= 50; # set members per page
	$aClans	  = array();
	
	
	$limit_start		= (int)$_GET['pos'];
	$limit_cnt			= $clans_per_page;
	$order				= $_GET['order'];
	$order_type			= $_GET['order_type'];

	// check input
	if( strlen($order) == 0 ) $order = "id";
	if( $order_type != 'asc' && $order_type != 'desc' ) $order_type = ' desc ';
	
	
	$cCountry = new Country( $gl_oVars->cDBInterface );
	$cClan = new Clan( $gl_oVars->cDBInterface );

	$numClans = $cClan->GetNumClans();
	
	
	if( $_GET['a'] == "listall" )
	{
		# fetch memberdata from
		$aClans = $cClan->GetDetailedClanlist();
		echo mysql_error();
		//$clans_per_page = $numClans;
	}
	else if( $_GET['a'] == 'search' )
	{
		$aSearchObj = array();
		
		if( strlen($_POST['search_id']) > 0 )	$aSearchObj['clans.id']		= $_POST['search_id'];
		if( strlen($_POST['search_name']) > 0 )	$aSearchObj['clans.name']	= $_POST['search_name'];
		if( strlen($_POST['search_tag']) > 0 )	$aSearchObj['clans.tag']	= $_POST['search_tag'];
		
		// set standard filter
		$filter = '$VAR=\'$VALUE\'';		
		if( $_POST['similar_filter'] == 'yes' ) $filter = 'INSTR($VAR,\'$VALUE\')';
		
		$where_clausel = $gl_oVars->cDBInterface->Create_WHERE_String($filter,$aSearchObj);
		if( strlen($where_clausel) > 0 ) $where_clausel = " WHERE {$where_clausel}";
		$aClans = $cClan->GetDetailedClanlist( $where_clausel, $order, $order_type );
	
	}
	else
	{
		
		# fetch memberdata from
		$aClans = $cClan->GetLimitedClanlist( $limit_start, $limit_cnt, $order, $order_type );
	}
	
	
	$num_pages	= ($numClans/$clans_per_page);
	if( !is_int($num_pages) ) $num_pages = ((int)$num_pages)+1;	
	if( $limit_start == 0 ) $curr_page=0;
	else $curr_page = (int)($limit_start/$clans_per_page);
	

	$gl_oVars->cTpl->assign( 'clans_per_page', $clans_per_page );
	$gl_oVars->cTpl->assign( 'num_pages', $num_pages );
	$gl_oVars->cTpl->assign( 'curr_page', $curr_page );
	
	
	$gl_oVars->cTpl->assign( 'countries',	$cCountry->GetCountries() );
	$gl_oVars->cTpl->assign( 'clanlist',	$aClans );
	$gl_oVars->cTpl->assign( 'num_clans',	$numClans );
?>