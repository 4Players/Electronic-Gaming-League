<?php
# ================================ Copyright © 2005-2006 Inetopia, All rights reserved. ==========================
# 
#
# Purpose:
# ================================================================================================================



# -[ defines ]-



# -[ objectlist ] -




# -[ class ] -
class Protests
{
	# -[ variables ]-
	var $pDBInterfaceCon		= NULL;
	
	# -[ functions ]-
	
	
	# =========================================================================
	# PUBLIC
	# =========================================================================
	
	//-------------------------------------------------------------------------------
	// Purpose: constructor
	// Output : -
	//-------------------------------------------------------------------------------
	function Protests ( &$pDBInterfaceCon )
	{
		$this->pDBInterfaceCon = &$pDBInterfaceCon;
	}
	

	//-------------------------------------------------------------------------------
	// Purpose: 
	// Output : 
	//-------------------------------------------------------------------------------
	function CreateProtest( $obj )
	{
		# creat insert query + execute => return true/false
		$sql_query = $this->pDBInterfaceCon->CreateInsertQuery( $GLOBALS['g_egltb_protests'], $obj );
		return ($this->pDBInterfaceCon->Query( $sql_query ) );
	}
	
	
	//-------------------------------------------------------------------------------
	// Purpose: 
	//-------------------------------------------------------------------------------
	function GetProtests()
	{
		$sql_query 	= 	" SELECT adminaccess.id AS adminaccess_member_id, adminaccess.nick_name AS adminaccess_member_nick_name, admins.id AS admin_id, admins.nick_name AS admin_nick_name, protests.*, members.id AS member_id, members.nick_name AS member_nick_name ".
						" FROM `".$GLOBALS['g_egltb_protests']."` AS protests ".
						" LEFT JOIN `".$GLOBALS['g_egltb_members']."` AS members ".
						" ON protests.member_id=members.id ".
						" LEFT JOIN `".$GLOBALS['g_egltb_members']."` AS admins ".
						" ON protests.admin_id = admins.id ".
						" LEFT JOIN `".$GLOBALS['g_egltb_members']."` AS adminaccess ".
						" ON protests.adminaccess_member_id = adminaccess.id ".
						" ORDER BY created ASC ";
		return $this->pDBInterfaceCon->FetchArrayObject( $this->pDBInterfaceCon->Query($sql_query));
	}	
	

	//-------------------------------------------------------------------------------
	// Purpose: 
	//-------------------------------------------------------------------------------
	function GetAdministratedProtests()
	{
		$sql_query 	= 	" SELECT admins.id AS admin_id, admins.nick_name AS admin_nick_name, protests.*, members.id AS member_id, members.nick_name AS member_nick_name ".
						" FROM `".$GLOBALS['g_egltb_protests']."` AS protests ".
						" LEFT JOIN `".$GLOBALS['g_egltb_members']."` AS members ".
						" ON protests.member_id=members.id ".
						" LEFT JOIN `".$GLOBALS['g_egltb_members']."` AS admins ".
						" ON protests.admin_id = admins.id ".
						" WHERE administrated=1 ".
						" ORDER BY created ASC ";
		return $this->pDBInterfaceCon->FetchArrayObject( $this->pDBInterfaceCon->Query($sql_query));
	}	
	
		
	//-------------------------------------------------------------------------------
	// Purpose: gets all protests, which are not administrated or are not goging to be administrated, checked by adminaccess_time ($timediff)
	// 
	//  Output:
	//-------------------------------------------------------------------------------
	function GetAdminProtests( $time, $timediff, $member_id )
	{
		$sql_query 	= 	" SELECT admins.nick_name AS admin_nick_name, protests.*, members.id AS member_id, members.nick_name AS member_nick_name ".
						" FROM `".$GLOBALS['g_egltb_protests']."` AS protests ".
						" LEFT JOIN `".$GLOBALS['g_egltb_members']."` AS members ".
						" ON protests.member_id=members.id ".
						" LEFT JOIN `".$GLOBALS['g_egltb_members']."` AS admins ".
						" ON protests.admin_id = admins.id ".
						" WHERE administrated=0 && ($time-protests.adminaccess_time >= $timediff || protests.adminaccess_member_id=".(int)$member_id. ") ".
						" ORDER BY created ASC ";
		return $this->pDBInterfaceCon->FetchArrayObject( $this->pDBInterfaceCon->Query($sql_query));
	}	
	
	function GetOpenProtests( $time, $timediff, $member_id ){
		return $this->GetAdminProtests( $time, $timediff );
	}
	

		
	//-------------------------------------------------------------------------------
	// Purpose: reset/refresh activated, and outrunning protests more than timediff
	//-------------------------------------------------------------------------------
	function RefreshActiveProtests( $timediff )
	{
		$sql_query =	" UPDATE `".$GLOBALS['g_egltb_protests']."` SET adminaccess_time=0, adminaccess_member_id=-1 WHERE ".(int)EGL_TIME."-adminaccess_time > ".(int)$timediff."";
		return $this->pDBInterfaceCon->Query($sql_query);
	}	
	
	//-------------------------------------------------------------------------------
	// Purpose: 
	//-------------------------------------------------------------------------------
	function GetProtest( $id )
	{
		$sql_query 	= 	" SELECT admins.nick_name AS admin_nick_name,protests.*, members.id AS member_id, members.nick_name AS member_nick_name ".
						" FROM `".$GLOBALS['g_egltb_protests']."` AS protests ".
						" LEFT JOIN `".$GLOBALS['g_egltb_members']."` AS members ".
						" ON protests.member_id=members.id ".
						" LEFT JOIN `".$GLOBALS['g_egltb_members']."` AS admins ".
						" ON protests.admin_id = admins.id ".
						" WHERE protests.id=$id";
		return $this->pDBInterfaceCon->FetchObject( $this->pDBInterfaceCon->Query($sql_query));
	}
	
	
	//-------------------------------------------------------------------------------
	// Purpose: 
	//-------------------------------------------------------------------------------
	function GetAdministratedProtestsByMemberId( $member_id )
	{
		$sql_query 	= 	" SELECT admins.nick_name AS admin_nick_name, protests.*, members.id AS member_id, members.nick_name AS member_nick_name ".
						" FROM `".$GLOBALS['g_egltb_protests']."` AS protests ".
						" LEFT JOIN `".$GLOBALS['g_egltb_members']."` AS members ".
						" ON protests.member_id=members.id ".
						" LEFT JOIN `".$GLOBALS['g_egltb_members']."` AS admins ".
						" ON protests.admin_id = admins.id ".
						" WHERE administrated=1 && protests.member_id=".(int)$member_id." ".
						" ORDER BY created ASC ";
		return $this->pDBInterfaceCon->FetchArrayObject( $this->pDBInterfaceCon->Query($sql_query));
	}	
	
		
	//-------------------------------------------------------------------------------
	// Purpose: gets all protests, which are not administrated or are not goging to be administrated, checked by adminaccess_time ($timediff)
	// 
	//  Output:
	//-------------------------------------------------------------------------------
	function GetOpenProtestsByMemberId( $member_id )
	{
		$sql_query 	= 	" SELECT admins.nick_name AS admin_nick_name, protests.*, members.id AS member_id, members.nick_name AS member_nick_name ".
						" FROM `".$GLOBALS['g_egltb_protests']."` AS protests ".
						" LEFT JOIN `".$GLOBALS['g_egltb_members']."` AS members ".
						" ON protests.member_id=members.id ".
						" LEFT JOIN `".$GLOBALS['g_egltb_members']."` AS admins ".
						" ON protests.admin_id = admins.id ".
						" WHERE administrated=0 &&  protests.member_id=".(int)$member_id."".
						" ORDER BY created ASC ";
		return $this->pDBInterfaceCon->FetchArrayObject( $this->pDBInterfaceCon->Query($sql_query));
	}	
	
	
		
	//-------------------------------------------------------------------------------
	// Purpose: 
	//-------------------------------------------------------------------------------
	function GetProtestsByMemberId( $member_id )
	{
		$sql_query 	= 	" SELECT protests.*, members.id AS member_id, members.nick_name AS member_nick_name ".
						" FROM `".$GLOBALS['g_egltb_protests']."` AS protests ".
						" LEFT JOIN `".$GLOBALS['g_egltb_members']."` AS members ".
						" ON protests.member_id=members.id ".
						" WHERE protests.member_id=".(int)$member_id." ".
						" ORDER BY created ASC ";
		return $this->pDBInterfaceCon->FetchArrayObject( $this->pDBInterfaceCon->Query($sql_query));
	}	
	
	
	//-------------------------------------------------------------------------------
	// Purpose: 
	//-------------------------------------------------------------------------------
	function SetProtestData( $obj, $protest_id )
	{
		$sql_query = 	$this->pDBInterfaceCon->CreateUpdateQuery( $GLOBALS['g_egltb_protests'], $obj ).
						" WHERE id=".(int)$protest_id;
		return $this->pDBInterfaceCon->Query( $sql_query );
	}
		
	/**
	 * Enter description here...
	 *
	 * @param unknown_type $obj
	 * @return unknown
	 */
	function NewProtest( $obj )
	{
		# creat insert query + execute => return true/false
		$sql_query = $this->pDBInterfaceCon->CreateInsertQuery( $GLOBALS['g_egltb_protests'], $obj );
		return ($this->pDBInterfaceCon->Query( $sql_query ) );
	}//function
	
	// Purpose:
	//  Output:
	//-------------------------------------------------------------------------------
	function RemoveProtest( $protest_id )
	{
		// protests
		$sql_query 	= 	" DELETE FROM `".DBTB::GetTB( 'GLOBAL','EGL_PROTESTS')."` ".
						" WHERE id=".(int)$protest_id;
		$this->pDBInterfaceCon->Query( $sql_query );
		
		// comments
		$sql_query 	= 	" DELETE FROM `".DBTB::GetTB( 'GLOBAL','EGL_PROTEST_COMMENTS')."` ".
						" WHERE protest_id=".(int)$protest_id;
		$this->pDBInterfaceCon->Query( $sql_query );
		
		return 1;
	}

			
};

?>