<?php
# ================================ Copyright © 2005-2006 Inetopia, All rights reserved. ==========================
# 
#
# Purpose:
# ================================================================================================================







class OnlineList
{
	# -[ variables ]-
	var $pDBCon	= NULL;

	
	# -[ functions ]-
	
	

	//-------------------------------------------------------------------------------
	// Purpose: constructor
	//-------------------------------------------------------------------------------
	function OnlineList ( &$pDBCon )
	{
		$this->pDBCon = &$pDBCon;
	}
	
	
	//-------------------------------------------------------------------------------
	// Purpose:
	//-------------------------------------------------------------------------------
	function ReadOnlineList()
	{
		$sql_query =  " SELECT members.*, onlinelist.* ".
					  " FROM `{$GLOBALS['g_egltb_onlinelist']}` AS onlinelist, `{$GLOBALS['g_egltb_members']}` AS members ".
					  " WHERE onlinelist.member_id=members.id ".
					  " ORDER BY last_action DESC ";
					 // " GROUP BY members.nick_name ";
					  
		return $this->pDBCon->FetchArrayObject( $this->pDBCon->Query( $sql_query ) );
	}
	
	
	//-------------------------------------------------------------------------------
	// Purpose:
	//-------------------------------------------------------------------------------
	function GetMemberOnlineState( $member_id )
	{
		$sql_query =  " SELECT members.*, onlinelist.* ".
					  " FROM `{$GLOBALS['g_egltb_onlinelist']}` AS onlinelist, `{$GLOBALS['g_egltb_members']}` AS members ".
					  " WHERE onlinelist.member_id=members.id && member_id=".(int)$member_id;
					  
		return $this->pDBCon->FetchObject( $this->pDBCon->Query( $sql_query ) );
	}
};


?>