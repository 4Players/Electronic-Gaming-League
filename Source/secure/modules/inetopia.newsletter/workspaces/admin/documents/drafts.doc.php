<?php
	global $gl_oVars;

	#---------------------------------------
	# Running 
	#---------------------------------------
	
	#  create newsletter object
	$cNewsletter = new InetNewsletter( $gl_oVars->cDBInterface, "egl_inetopia_newsletter" );
	
	$iDraftId	= (int)$_GET['draft_id'];
	$oDraft		= NULL;
	$aDraftList	= array();
	
	if( Isset( $_GET['draft_id'] ))
	{
		$oDraft = $cNewsletter->GetNewsletterDraft( $iDraftId );
		if( $oDraft )
			$gl_oVars->cTpl->assign( "draft", $oDraft );
	}
	else
	{
		$aDraftList	= $cNewsletter->GetNewsletterDrafts();
		if( !$aDraftList ) $aDraftList = array();
		$gl_oVars->cTpl->assign( "draftlist", $aDraftList );
	}
	
	
	##########################################################
	# ACTIONS
	##########################################################
	if( $_GET['a']	== "delete" )
	{
		$cNewsletter->DeleteDraft($iDraftId);
		
		$gl_oVars->cTpl->assign( "draft_deleted", true );
	}
?>