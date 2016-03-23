<?php
	global $gl_oVars;
	
	$iForumId		= (int)$_GET['forum_id'];
	if( $iForumId == 0 ) $iForumId = EGL_NO_ID;

	// declare objects	
	$cForums 			= new EGLForums( $gl_oVars->cDBInterface );
	
	// fetch data
	$aTopics			= array();
	$aForums 			= $cForums->FetchForums( $iForumId );
	$oForum				= $cForums->FetchForum( $iForumId );
	
	if( $iForumId != EGL_NO_ID ){
		$aTopics = $cForums->FetchForumTopics( $iForumId );
	}
	
	
	$gl_oVars->cTpl->assign( 'forums', $aForums );
	$gl_oVars->cTpl->assign( 'topics', $aTopics );
	
	if( !$oForum ){
		$gl_oVars->cTpl->assign( 'TOPICS_DISABLED', true );
	} else{
		$gl_oVars->cTpl->assign( 'forum', $oForum );
	}

	
	$aPath = $cForums->GetPath( $iForumId );
	$gl_oVars->cTpl->assign( 'forum_path', $aPath );
?>