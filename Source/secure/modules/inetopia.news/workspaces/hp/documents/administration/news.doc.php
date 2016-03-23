<?php
	global $gl_oVars;

	$iNewsId	=(int)$_GET['news_id'];

	
	# fetch news data
	$cNews = new CNews( $gl_oVars->cDBInterface );
	
	
	# ----------------------------------------------
	# go action
	# ----------------------------------------------
	if( $_GET['a'] == 'go' )
	{
		$update_obj = NULL;
		
		$update_obj->title 		= $_POST['news_title'];
		$update_obj->subject 	= $_POST['news_subject'];
		$update_obj->text 		= $_POST['news_text'];
				
		# execute update
		
		if( $cNews->SetNewData( $update_obj, $iNewsId ) )
		{
			$gl_oVars->cTpl->assign( 'success',  	true );
			$gl_oVars->cTpl->assign( 'msg_type',  	'success' );
			$gl_oVars->cTpl->assign( 'msg_title',  	'Geändert' );
			$gl_oVars->cTpl->assign( 'msg_text',  	'success' );
			
		}
	}//if
	
	$oNews = $cNews->GetSingleNews( $iNewsId );
	$gl_oVars->cTpl->assign( 'news', $oNews );
?>