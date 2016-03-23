<?php
# ================================ Copyright © 2005-2006 Inetopia, All rights reserved. ==========================
# 
#
# Purpose:
# ================================================================================================================






# -[ class ]-
class Administrator
{
	# -[ variables ]-
	var $pDBInterfaceCon	= NULL;

	
	# -[ methods ]-

	//-------------------------------------------------------------------------------
	// Purpose: constructor
	//-------------------------------------------------------------------------------
	function Administrator ( &$pDBCon )
	{
		$this->pDBInterfaceCon = &$pDBCon;
	}
	
	//-------------------------------------------------------------------------------
	// Purpose:
	//-------------------------------------------------------------------------------
	function GetAdminList()
	{
		$sql_query = " SELECT admins.*, members.nick_name, members.email, COUNT(admin_permissions.id) AS num_permissions, master_perm.permissions AS master_permissions ".
					 " FROM `".$GLOBALS['g_egltb_admins']."` AS admins ".
					 " LEFT JOIN `".$GLOBALS['g_egltb_members']."` AS members ".
					 " ON admins.member_id=members.id ".
					 " LEFT JOIN `".$GLOBALS['g_egltb_admin_permissions']."` admin_permissions ".
					 " ON admins.id=admin_permissions.admin_id ".
					 " LEFT JOIN `".$GLOBALS['g_egltb_admin_permissions']."` master_perm ".
					 " ON admins.id=master_perm.admin_id && master_perm.permissions='master' ".
					 " GROUP BY admins.id ".
					 " ORDER BY admins.created ASC ";
		//??????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????
		return $this->pDBInterfaceCon->FetchArrayObject( $this->pDBInterfaceCon->Query( $sql_query ));
	}
	
	
	//-------------------------------------------------------------------------------
	// Purpose: return a email-list from member DB
	//-------------------------------------------------------------------------------
	function GetMailingList()
	{
		$sql_query 	= " SELECT members.email FROM `{$GLOBALS['g_egltb_members']}` AS members, {$GLOBALS['g_egltb_admins']} admins ".
					  " WHERE members.id=admins.member_id";
		return $this->pDBInterfaceCon->FetchArrayObject( $this->pDBInterfaceCon->Query($sql_query));
	}
	
	//-------------------------------------------------------------------------------
	// Purpose: 
	// Output :
	//-------------------------------------------------------------------------------
	function AddAdministrator( $obj )
	{
		# creat insert query + execute => return true/false
		$sql_query = $this->pDBInterfaceCon->CreateInsertQuery( $GLOBALS['g_egltb_admins'], $obj );
		if( $this->pDBInterfaceCon->Query( $sql_query ) )
		{
			return $this->pDBInterfaceCon->InsertId();
		}
		else return -1;
	}
		
	
	//-------------------------------------------------------------------------------
	// Purpose: 
	// Output :
	//-------------------------------------------------------------------------------
	function AddPermissions( $obj )
	{
		# creat insert query + execute => return true/false
		$sql_query = $this->pDBInterfaceCon->CreateInsertQuery( $GLOBALS['g_egltb_admin_permissions'], $obj );
		return ($this->pDBInterfaceCon->Query( $sql_query ) );
	}
	
	//-------------------------------------------------------------------------------
	// Purpose: 
	// Output :
	//-------------------------------------------------------------------------------
	function DeleteAdministrator( $admin_id )
	{
		# delete admin
		$sql_query = "DELETE FROM `".$GLOBALS['g_egltb_admins']."` WHERE id={$admin_id}";
		$this->pDBInterfaceCon->Query( $sql_query );
		
		# delete permissions
		$sql_query = "DELETE FROM `".$GLOBALS['g_egltb_admin_permissions']."` WHERE admin_id={$admin_id}";
		$this->pDBInterfaceCon->Query( $sql_query );
		
		return 1;
	}		
	/*
	//-------------------------------------------------------------------------------
	// Purpose: 
	// Output :
	//-------------------------------------------------------------------------------
	function DeleteAdminPermissions( $permission_id)
	{
		# delete permissions
		$sql_query = "DELETE FROM ".$GLOBALS['g_egltb_admin_permissions']." WHERE id={$permission_id}";
		$this->pDBInterfaceCon->Query( $sql_query );
		
		return 1;
	}*/	
	
	//-------------------------------------------------------------------------------
	// Purpose: 
	// Output :
	//-------------------------------------------------------------------------------
	function GetAdmin( $admin_id )
	{
		$sql_query = " SELECT * ".
					 " FROM ".$GLOBALS['g_egltb_admins']." ".
					 " WHERE id={$admin_id}";
					 
		return $this->pDBInterfaceCon->FetchObject( $this->pDBInterfaceCon->Query( $sql_query ));
	}
	
	
	//-------------------------------------------------------------------------------
	// Purpose: 
	// Output :
	//-------------------------------------------------------------------------------
	function GetAdminPermissions( $admin_id )
	{
		$sql_query = " SELECT * ".
					 " FROM ".$GLOBALS['g_egltb_admin_permissions']." ".
					 " WHERE admin_id={$admin_id} ".
					 " ORDER BY module_id ASC, permissions ASC, data ASC, created DESC";
					 
		return $this->pDBInterfaceCon->FetchArrayObject( $this->pDBInterfaceCon->Query( $sql_query ));
	}
	
	
	//-------------------------------------------------------------------------------
	// Purpose: 
	// Output :
	//-------------------------------------------------------------------------------
	function GetAdminPermissionByPermission( $admin_id, $permission )
	{
		$sql_query = " SELECT * ".
					 " FROM {$GLOBALS['g_egltb_admin_permissions']} ".
					 " WHERE admin_id={$admin_id} && permissions='{$permission}'";
					 
		return $this->pDBInterfaceCon->FetchObject( $this->pDBInterfaceCon->Query( $sql_query ));
	}
	
	
	
	//-------------------------------------------------------------------------------
	// Purpose: 
	// Output :
	//-------------------------------------------------------------------------------
	function DeleteAdminPermission( $permission_id )
	{
		$sql_query = "DELETE FROM ".$GLOBALS['g_egltb_admin_permissions']." WHERE id={$permission_id}";
		return $this->pDBInterfaceCon->Query( $sql_query );
	}
	
	
	//-------------------------------------------------------------------------------
	// Purpose: 
	// Output :
	//-------------------------------------------------------------------------------
	function GetDetailedAdmin( $admin_id )
	{
		$sql_query = " SELECT admins.*, members.nick_name, members.email, COUNT(admin_permissions.id) AS num_permissions ".
					 " FROM ".$GLOBALS['g_egltb_admins']."	AS admins ".
					 " LEFT JOIN ".$GLOBALS['g_egltb_members']." AS members ".
					 " ON admins.member_id=members.id ".
					 " LEFT JOIN ".$GLOBALS['g_egltb_admin_permissions']." admin_permissions ".
					 " ON admins.id=admin_permissions.admin_id ".
					 " WHERE admins.id={$admin_id} ".
					 " GROUP BY admins.id ".
					 " ORDER BY admins.created ASC ";
					 
		return $this->pDBInterfaceCon->FetchObject( $this->pDBInterfaceCon->Query( $sql_query ));
	}
			
	
	//-------------------------------------------------------------------------------
	// Purpose: 
	// Output :
	//-------------------------------------------------------------------------------
	function GetDetailedAdminByMemberId( $member_id )
	{
		$sql_query = " SELECT admins.*, members.nick_name, members.email, COUNT(admin_permissions.id) AS num_permissions ".
					 " FROM ".$GLOBALS['g_egltb_admins']."	AS admins ".
					 " LEFT JOIN ".$GLOBALS['g_egltb_members']." AS members ".
					 " ON admins.member_id=members.id ".
					 " LEFT JOIN ".$GLOBALS['g_egltb_admin_permissions']." admin_permissions ".
					 " ON admins.id=admin_permissions.admin_id ".
					 " WHERE admins.member_id={$member_id} ".
					 " GROUP BY admins.id ".
					 " ORDER BY admins.created ASC ";
					 
		return $this->pDBInterfaceCon->FetchObject( $this->pDBInterfaceCon->Query( $sql_query ));
	}
		
	//-------------------------------------------------------------------------------
	// Purpose: 
	// Output :
	//-------------------------------------------------------------------------------
	function GetAdminByMemberId( $member_id )
	{
		$sql_query = " SELECT * ".
					 " FROM ".$GLOBALS['g_egltb_admins']." ".
					 " WHERE member_id={$member_id}";
					 
		return $this->pDBInterfaceCon->FetchObject( $this->pDBInterfaceCon->Query( $sql_query ));
	}
};


?>