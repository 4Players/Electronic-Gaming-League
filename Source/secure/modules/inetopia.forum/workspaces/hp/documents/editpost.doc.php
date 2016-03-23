<?php
	global $gl_oVars;
	
	$iPostId		= $_GET['post_id'];

	// declare objects	
	$cForums 		= new EGLForums( $gl_oVars->cDBInterface );

	// fetch data
	$oPost			= $cForums->FetchDetailedPost( $iPostId );
	$oTopPost		= $cForums->GetTopPost( $oPost->topic_id );
	$bHeadPost		= false;
	$oTopic 		= $cForums->FetchTopic( $oPost->topic_id );
	
	// setting up the headpost
	if( $oTopPost->id == $oPost->id ) $bHeadPost = true;
	
	#========================================================================
	#========================================================================
	# ACTIONS
	#========================================================================
	#========================================================================
	
	# ----------------------------------------------------
	#
	# ----------------------------------------------------

	if( $_GET['a'] == 'edit' ){
		
		// update topic-post
		$obj = array( 	'username'	=> trim($_POST['username']),
						'title'		=> trim($_POST['title']),
						'text'		=> trim($_POST['text']),
					);
		$cForums->UpdateTopicPost( $obj, $iPostId );

		// update topic : this topic -> first post?
		if( $oTopPost->id == $oPost->id ){
			$obj = array(	'title'		=> trim($_POST['title']) );
			$cForums->UpdateTopic( $obj, $oPost->topic_id );
		}
		//PageNavigation::Location( $gl_oVars->sURLFile.'?page='.$gl_oVars->sModuleId.':showtopic&topic_id='.$oPost->topic_id );
		PageNavigation::Location( $gl_oVars->sURLFile.'?page='.$gl_oVars->sModuleId.':editpost&post_id='.$oPost->id );
	}
	# ----------------------------------------------------
	# DELETE POST
	# ----------------------------------------------------
	if( $_GET['a'] == 'settype' ){
		
		$a_change = array();
		
		if( $_GET['type'] == 'normal' ) $a_change['type'] = EGL_TOPICTYPE_NORMAL;
		if( $_GET['type'] == 'notice' ) $a_change['type'] = EGL_TOPICTYPE_NOTICE;
		if( $_GET['type'] == 'important' ) $a_change['type'] = EGL_TOPICTYPE_IMPORTANT;
		
		$cForums->UpdateTopic( $a_change, $oPost->topic_id );
		PageNavigation::Location( $gl_oVars->sURLFile.'?page='.$gl_oVars->sModuleId.':editpost&post_id='.$oPost->id );
	}
		
	# ----------------------------------------------------
	# DELETE POST
	# ----------------------------------------------------
	if( $_GET['a'] == 'delpost' ){
				
	}
	# ----------------------------------------------------
	# DELETE TOPIC
	# ----------------------------------------------------
	if( $_GET['a'] == 'deltopic' && $bHeadPost){
				
	}
	# ----------------------------------------------------
	# MOVE TOPIC TO FORUM, LEAVE SHADOW
	# ----------------------------------------------------
	if( $_GET['a'] == 'move' && $bHeadPost && $oPost->forum_id != (int)$_GET['new_forumid'] ){
		if( $_GET['shadow'] == 'yes' ){
			// create shadow in old forum
			$shadow_topic	= array(	'forum_id'			=> (int)$oTopic->forum_id,
										'link'				=> (int)1,
										'linked_topicid' 	=> $oTopic->id,
										'member_id'			=> (int)$oTopic->member_id,
										'username'			=> $oTopic->username,
										'title'				=> $oTopic->title,
										'hits'				=> $oTopic->hits,
										'posts'				=> $oTopic->posts,
										'last_post_id'		=> $oTopic->last_post_id,
										'changed'			=> $oTopic->changed,
										'created'			=> $oTopic->created,
								);
			if( $cForums->NewTopic( $shadow_topic ) )
			{
				// created
			}
		}
		$iNewForumId = (int)$_GET['new_forumid'];
		if( $iNewForumId > 0 )
		{
			$cForums->UpdateTopic( array('forum_id'=>(int)$iNewForumId ), $oPost->topic_id );
			//PageNavigation::Location( $gl_oVars->sURLFile.'?page='.$gl_oVars->sModuleId.':showtopic&topic_id='.$oPost->topic_id );
			PageNavigation::Location( $gl_oVars->sURLFile.'?page='.$gl_oVars->sModuleId.':editpost&post_id='.$oPost->id );
		}
	}
	# ----------------------------------------------------
	# LOCK TOPIC
	# ----------------------------------------------------
	if( $_GET['a'] == 'lock' ){
		$cForums->UpdateTopic( array('locked'=>(int)true ), $oPost->topic_id );
		PageNavigation::Location( $gl_oVars->sURLFile.'?page='.$gl_oVars->sModuleId.':editpost&post_id='.$oPost->id );
	}
	# ----------------------------------------------------
	# UNLOCK TOPIC
	# ----------------------------------------------------
	if( $_GET['a'] == 'unlock' ){
		$cForums->UpdateTopic( array('locked'=>(int)false ), $oPost->topic_id );
		PageNavigation::Location( $gl_oVars->sURLFile.'?page='.$gl_oVars->sModuleId.':editpost&post_id='.$oPost->id );
	}
	
	
	#--------------------------------------------------
	# FORUM, configure, fetch & generate forum-tree
	#--------------------------------------------------
	$cForums 	= new EGLForums( $gl_oVars->cDBInterface );
	$aTree 		= new tree_node_t;
	
	$aTree->oProperties->name = "FORUM ROOT";
	$cForums->SetTempForumList( $cForums->FetchAllForums() );
	$cForums->generate_tree( $aTree, -1, -1 );
	
	// fetch forum-path
	$aForumPath = $cForums->GetPath( $oTopic->forum_id );
	$gl_oVars->cTpl->assign( 'forum_path', $aForumPath );	
	$gl_oVars->cTpl->assign( 'forum', $cForums->FetchForum($oTopic->forum_id) );	
	
	
	$gl_oVars->cTpl->assign( 'forumtree', $aTree );	
	$gl_oVars->cTpl->assign( 'post', $oPost );
	$gl_oVars->cTpl->assign( 'topic', $oTopic );
	if( $bHeadPost ) $gl_oVars->cTpl->assign( 'head_post', true );
?>