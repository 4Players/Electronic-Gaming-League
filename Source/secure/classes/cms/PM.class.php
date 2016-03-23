<?php
# ================================ Copyright © 2005-2006 Inetopia, All rights reserved. ==========================
# 
#
# Purpose:
# ================================================================================================================



# -[ defines ]-



# -[ objectlist ] -

class pm_message_t
{
	var $id				= -1;
	var $sender_id		= -1;
	var $receiver_id	= -1;
	var $title			= "";
	var $text			= "";
	var $created		= 0;
	var $read			= 0;
};



class pm_messages_t
{
	var $MemberId	= -1;
	var $aInput		= NULL;
	var $aOutput	= NULL;
};



# -[ class ] -
class PM
{
	# -[ variables ]-
	var $pDBInterfaceCon	= NULL;
	var $MemberId	= -1;
	var $aInput		= array();		# incoming messages
	var $aOutput	= array();		# outcoming messages
	
	# -[ functions ]-
	
	
	# =========================================================================
	# PUBLIC
	# =========================================================================
	
	//-------------------------------------------------------------------------------
	// Purpose: constructor
	// Output : -
	//-------------------------------------------------------------------------------
	function PM ( &$pDBInterfaceCon)
	{
		$this->pDBInterfaceCon = &$pDBInterfaceCon;
	}
	
	//-------------------------------------------------------------------------------
	// Purpose: close current opened file
	// Output : tru/false
	//-------------------------------------------------------------------------------
	function SetID( $member_id )
	{
		return ($this->MemberId = $member_id);
	}
	
	
	
	//-------------------------------------------------------------------------------
	// Purpose: 
	// Output :
	//-------------------------------------------------------------------------------
	function FillBuffers( $bInput=false, $bOutput=false )
	{

		# fetch output messages
		if( $bInput )
		{
		
			# define input query query
			$msg_select_query = 	" SELECT pm_tb.id,pm_tb.sender_id,pm_tb.receiver_id,pm_tb.title,pm_tb.created,pm_tb.is_read,member_tb.nick_name AS sender_name, member_tb.logo_file AS logo_file ".
									" FROM {$GLOBALS['g_egltb_pm_messages']} AS pm_tb ".
									" LEFT JOIN {$GLOBALS['g_egltb_members']} AS member_tb ".
									" ON (member_tb.id=pm_tb.sender_id) ".
									" WHERE pm_tb.receiver_id={$this->MemberId} AND member_id={$this->MemberId} ".
									" ORDER BY created DESC";
			$qre = $this->pDBInterfaceCon->Query( $msg_select_query );
			if( !$qre ) return false;
			$this->aInput = $this->pDBInterfaceCon->FetchArrayObject( $qre );
			
			#------------------
			
			
		}
		
		# fetch output messages
		if( $bOutput )
		{

			# define output query query
			$msg_select_query = 	" SELECT pm_tb.id,pm_tb.sender_id,pm_tb.receiver_id,pm_tb.title, pm_tb.created,pm_tb.is_read,member_tb.nick_name AS receiver_name, member_tb.logo_file AS logo_file ".
									" FROM {$GLOBALS['g_egltb_pm_messages']} AS pm_tb ".
									" LEFT JOIN {$GLOBALS['g_egltb_members']} AS member_tb ".
									" ON (member_tb.id=pm_tb.receiver_id) ".
									" WHERE pm_tb.sender_id={$this->MemberId} AND member_id={$this->MemberId} ".
									" ORDER BY created DESC";
			
			$qre = $this->pDBInterfaceCon->Query( $msg_select_query );
			if( !$qre ) return false;
			$this->aOutput = $this->pDBInterfaceCon->FetchArrayObject( $qre );

			#------------------
		}

		return true;	
	}
	

	//-------------------------------------------------------------------------------
	// Purpose: 
	// Output : unread message counter
	//-------------------------------------------------------------------------------
	function GetUnreadMessages()
	{
		if( !$this->MemberId ) return -1;
		$sql_query = " SELECT COUNT(*) As num_msg ".
					 " FROM {$GLOBALS['g_egltb_pm_messages']} ".
					 " WHERE member_id={$this->MemberId} AND receiver_id={$this->MemberId} AND is_read=0 ";
		
		# go
		$qre = $this->pDBInterfaceCon->Query( $sql_query ); # run query
		if( !$qre ) return -1;
		
		$temp_obj = $this->pDBInterfaceCon->FetchObject($qre);
		return $temp_obj->num_msg;
	}
	

	
	
	//-------------------------------------------------------------------------------
	// Purpose: 
	// Output :
	//-------------------------------------------------------------------------------
	function GetInput()
	{
		return $this->aInput;
	}
	
	
	//-------------------------------------------------------------------------------
	// Purpose: 
	// Output :
	//-------------------------------------------------------------------------------
	function GetOutput()
	{
		return $this->aOutput;
	}
	
	
	# =========================================================================
	# =========================================================================
	# STATIC PUBLIC
	# =========================================================================	
	# =========================================================================	
	
	//-------------------------------------------------------------------------------
	// Purpose: 
	// Output :
	//-------------------------------------------------------------------------------
	function CreateMessage( $obj )
	{
		$insert_query = $this->pDBInterfaceCon->CreateInsertQuery( $GLOBALS['g_egltb_pm_messages'], $obj );
		$qre = $this->pDBInterfaceCon->Query( $insert_query ); # run query
		if( !$qre ) return -1;
		return $this->pDBInterfaceCon->InsertId();	# return insert ID
	}
	
	//-------------------------------------------------------------------------------
	// Purpose: 
	// Output :
	//-------------------------------------------------------------------------------
	function DeleteMessage( $id )
	{
		$sql_delete = "DELETE FROM ".$GLOBALS['g_egltb_pm_messages']." WHERE id=".$id;
		return $this->pDBInterfaceCon->Query( $sql_delete ); # run query
	}
		
	

	//-------------------------------------------------------------------------------
	// Purpose: get message data from id
	// Output : msg object
	//-------------------------------------------------------------------------------
	function GetMessage( $id )
	{
		# define query	
		$sql_query = " SELECT pm_tb.*, member_tb.nick_name AS sender_name, member_tb.logo_file AS logo_file ".
					 " FROM {$GLOBALS['g_egltb_pm_messages']} AS pm_tb ".
					 " LEFT JOIN {$GLOBALS['g_egltb_members']} AS member_tb ".
					 " ON (member_tb.id=pm_tb.sender_id) ".
					 " WHERE pm_tb.id={$id}";
		
		# go
		$qre = $this->pDBInterfaceCon->Query( $sql_query ); # run query
		if( !$qre ) return -1;
		
		return ( $this->pDBInterfaceCon->FetchObject($qre) );		
	}
	
	
	//-------------------------------------------------------------------------------
	// Purpose: change message data
	// Output : true/false
	//-------------------------------------------------------------------------------
	function ChangeMessage( $obj, $id )
	{
		# define query
		$msg_update = $this->pDBInterfaceCon->CreateUpdateQuery( $GLOBALS['g_egltb_pm_messages'], $obj );
		return $this->pDBInterfaceCon->Query( $msg_update . " WHERE id=$id" );
	}
};

?>