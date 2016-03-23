<?php
	global $gl_oVars;

	$_GET['comment'] = "write";

	#
	$iNewsId	= (int)$_GET['news_id'];
	
	# declare/define classes / obejcts	
	$cNews 		= NULL;
	$cNews		= new News( $gl_oVars->cDBInterface );

	
	
	#$aComments = $cNews->GetNewsComments($iNewsId);
	$oNews = $cNews->GetSingleNews($iNewsId);
	#---------------------------------------------
	$aSectionNews = $cNews->GetCategoryNews( $oNews->cat_id, 100 );
	
	
	
	# create comment manage object for members
	$cComments = & new Comments( $gl_oVars->cDBInterface, $GLOBALS['g_egltb_news_comments'], "news_id" );
	#----------------------------------------------------
	# comment input detected ?
	#----------------------------------------------------
	if( Isset( $_POST['comment_text'] ) &&
		strlen($_POST['comment_text']) > 0 &&
		$gl_oVars->bLoggedIn )
	{
		$msg_obj = NULL;
		$msg_obj->news_id 	= $oNews->id;
		$msg_obj->author_id = $gl_oVars->oMemberData->id;
		$msg_obj->text 		= $_POST['comment_text'];	
		$msg_obj->created 	= EGL_TIME;
		
		# try to create obj
		if( $cComments->CreateComment($msg_obj) )
		{
			# successful
			PageNavigation::Location( $gl_oVars->sURLFile."?page=".$gl_oVars->sModuleId.":".$gl_oVars->sURLPage."&news_id=".$iNewsId );
		}//if
			
	}#/if

	$aNewsComments	= NULL;
	$iNewsCounter  = -1;

	# get comment buffer
	if( $_GET['comment'] == 'write' ||
		$_GET['comment'] == 'show' )
	{
		# try to catch the comments of current displayed member
		$aNewsComments = $cComments->GetComments( $oNews->id );
		$iNewsCounter = sizeof($aNewsComments);
	}
		
	# counter already read, else => read
	if( $iNewsCounter == -1 )
		$iNewsCounter = $cComments->GetCommentsCount( $oNews->id );	
	

	
	$gl_oVars->cTpl->assign( 'news',  $oNews );
	$gl_oVars->cTpl->assign( 'sectionnews',  $aSectionNews );
	$gl_oVars->cTpl->assign( 'comments',  $aNewsComments );
	$gl_oVars->cTpl->assign( 'num_comments',  $iNewsCounter );
?>