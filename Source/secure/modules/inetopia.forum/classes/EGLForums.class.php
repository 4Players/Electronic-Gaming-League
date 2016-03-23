<?php
# ================================ Copyright © 2005-2006 Inetopia, All rights reserved. ==========================
# 
#
# Purpose:
# ================================================================================================================


DBTB::RegisterTB( 'MODULE', 'EGL_FORUMS',					'egl_forums' );
DBTB::RegisterTB( 'MODULE', 'EGL_FORUM_SECTIONS',			'egl_forum_sections' );
DBTB::RegisterTB( 'MODULE', 'EGL_FORUM_TOPICS',				'egl_forum_topics' );
DBTB::RegisterTB( 'MODULE', 'EGL_FORUM_POSTS',				'egl_forum_posts' );

# -[ defines ]-
define( "EGL_TOPICTYPE_NORMAL", 	0 );
define( "EGL_TOPICTYPE_IMPORTANT", 	1 );
define( "EGL_TOPICTYPE_NOTICE", 	2 );

# -[ objectlist ] -


# -[ class ] -
class EGLForums
{
	
	# -[ variables ]-
	var $pDBInterface	= NULL;
	var $aForums		= array();
	var $aTmpList		= array();
	# -[ functions ]-
	
	
	# =========================================================================
	# PUBLIC
	# =========================================================================

	
	/**
	 * MapCollections
	 * 
	 */
	function EGLForums( &$pDBCon )
	{
		$this->pDBInterface = &$pDBCon;
	}


	
	/**
	 * Fetch Forums
	 */
	function FetchForums($forum_id=-1){
		$sql_query	= 	" SELECT forum.*, section.name AS section_name, lasttopic_member.nick_name AS lasttopic_nickname, lasttopic_member.id AS lasttopic_memberid, lasttopic.title AS lasttopic_title, lasttopic.created  AS lasttopic_created, ".
						"		 lasttopic.username AS lasttopic_username ".
						" FROM `".DBTB::GetTB('MODULE','EGL_FORUMS')."` AS forum ".
						" LEFT JOIN `".DBTB::GetTB('MODULE','EGL_FORUM_SECTIONS')."` AS section ".
						" ON forum.section_id=section.id ".
						" LEFT JOIN `".DBTB::GetTB('MODULE','EGL_FORUM_TOPICS')."` AS lasttopic ".
						" ON lasttopic.id=forum.last_topic_id ".
						" LEFT JOIN `".DBTB::GetTB('GLOBAL', 'EGL_MEMBERS')."` AS lasttopic_member ".
						" ON lasttopic_member.id=lasttopic.member_id ".
						" WHERE forum.forum_id = ".(int)$forum_id." ".
						" ORDER BY section.index ASC, section.name ASC, forum.index ASC, forum.name ASC  ";
		return $this->pDBInterface->FetchArrayObject( $this->pDBInterface->Query( $sql_query ) );
	}

	/**	
	 * FetchEmptySections
	 */
	function FetchEmptySections(){
		$sql_query	= 	" SELECT COUNT(forum.id) AS num_forums, section.id AS section_id, section.name AS section_name, forum.name as name ".
						" FROM `".DBTB::GetTB('MODULE','EGL_FORUM_SECTIONS')."` AS section ".
						" LEFT JOIN `".DBTB::GetTB('MODULE','EGL_FORUMS')."` AS forum ".
						" ON forum.section_id=section.id ".
						" GROUP BY section.id ".
						" HAVING  num_forums = 0 ";
		return $this->pDBInterface->FetchArrayObject( $this->pDBInterface->Query( $sql_query ) );
	}
	
	
	/**
	 * GetMaxForumIndex
	 */
	function GetMaxForumIndex($section_id){
		$sql_query	= 	" SELECT MAX(forum.index) AS max_index ".
						" FROM `".DBTB::GetTB('MODULE','EGL_FORUMS')."` AS forum ".
						" WHERE forum.section_id=".(int)$section_id." ".
						" GROUP BY forum.section_id  ";
		$obj = $this->pDBInterface->FetchObject( $this->pDBInterface->Query( $sql_query ) );
		return $obj->max_index;
	}
	
	/**
	 * GetTopPost
	 */
	function GetTopPost($topic_id){
		$sql_query	= 	" SELECT * ".
						" FROM `".DBTB::GetTB('MODULE','EGL_FORUM_POSTS')."` AS posts ".
						" WHERE posts.topic_id=".(int)$topic_id." ".
						" ORDER BY posts.created ASC ".
						" LIMIT 0,1  ";
		return $this->pDBInterface->FetchObject( $this->pDBInterface->Query( $sql_query ) );
	}	
	
	
	/**
	 * NewForumIndex
	 */
	/*function GetMaxSectionIndex(){
		$sql_query	= 	" SELECT * ".
						" FROM `".DBTB::GetTB('MODULE','EGL_FORUM_SECTIONS')."` AS section ".
						" GROUP BY section.id ";
		$obj = $this->pDBInterface->FetchArrayObject( $this->pDBInterface->Query( $sql_query ) );
		$max=0;
		for($i=0; $i < sizeof($obj); $i++ ) if( $obj[$i]->index > $max ) $max = $obj[$i]->index;
		return $max;
	}*/
	
		
	
	/**
	 * GetMaxSectionIndex
	 */
	function GetMaxSectionIndex(){
		$sql_query	= 	" SELECT MAX(section.index) AS max_index ".
						" FROM `".DBTB::GetTB('MODULE','EGL_FORUM_SECTIONS')."` AS section ".
						" Limit 0,1";
		$obj = $this->pDBInterface->FetchObject( $this->pDBInterface->Query( $sql_query ) );
		return $obj->max_index;
	}
		
		
	/**
	 * FetchAllForums
	 */
	function FetchAllForums(){
		$sql_query	= 	" SELECT forum.* ".
						" FROM `".DBTB::GetTB('MODULE','EGL_FORUMS')."` AS forum ";
		return $this->pDBInterface->FetchArrayObject( $this->pDBInterface->Query( $sql_query ) );
	}	
	
	/**
	 * FetchForum
	 */
	function FetchForum($forum_id){
		$sql_query	= 	" SELECT * ".
						" FROM `".DBTB::GetTB('MODULE','EGL_FORUMS')."` AS forum ".
						" WHERE forum.id = ".(int)$forum_id." ";
		return $this->pDBInterface->FetchObject( $this->pDBInterface->Query( $sql_query ) );
	}
	
	
	/**
	 * Fetch Post
	 */
	function FetchPost($post_id){
		$sql_query	= 	" SELECT posts.*, topics.forum_id ".
						" FROM `".DBTB::GetTB('MODULE','EGL_FORUM_POSTS')."` AS posts ".
						" LEFT JOIN `".DBTB::GetTB('MODULE','EGL_FORUM_TOPICS')."` AS topics ".
						" ON topics.id=posts.topic_id ".
						" WHERE posts.id = ".(int)$post_id." ";
		return $this->pDBInterface->FetchObject( $this->pDBInterface->Query( $sql_query ) );
	}
	
	/**
	 * Fetch Post
	 */
	function FetchDetailedPost($post_id){
		$sql_query	= 	" SELECT posts.*, topics.forum_id, member.nick_name AS member_nickname " .
						" FROM `".DBTB::GetTB('MODULE','EGL_FORUM_POSTS')."` AS posts ".
						" LEFT JOIN `".DBTB::GetTB('MODULE','EGL_FORUM_TOPICS')."` AS topics ".
						" ON topics.id=posts.topic_id ".
						" LEFT JOIN `".DBTB::GetTB('GLOBAL','EGL_MEMBERS')."` AS member ".
						" ON posts.member_id=member.id ".
						" WHERE posts.id = ".(int)$post_id." ";
		return $this->pDBInterface->FetchObject( $this->pDBInterface->Query( $sql_query ) );
	}	
		
	/**
	 * Fetch Forum
	 */
	function FetchSection($section_id){
		$sql_query	= 	" SELECT * ".
						" FROM `".DBTB::GetTB('MODULE','EGL_FORUM_SECTIONS')."` AS sections ".
						" WHERE sections.id = ".(int)$section_id." ";
		return $this->pDBInterface->FetchObject( $this->pDBInterface->Query( $sql_query ) );
	}	
		
	
	/**
	 * Fetch section by index
	 */
	function FetchSectionByIndex($index){
		$sql_query	= 	" SELECT * ".
						" FROM `".DBTB::GetTB('MODULE','EGL_FORUM_SECTIONS')."` AS sections ".
						" WHERE sections.index = ".(int)$index." ";
		return $this->pDBInterface->FetchObject( $this->pDBInterface->Query( $sql_query ) );
	}
	
	
		
	/**
	 * Fetch Forum by index
	 */
	function FetchForumByIndex($section_id,$index){
		$sql_query	= 	" SELECT * ".
						" FROM `".DBTB::GetTB('MODULE','EGL_FORUMS')."` AS forum ".
						" WHERE forum.index = ".(int)$index." && forum.section_id=".(int)$section_id;
		return $this->pDBInterface->FetchObject( $this->pDBInterface->Query( $sql_query ) );
	}	

	
		/**
	 * FetchTopic
	 */
	function FetchTopic($topic_id){
		$sql_query	= 	" SELECT * ".
						" FROM `".DBTB::GetTB('MODULE','EGL_FORUM_TOPICS')."` AS topic ".
						" WHERE topic.id = ".(int)$topic_id." ";
		return $this->pDBInterface->FetchObject( $this->pDBInterface->Query( $sql_query ) );
	}	
	
			
	
	/**
	 * FetchForumTopics
	 */
	function FetchForumTopics($forum_id){
		$sql_query	= 	" SELECT member.*, topic.*, lastpost_member.nick_name AS lastpost_nickname, lastpost_member.id AS lastpost_memberid, lastpost.created  AS lastpost_created, ".
						"		 lastpost.username AS lastpost_username ".
						" FROM `".DBTB::GetTB('MODULE','EGL_FORUM_TOPICS')."` AS topic ".
						" LEFT JOIN `".DBTB::GetTB('GLOBAL', 'EGL_MEMBERS')."` AS member ".
						" ON member.id=topic.member_id ".
						" LEFT JOIN `".DBTB::GetTB('MODULE','EGL_FORUM_POSTS')."` AS lastpost ".
						" ON lastpost.id=topic.last_post_id ".
						" LEFT JOIN `".DBTB::GetTB('GLOBAL', 'EGL_MEMBERS')."` AS lastpost_member ".
						" ON lastpost_member.id=lastpost.member_id ".
						" WHERE topic.forum_id = ".(int)$forum_id." ".
						" ORDER BY topic.type DESC, topic.changed DESC, topic.title ASC ";
		return $this->pDBInterface->FetchArrayObject( $this->pDBInterface->Query( $sql_query ) );
	}
	
	/**
	 * Fetch Topic Posts
	 */
	function FetchTopicPosts($topic_id){
		$sql_query	= 	" SELECT tpost.*, member.nick_name, member.created AS member_created, member.email ".
						" FROM `".DBTB::GetTB('MODULE','EGL_FORUM_POSTS')."` AS tpost ".
						" LEFT JOIN `".DBTB::GetTB('GLOBAL', 'EGL_MEMBERS')."` AS member ".
						" ON member.id=tpost.member_id ".
						" WHERE tpost.topic_id = ".(int)$topic_id." ".
						" ORDER BY tpost.created ";
		return $this->pDBInterface->FetchArrayObject( $this->pDBInterface->Query( $sql_query ) );
	}
	

	/**
	 * Enter description here...
	 */
	function NewForum( $obj )
	{
		# creat insert query + execute => return true/false
		$sql_query = $this->pDBInterface->CreateInsertQuery( DBTB::GetTB('MODULE','EGL_FORUMS'), $obj );
		if( $this->pDBInterface->Query( $sql_query ) );
			return $this->pDBInterface->InsertId();
		return -1;
	}
	
	/**
	 * DeleteForum
	 * 
	 */
	function DeleteForum( $id )
	{
		$sql_query = "DELETE FROM `". DBTB::GetTB('MODULE','EGL_FORUMS')."` WHERE id=".(int)$id." ";
		return $this->pDBInterface->Query( $sql_query );
	}
	
	/**
	 * Enter description here...
	 */
	function UpdateForum( $obj, $forum_id )
	{
		$sql_query = 	$this->pDBInterface->CreateUpdateQuery( DBTB::GetTB('MODULE','EGL_FORUMS'), $obj ).
						" WHERE id=".(int)$forum_id;
		return $this->pDBInterface->Query( $sql_query );
	}

	
	/**
	 * Enter description here...
	 */
	function NewSection( $obj )
	{
		# creat insert query + execute => return true/false
		$sql_query = $this->pDBInterface->CreateInsertQuery( DBTB::GetTB('MODULE','EGL_FORUM_SECTIONS'), $obj );
		if( $this->pDBInterface->Query( $sql_query ) );
			return $this->pDBInterface->InsertId();
		return -1;
	}
	
	/**
	 * Enter description here...
	 */
	function UpdateSection( $obj, $section_id )
	{
		$sql_query = 	$this->pDBInterface->CreateUpdateQuery( DBTB::GetTB('MODULE','EGL_FORUM_SECTIONS'), $obj ).
						" WHERE id=".(int)$section_id;
		return $this->pDBInterface->Query( $sql_query );
	}

	/**
	 * Enter description here...
	 */
	function NewTopic( $obj )
	{
		# creat insert query + execute => return true/false
		$sql_query = $this->pDBInterface->CreateInsertQuery( DBTB::GetTB('MODULE','EGL_FORUM_TOPICS'), $obj );
		if( $this->pDBInterface->Query( $sql_query ) );
			return $this->pDBInterface->InsertId();
		return -1;
	}
	
	/**
	 * Enter description here...
	 */
	function UpdateTopic( $obj, $topic_id )
	{
		$sql_query = 	$this->pDBInterface->CreateUpdateQuery( DBTB::GetTB('MODULE','EGL_FORUM_TOPICS'), $obj ).
						" WHERE id=".(int)$topic_id;
		return $this->pDBInterface->Query( $sql_query );
	}
	
	/**
	 * Enter description here...
	 */
	function UpdateLinkedTopics( $obj, $topic_id )
	{
		$sql_query = 	$this->pDBInterface->CreateUpdateQuery( DBTB::GetTB('MODULE','EGL_FORUM_TOPICS'), $obj ).
						" WHERE linked_topicid=".(int)$topic_id;
		return $this->pDBInterface->Query( $sql_query );
	}	
	
	
	/**
	 * Enter description here...
	 */
	function NewTopicPost( $obj )
	{
		# creat insert query + execute => return true/false
		$sql_query = $this->pDBInterface->CreateInsertQuery( DBTB::GetTB('MODULE','EGL_FORUM_POSTS'), $obj );
		if( $this->pDBInterface->Query( $sql_query ) );
			return $this->pDBInterface->InsertId();
		return -1;
	}
	
	/**
	 * Enter description here...
	 */
	function UpdateTopicPost( $obj, $post_id )
	{
		$sql_query = 	$this->pDBInterface->CreateUpdateQuery( DBTB::GetTB('MODULE','EGL_FORUM_POSTS'), $obj ).
						" WHERE id=".(int)$post_id;
		$this->pDBInterface->Query( $sql_query );
	}
		
	
	function SyncForum( $forum_id){
		# FORUM
		// last_topicid
		// num topics
		# TOPICS
		// last_postid
		// 
	}
	
	
	
	//-------------------------------------------------------------------------------
	// Purpose:
	//-------------------------------------------------------------------------------
	function finde_path( $forum_id, &$path )
	{
		if( $forum_id != -1 )
		{
			if( sizeof($this->aForumList) == 0 ){
				$this->aForumList = $this->FetchAllForums();
			}
			for( $i=0; $i < sizeof($this->aForumList); $i++ ){
				if( $this->aForumList[$i]->id == $forum_id ){
					$num_items = sizeof($path);
					$path[$num_items] = $this->aForumList[$i];
					return $this->finde_path( $path[$num_items]->forum_id, $path );
				}//if
			}//for
		}//if
		
		return 1;
	}
	
	//-------------------------------------------------------------------------------
	// Purpose:
	//-------------------------------------------------------------------------------
	function GetPath( $forum_id )
	{
		$path = array();
		$this->finde_path( $forum_id, $path );
		return array_reverse( $path );
	}
	
	/**
	 * SetTempForumList
	 */
	function SetTempForumList( $aForumList ){
		$this->aTmpList = $aForumList;
	}
	

	//-------------------------------------------------------------------------------
	// Purpose:
	//-------------------------------------------------------------------------------
	function generate_tree( &$node, $forum_id, $level )
	{
		if( $level == -1 || $level > 0 )
		{
			$aSubNodes 		= $this->CutSubForums( $forum_id );
			$node->aObjects = array(); //$this->GenerateObjectList( $forum_id );
			for( $n=0; $n < sizeof($aSubNodes); $n++ )
			{
				$pNode = &$node->aNodes[$n];
				$pNode = new tree_node_t;
				
				$pNode->oProperties = $aSubNodes[$n];
				if( $level == -1 )
					$this->generate_tree( $node->aNodes[$n], $aSubNodes[$n]->id, $level );
				else
					$this->generate_tree( $node->aNodes[$n], $aSubNodes[$n]->id, --$level );
			}//for
		}
	}//function

	
	//-------------------------------------------------------------------------------
	// Purpose:
	//-------------------------------------------------------------------------------
	function CutSubForums( $id )
	{
		$aForums 	= array();
		$aNewList 	= array();
		for( $i=0; $i < sizeof($this->aTmpList); $i++ )
		{
			if( $this->aTmpList[$i]->forum_id == $id )
			{
				$aForums[sizeof($aForums)] =  $this->aTmpList[$i];
			}
			else
			{
				$aNewList[sizeof($aNewList)] =  $this->aTmpList[$i];
			}
		}
		# save new list
		$this->aTmpList = $aNewList;
		return $aForums;
	}//function	
	
	
	//-------------------------------------------------------------------------------
	// Purpose: 
	// Output : 
	//-------------------------------------------------------------------------------	
	function GetForumAdministrator( $forum_id, $permissions )
	{
		$sql_query =" SELECT permissions.id, permissions.permissions, permissions.cat_id, permissions.admin_id, permissions.data, permissions.created,
					  		 members.id AS member_id, members.nick_name, members.email ".
					" FROM `{$GLOBALS['g_egltb_admin_permissions']}` AS permissions ".
					" LEFT JOIN `{$GLOBALS['g_egltb_admins']}` AS admins ".
					" ON admins.id=permissions.admin_id ".
					" LEFT JOIN `{$GLOBALS['g_egltb_members']}` AS members ".
					" ON admins.member_id=members.id".
					" WHERE permissions.permissions='".$this->pDBInterface->EscapeString($permissions)."' && permissions.data='{$forum_id}' && permissions.module_id='".MODULEID_INETOPIA_FORUMS."' ";
		return $this->pDBInterface->FetchArrayObject( $this->pDBInterface->Query( $sql_query ) );		
		
	}	
};

?>