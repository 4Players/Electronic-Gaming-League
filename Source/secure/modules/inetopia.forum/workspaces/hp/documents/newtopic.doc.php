<?php
	global $gl_oVars;
	
	$iForumId		= (int)$_GET['forum_id'];
	$iPostId		= (int)EGL_NO_ID;
	$iTopicId		= (int)EGL_NO_ID;
	if( $iForumId == 0 ) $iForumId = EGL_NO_ID;

	// declare objects	
	$cForums 		= new EGLForums( $gl_oVars->cDBInterface );
	if( $iForumId != EGL_NO_ID ) $oForum = $cForums->FetchForum( $iForumId );
	
	
	
	if( $_GET['a']	== 'go' && $oForum &&
		strlen($_POST['title']) > 0 &&
		($gl_oVars->iMemberId > 0 || strlen($_POST['username']) > 0) &&
		strlen($_POST['text']) > 0
		)
	{
		
		$iPostId = -1;
		$topic_array	= array(	'forum_id'	=> (int)$iForumId,
									'member_id'	=> (int)$gl_oVars->iMemberId,
									'username'	=> trim($_POST['username']),
									'title'		=> trim($_POST['title']),
									'changed'	=> (int)EGL_TIME,
									'created'	=> (int)EGL_TIME,
								);
		$iTopicId = $cForums->NewTopic( $topic_array );
		if( $iTopicId > 0 ){
			// get insert-id
			$post_array		= array(	'topic_id'	=> (int)$iTopicId,
										'member_id'	=> (int)$gl_oVars->iMemberId,
										'username'	=> trim($_POST['username']),
										'title'		=> trim($_POST['title']),
										'text'		=> trim($_POST['text']),
										'created'	=> (int)EGL_TIME,
									);
			$iPostId = $cForums->NewTopicPost( $post_array );
			
			$cForums->UpdateTopic( array( 'last_post_id' => $iPostId), $iTopicId );
			$cForums->UpdateForum( array( 'last_topic_id' => $iTopicId), $iForumId );
			
			// update forum
			$cForums->UpdateForum( array( 'posts' => $oForum->posts+1), $oForum->id );
			$cForums->UpdateForum( array( 'topics' => $oForum->topics+1), $oForum->id );
			
			
			PageNavigation::Location( $gl_oVars->sURLFile.'?page='.$gl_oVars->sModuleId.':showtopic&topic_id='.$iTopicId );
		}
		
		// last topic_id for Forum
		// last post_id for Topic
	}
	
	
	// fetch forum-path
	$aForumPath = $cForums->GetPath( $oForum->id );
	$gl_oVars->cTpl->assign( 'forum_path', $aForumPath );	
	$gl_oVars->cTpl->assign( 'forum', $oForum );
?>