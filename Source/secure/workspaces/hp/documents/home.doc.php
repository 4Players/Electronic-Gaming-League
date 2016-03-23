<?php
	global $gl_oVars;

	
	$aNews = module_sendmessage( module_getid("INETOPIA_NEWS"), 'get_overview_news', $__DATA__, 0, 50 );
	$iRootId = module_sendmessage( module_getid("INETOPIA_NEWS"), 'get_settings', $__DATA__, 'cat_root_id' );

	$aTopNews = array();
	for( $i=0; $i < sizeof($aNews); $i++ )
	{
		if( $aNews[$i]->game_id || $aNews[$i]->cat_id == $iRootId )
		{
			$aTopNews[sizeof($aTopNews)] = $aNews[$i];
		}
	}

	$news_left = array();
	$news_right= array();
	
	if( sizeof($aTopNews) > 20 )
	{
		$div_2 = (int)(sizeof($aTopNews)/2);
	
		for( $i=0; $i < $div_2; $i++ )
		{
			$news_left[sizeof($news_left)] = $aTopNews[$i];
		}	
		for( $i=0; $i < sizeof($aNews)-$div_2; $i++ )
		{
			$news_right[sizeof($news_right)] = $aTopNews[$div_2+$i];
		}
	}else
	{
		$news_left = $aTopNews;
	}
	

	# tpl
	$gl_oVars->cTpl->assign( 'news_left', $news_left );
	$gl_oVars->cTpl->assign( 'news_right', $news_right );
	$gl_oVars->cTpl->assign( 'half_news_cnt', $div_2);

	$gl_oVars->cTpl->assign( 'news', $aTopNews );
	//$gl_oVars->cTpl->assign( 'GLOBAL_COLOR', 'grey' );
?>