<?php
	global $gl_oVars;
	
	$iTopicId		= (int)$_GET['topic_id'];
	if( $iForumId == 0 ) $iForumId = (int)EGL_NO_ID;

	// declare objects	
	$cForums 		= new EGLForums( $gl_oVars->cDBInterface );

	// fetch data
	$oTopic			= $cForums->FetchTopic( $iTopicId );
	$oForum			= $cForums->FetchForum( $oTopic->forum_id );
	
	
	if( $_GET['a']	== 'go' &&
		($gl_oVars->iMemberId > 0 || strlen($_POST['username']) > 0) &&
		strlen($_POST['text']) > 0 )
	{
		#-------------------------------------------
		#
		if( $iTopicId > 0 )
		{
			// get insert-id
			$post_array		= array(	'topic_id'	=> (int)$iTopicId,
										'member_id'	=> (int)$gl_oVars->iMemberId,
										'username'	=> trim($_POST['username']),
										'title'		=> trim($_POST['title']),
										'text'		=> trim($_POST['text']),
										'created'	=> (int)EGL_TIME,
									);
			$iPostId = $cForums->NewTopicPost( $post_array );
			
			// define update changes
			$aTopicChanges	= array( 	'last_post_id' 	=> (int)$iPostId,
										'posts' 		=> (int)($oTopic->posts+1),
										'changed' 		=> (int)EGL_TIME,
									 );
			$cForums->UpdateTopic( $aTopicChanges, $iTopicId );
			$cForums->UpdateLinkedTopics( $aTopicChanges, $iTopicId );
			
			// update forum
			$cForums->UpdateForum( array( 'posts' => $oForum->posts+1), $oForum->id );
			PageNavigation::Location( $gl_oVars->sURLFile.'?page='.$gl_oVars->sModuleId.':showtopic&topic_id='.$iTopicId );
			
		}//if
	}//if
	
	// fetch forum-path
	$aForumPath = $cForums->GetPath( $oForum->id );
	$gl_oVars->cTpl->assign( 'forum_path', $aForumPath );	
	$gl_oVars->cTpl->assign( 'forum', $oForum );	
		
?>