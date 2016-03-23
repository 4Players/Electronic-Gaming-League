<?php
	global $gl_oVars;


	$cClan = new Clan( $gl_oVars->cDBInterface );
	
	
	# set members per page
	$clans_per_page	= 30;
	
	
	$limit_start		= (int)$_GET['pos'];
	$limit_cnt			= $clans_per_page;
	
	
	# fetch memberdata from
	$aClans = $cClan->GetLimitedClanlist( $limit_start, $limit_cnt, ' clan_acc.created ', ' DESC ' );
	$numClans = $cClan->GetNumClans();
	
	$num_pages	= ($numClans/$clans_per_page);
	if( !is_int($num_pages) ) $num_pages = ((int)$num_pages)+1;	
	if( $limit_start == 0 ) $curr_page=0;
	else $curr_page = (int)($limit_start/$clans_per_page);
	

	$gl_oVars->cTpl->assign( 'clans_per_page', $clans_per_page );
	$gl_oVars->cTpl->assign( 'num_pages', $num_pages );
	$gl_oVars->cTpl->assign( 'curr_page', $curr_page );
	
	
	
	$gl_oVars->cTpl->assign( 'num_clans', $numClans );
	$gl_oVars->cTpl->assign( 'clans', $aClans );
?>