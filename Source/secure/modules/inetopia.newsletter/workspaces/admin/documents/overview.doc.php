<?php
	global $gl_oVars;
	
	#---------------------------------------
	# Running 
	#---------------------------------------
	
	#  create newsletter object
	$cNewsletter = new InetNewsletter( $gl_oVars->cDBInterface, "egl_inetopia_newsletter" );
	
	
	$stats->num_mails = (int)$cNewsletter->GetNumMails();
	$stats->num_sent_mails = (int)$cNewsletter->GetNumSentMails();
	$stats->num_drafts = (int)$cNewsletter->GetNumNewsletterDrafts();
	$gl_oVars->cTpl->assign( 'stats',  $stats );
	
?>