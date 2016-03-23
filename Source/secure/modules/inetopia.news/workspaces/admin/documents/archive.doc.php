<?php
	global $gl_oVars;

	$iNewsId	=(int)$_GET['news_id'];

	
	# fetch news data
	$cNews = new News( $gl_oVars->cDBInterface );
	$cMyCategory	= new MyCategory( $gl_oVars->cDBInterface );	
	
	# get root data
	$oCatRoot = $cMyCategory->GenerateTree( -1, -1 );
	
	# start search
	if( $_GET['a'] == 'start_search' )
	{
		
		# collect search data
		list ($day, $month, $year) = explode('.', $_POST['start_date']); 
		list ($hour, $min, $sec) = explode(':', $_POST['start_clock']); 
		$start_timestamp	= mktime( $hour, $min, $sec, $month, $day, $year );
		
		list ($day, $month, $year) = explode('.', $_POST['end_date']);
		list ($hour, $min, $sec) = explode(':', $_POST['end_clock']);
		$end_timestamp	= mktime( $hour, $min, $sec, $month, $day, $year );
		
		
		$iCategoryId 		= (int)$_POST['search_cat_id'];
		$sTitleExtract	 	= $_POST['search_title'];
		$sShortTextExtract 	= $_POST['search_short_text'];
		$sTextExtract 		= $_POST['search_text'];
		
		
		$search_obj = array();
		if( strlen($sTitleExtract) > 0 ) $search_obj['title'] = $sTitleExtract;
		if( strlen($sShortTextExtract) > 0 ) $search_obj['short_text'] = $sShortTextExtract;
		if( strlen($sTextExtract) > 0 ) $search_obj['text'] = $sTextExtract;
	
		# define where clausel
		$where_clausel = $gl_oVars->cDBInterface->Create_WHERE_String( 'instr($VAR,\'$VALUE\')', $search_obj );
		if( strlen($where_clausel) > 0 ) $where_clausel .= " && cat_id={$iCategoryId} ";
		else $where_clausel = " cat_id={$iCategoryId} ";
		$where_clausel = " WHERE {$where_clausel}";
		if( $_POST['search_disable_date'] != 'yes') $where_clausel.= " && release >= $start_timestamp && release <= $end_timestamp ";
		
		
		# create search_string
		$sql_query = " SELECT news.*, members.nick_name AS member_nick_name FROM {$GLOBALS['g_egltb_news']} AS news ".
					 " LEFT JOIN {$GLOBALS['g_egltb_members']} AS members ".
					 " ON news.member_id=members.id ".
					 " $where_clausel ".
					 " ORDER BY release DESC ";
		$aResult = $gl_oVars->cDBInterface->FetchArrayObject( $gl_oVars->cDBInterface->Query( $sql_query ));
		

		# fetch news[cat_id] path
		for( $i=0; $i < sizeof($aResult); $i++ )
			$aResult[$i]->path = $cMyCategory->GetPath( $aResult[$i]->cat_id );
			
		# provide template with data
		$gl_oVars->cTpl->assign( "SEARCH_RESULT", $aResult );
	}
	
	
	$gl_oVars->cTpl->assign( 'categoryroot', $oCatRoot );
?>