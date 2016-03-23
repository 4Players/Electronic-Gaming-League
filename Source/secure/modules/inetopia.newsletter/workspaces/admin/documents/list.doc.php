<?php
	global $gl_oVars;

	$iNewsletterMailId		= (int)$_GET['mail_id'];
	#---------------------------------------
	# Running 
	#---------------------------------------
	
	#  create newsletter object
	$cNewsletter = new InetNewsletter( $gl_oVars->cDBInterface, "egl_inetopia_newsletter" );
	
	
	if( Isset( $_GET['mail_id']) && $_GET['a'] == 'delete' )
	{
		$cNewsletter->DeleteMail( $iNewsletterMailId );
	}
	

	$news_pos 		= (int)$_GET['page_pos'];
	$num_news 		= $cNewsletter->GetNumMails();
	$news_per_page 	= 20;
	$news_num_page_shown = 5;
	$url		   	= $g_UrlFile."page=".$g_Page;
	
	//$gl_oVars->cTpl->assign( 'slideshow_str', CreateSlideShow( $news_pos, $num_news, $news_per_page, $news_num_page_shown, $url ) );
	
	
	$aMails = $cNewsletter->GetAlleMails(); //( 0, 0, $news_pos*$news_per_page, $news_per_page );

	$gl_oVars->cTpl->assign( 'newsletter', $aMails );
	
?>