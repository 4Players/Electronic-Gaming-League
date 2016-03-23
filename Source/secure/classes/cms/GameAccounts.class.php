<?php
# ================================ Copyright © 2005-2006 Inetopia, All rights reserved. ==========================
# 
#
# Purpose:
# ================================================================================================================



# -[ defines ]-



# -[ objectlist ] -




# -[ class ] -
class GameAccounts
{
	# -[ variables ]-
	var $pDBCon	= NULL;
	
	# -[ functions ]-
	
	
	#------------------------------------------------------------------------------
	# Purpose: 
	#------------------------------------------------------------------------------
	function GameAccounts( &$pDBCon )
	{
		$this->pDBCon = &$pDBCon; 
	}
	
	
	
	#------------------------------------------------------------------------------
	# Purpose: 
	#------------------------------------------------------------------------------
	function GetGameAccountsOfMember( $member_id )
	{
		$sql_query = 	" SELECT gameacc.change_time AS gameacc_change_time, gameacc.id AS gameacc_id, gameacc.created AS gameacc_created, gameacc.*, gameacc_type.* FROM {$GLOBALS['g_egltb_gameaccounts']} AS gameacc ".
						" LEFT JOIN `".$GLOBALS['g_egltb_gameaccount_types']."` AS gameacc_type ".
						" ON gameacc.gameacctype_id=gameacc_type.id ".
						" WHERE gameacc.member_id=".(int)$member_id."";
		return $this->pDBCon->FetchArrayObject($this->pDBCon->Query( $sql_query ));
	}
	
	
	#------------------------------------------------------------------------------
	# Purpose: 
	#------------------------------------------------------------------------------
	function GetGameAccountByType( $member_id, $gameacctype_id )
	{
		$sql_query = " SELECT * FROM `".$GLOBALS['g_egltb_gameaccounts']."` WHERE member_id=".(int)$member_id." AND gameacctype_id=".(int)$gameacctype_id." ";
		return $this->pDBCon->FetchObject($this->pDBCon->Query( $sql_query ));
	}
		
	
	/*
	#------------------------------------------------------------------------------
	# Purpose: 
	#------------------------------------------------------------------------------
	function GetGameAccountTypeByGame( $game_id )
	{
		$sql_query = " SELECT * FROM `".$GLOBALS['g_egltb_gameaccount_types']."` WHERE game_id=".(int)$game_id." ";
		return $this->pDBCon->FetchObject($this->pDBCon->Query( $sql_query ));
	}*/
	
	
	#------------------------------------------------------------------------------
	# Purpose: 
	#------------------------------------------------------------------------------
	function GetGamesSelectedGameAccTypes( $gameacc_id )
	{
		$sql_query = " SELECT * FROM `".$GLOBALS['g_egltb_game_pool']."` WHERE gameacctype_id=".(int)$gameacc_id." ";
		return $this->pDBCon->FetchArrayObject($this->pDBCon->Query( $sql_query ));
	}
	
	function GetGameAccountValue( $gameacctype_id, $gameacc_value )
	{
		$sql_query = " SELECT * FROM `".$GLOBALS['g_egltb_gameaccounts']."` WHERE gameacctype_id=".(int)$gameacctype_id." && value='".$this->pDBCon->EscapeString($gameacc_value)."' ";
		return $this->pDBCon->FetchObject($this->pDBCon->Query( $sql_query ));
	}	
	

	
	#------------------------------------------------------------------------------
	# Purpose: 
	#------------------------------------------------------------------------------
	function GetGameAccountTypes()
	{
		$sql_query = "SELECT * FROM `".$GLOBALS['g_egltb_gameaccount_types']."`";
		return $this->pDBCon->FetchArrayObject($this->pDBCon->Query( $sql_query ));
	}
	
	#------------------------------------------------------------------------------
	# Purpose: 
	#------------------------------------------------------------------------------
	function GetGameAccountType( $gameacctype_id )
	{
		$sql_query = "SELECT * FROM `".$GLOBALS['g_egltb_gameaccount_types']."` WHERE id=".(int)$gameacctype_id."";
		return $this->pDBCon->FetchObject($this->pDBCon->Query( $sql_query ));
	}
	
	
	#------------------------------------------------------------------------------
	# Purpose: 
	#------------------------------------------------------------------------------
	function SetGameAccountData( $data, $account_id )
	{
		$sql_query = 	$this->pDBCon->CreateUpdateQuery( $GLOBALS['g_egltb_gameaccounts'], $data ) . 
						" WHERE id=".(int)$account_id;
		# execute query
		return $this->pDBCon->Query( $sql_query );
	}
	
		
	
	#------------------------------------------------------------------------------
	# Purpose: 
	#------------------------------------------------------------------------------
	function SetGameAccountTypeData( $data, $account_id )
	{
		$sql_query = 	$this->pDBCon->CreateUpdateQuery( $GLOBALS['g_egltb_gameaccount_types'], $data ) . 
						" WHERE id=".(int)$account_id;
						
		# execute query
		return $this->pDBCon->Query( $sql_query );
	}
	
	
	
	
	#------------------------------------------------------------------------------
	# Purpose: 
	#------------------------------------------------------------------------------
	function CreateGameAccountType( $object )
	{
		# creat insert query + execute => return true/false
		$sql_query = $this->pDBCon->CreateInsertQuery( $GLOBALS['g_egltb_gameaccount_types'], $object );
		if( $this->pDBCon->Query( $sql_query) )
			return $this->pDBCon->InsertId();
		return -2;
	}
		
	
	
	#------------------------------------------------------------------------------
	# Purpose: 
	#------------------------------------------------------------------------------
	function AddGameAccount( $object )
	{
		# creat insert query + execute => return true/false
		$sql_query = $this->pDBCon->CreateInsertQuery( $GLOBALS['g_egltb_gameaccounts'], $object );
		return ($this->pDBCon->Query( $sql_query ) );
	}
	
	
	#------------------------------------------------------------------------------
	# Purpose: 
	#------------------------------------------------------------------------------
	function CreateGameAccountReport( $object )
	{
		# creat insert query + execute => return true/false
		$sql_query = $this->pDBCon->CreateInsertQuery( $GLOBALS['g_egltb_gameaccount_reports'], $object );
		return ($this->pDBCon->Query( $sql_query ) );		
	}
	
	
	#------------------------------------------------------------------------------
	# Purpose: 
	#------------------------------------------------------------------------------
	function DeleteAccount( $id )
	{
		return $this->pDBCon->Query( "DELETE FROM `".$GLOBALS['g_egltb_gameaccounts']."` WHERE id=".(int)$id."" );
	}
	
};
	
	

?>