<?php
	global $gl_oVars;
	
	# set members per page
	$members_per_page	= 50;
	
	$limit_start		= (int)$_GET['pos'];
	$limit_cnt			= $members_per_page;
	$aMembers			= array();
	$order				= $_GET['order'];
	$order_type			= $_GET['order_type'];

	// check input
	if( strlen($order) == 0 ) $order = " id ";
	if( $order_type != 'asc' && $order_type != 'desc' ) $order_type = ' desc ';
	
	$numMembers = $gl_oVars->cMember->GetNumMembers();
	
	if( $_GET['a'] == "listall" )
	{
		# fetch memberdata from
		$aMembers = $gl_oVars->cMember->GetMemberlist('', $order, $order_type  );
		//$members_per_page = $numMembers;
	}
	else if( $_GET['a'] == 'search' )
	{
		$aSearchObj = array();
		
		if( strlen($_POST['search_id']) > 0 )$aSearchObj['id']				= $_POST['search_id'];
		if( strlen($_POST['search_email']) > 0 )$aSearchObj['email']		= $_POST['search_email'];
		if( strlen($_POST['search_nickname']) > 0 )$aSearchObj['nick_name']	= $_POST['search_nickname'];
		
		// set standard filter
		$filter = '$VAR=\'$VALUE\'';		
		if( $_POST['similar_filter'] == 'yes' ) $filter = 'INSTR($VAR,\'$VALUE\')';
		
		$where_clausel = $gl_oVars->cDBInterface->Create_WHERE_String($filter,$aSearchObj);
		if( strlen($where_clausel) > 0 ) $where_clausel = " WHERE {$where_clausel}";

		$aMembers = $gl_oVars->cMember->GetMemberlist( $where_clausel, $order, $order_type );
	}//if
	else
	{
		# fetch memberdata from
		$aMembers = $gl_oVars->cMember->GetLimitedMemberlist( $limit_start, $limit_cnt, $order, $order_type );
	}//if

	
	$num_pages	= ($numMembers/$members_per_page);
	if( !is_int($num_pages) ) $num_pages = ((int)$num_pages)+1;	
	if( $limit_start == 0 ) $curr_page=0;
	else $curr_page = (int)($limit_start/$members_per_page);
	
	

	$gl_oVars->cTpl->assign( 'members_per_page', $members_per_page );
	$gl_oVars->cTpl->assign( 'num_pages', $num_pages );
	$gl_oVars->cTpl->assign( 'curr_page', $curr_page );
	
	$gl_oVars->cTpl->assign( 'num_members', $numMembers );
	$gl_oVars->cTpl->assign( 'members', $aMembers );

?>