<?php
# ================================ Copyright © 2005-2006 Inetopia, All rights reserved. ==========================
# 
#
# Purpose:
# ================================================================================================================







class MemberHistory
{
	# -[ variables ]-
	var $pDBCon	= NULL;

	
	# -[ functions ]-
	
	

	//-------------------------------------------------------------------------------
	// Purpose: constructor
	//-------------------------------------------------------------------------------
	function MemberHistory ( &$pDBCon )
	{
		$this->pDBCon = &$pDBCon;
	}
	
	
	//-------------------------------------------------------------------------------
	// Purpose:
	//-------------------------------------------------------------------------------
	function AddHistoryEntry( $obj )
	{
		$sql_query = $this->pDBCon->CreateInsertQuery( $GLOBALS['g_egltb_member_history'], $obj );
		return ($this->pDBCon->Query( $sql_query ) );
	}
	
	
	
	
	//-------------------------------------------------------------------------------
	// Purpose:
	//-------------------------------------------------------------------------------
	function DeleteHistoryEntry( $history_id )
	{
		$sql_query = "DELETE FROM {$GLOBALS['g_egltb_member_history']} WHERE id={$history_id}";
		return ($this->pDBCon->Query( $sql_query ) );
	}
	
	
	
	
	//-------------------------------------------------------------------------------
	// Purpose:
	//-------------------------------------------------------------------------------
	function GetHistoryList( $member_id, $start=0, $end=0 )
	{
		$limited="";
		if( $start && $end ) $limited = " LIMIT {$start},{$end} ";
		
		$sql_query = " SELECT * ".
					 " FROM {$GLOBALS['g_egltb_member_history']} ".
					 " WHERE member_id={$member_id}".
					 " ORDER BY created ASC".
					 " {$limited} ";
		return $this->pDBCon->FetchArrayObject( $this->pDBCon->Query( $sql_query ) );
	}
};


?>