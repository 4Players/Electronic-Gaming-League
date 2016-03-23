<?php
	global $gl_oVars;
	
	$iTopicId		= (int)$_GET['topic_id'];

	// declare objects	
	$cForums 		= new EGLForums( $gl_oVars->cDBInterface );
	
	// fetch data
	$oTopic				= $cForums->FetchTopic( $iTopicId );
	$aTopicPosts		= $cForums->FetchTopicPosts( $iTopicId );
	$oForum				= $cForums->FetchForum( $oTopic->forum_id );
	
	$cForums->UpdateTopic( array( 'hits' => $oTopic->hits+1), $iTopicId );

	
	$aPath = $cForums->GetPath( $oForum->id );
	$gl_oVars->cTpl->assign( 'forum_path', 	$aPath );	
	
	$gl_oVars->cTpl->assign( 'topic_posts', $aTopicPosts );
	$gl_oVars->cTpl->assign( 'topic', 		$oTopic );
	$gl_oVars->cTpl->assign( 'forum', 		$oForum );
?>