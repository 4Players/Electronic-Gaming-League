<?php
# ================================ Copyright © 2005-2006 Inetopia, All rights reserved. ==========================
# 
#
# Purpose:
# ================================================================================================================


# -[ defines ]-



# -[ objectlist ] -



# -[ class ] -
class Comments
{
	# -[ variables ]-
	var $sCommentTb		= "Unknown";
	var $pDBInterface		= NULL;
	var $sField			= "na";
	var $iId			= -1;
	
	# -[ functions ]-
	
	
	# =========================================================================
	# PUBLIC
	# =========================================================================
	
	//-------------------------------------------------------------------------------
	// Purpose: constructor
	// Output : -
	//-------------------------------------------------------------------------------
	function Comments ( &$pDBCon, $tb, $field )
	{
		$this->pDBInterface 	= &$pDBCon;
		$this->sCommentTb 		= $tb;
		$this->sField 			= $field;
	}
	
	
	//-------------------------------------------------------------------------------
	//-------------------------------------------------------------------------------
	function SetId($id)
	{
		return ($this->iId = $id);
	}
	
	//----------------------------------------lo---------------------------------------
	// Purpose: creates a message writen in given tb ($this->$sCommentTb)
	//  Output: True/False
	//-------------------------------------------------------------------------------
	function CreateComment( $obj )
	{
		return $this->pDBInterface->Query( $this->pDBInterface->CreateInsertQuery($this->sCommentTb, $obj ) );
	}
	
	//-------------------------------------------------------------------------------
	// Purpose: deletes a message containing the table
	//  Output: True/False
	//-------------------------------------------------------------------------------
	function DeleteComment( $id )
	{
		$sql_query = "DELETE FROM ".$this->sCommentTb." WHERE id=".(int)$id;
		return $this->pDBInterface->Query( $sql_query );
	}
	
	
	//-------------------------------------------------------------------------------
	// Purpose: gets an array of comments based on the overgiben id
	//  Output: comment array
	//-------------------------------------------------------------------------------
	function GetComments($f_id)
	{
		$sql_query = "SELECT comments.*, members.nick_name, members.logo_file FROM `".$this->sCommentTb."` AS comments LEFT JOIN `".$GLOBALS['g_egltb_members']."` AS members ON comments.author_id=members.id HAVING comments.".$this->sField."=".(int)$f_id." ORDER BY comments.created DESC";
		return $this->pDBInterface->FetchArrayObject( $this->pDBInterface->Query( $sql_query ) );
	}
	
	
	//-------------------------------------------------------------------------------
	// Purpose: gets the comments counter
	//  Output: int(11)
	//-------------------------------------------------------------------------------
	function GetCommentsCount($f_id)
	{
		$sql_query = "SELECT COUNT(*) AS comment_count FROM `{$this->sCommentTb}` WHERE ".$this->sField."=".(int)$f_id;
		$data = $this->pDBInterface->FetchObject( $this->pDBInterface->Query( $sql_query ) );
		return (int)$data->comment_count;
	}
	
};

?>