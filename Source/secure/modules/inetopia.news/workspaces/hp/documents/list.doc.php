<?php
	global $gl_oVars;

	
	# declare/define classes / obejcts	
	$cNews		= NULL;
	$cNews		= new News( $gl_oVars->cDBInterface );

	
	$aNews  = array();
	
	# fetch data from db
	$aNews 	= News::SortDaily( $cNews->GetNews( 0, 25 ) );
	
	# tpl
	$gl_oVars->cTpl->assign( 'news_sections', $aNews );
?>