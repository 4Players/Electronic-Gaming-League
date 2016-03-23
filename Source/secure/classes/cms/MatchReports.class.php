<?php
# ================================ Copyright © 2005-2006 Inetopia, All rights reserved. ==========================
# 
#
# Purpose:
# ================================================================================================================



# -[ defines ]-



# -[ objectlist ] -




# -[ class ] -
class MatchReports
{
	# -[ variables ]-
	var $pDBCon = NULL;
	
	# -[ functions ]-
	
	
	# =========================================================================
	# PUBLIC
	# =========================================================================
	
	//-------------------------------------------------------------------------------
	// Purpose: constructor
	// Output : -
	//-------------------------------------------------------------------------------
	function MatchReports (&$pDBCon)
	{
		$this->pDBCon = $pDBCon;
	}
	
	
	//-------------------------------------------------------------------------------
	// Purpose: constructor
	// Output : -
	//-------------------------------------------------------------------------------
	function GetReports($match_id)
	{
		# define query
		$sql_query = 	" SELECT reports.*,  memb.nick_name AS member_nick, memb.id AS member_id FROM ".$GLOBALS['g_egltb_match_reports']." AS reports ".
						" LEFT JOIN ".$GLOBALS['g_egltb_members']." AS memb ".
						" ON reports.member_id=memb.id ".
						" WHERE reports.match_id={$match_id} ";
		return $this->pDBCon->FetchArrayObject( $this->pDBCon->Query( $sql_query ) );
	}
	
	
	//-------------------------------------------------------------------------------
	// Purpose:
	//-------------------------------------------------------------------------------
	function AddReport( $obj )
	{
		$sql_query = $this->pDBCon->CreateInsertQuery( $GLOBALS['g_egltb_match_reports'], $obj );
		return $this->pDBCon->Query( $sql_query );
	}
};
	
?>