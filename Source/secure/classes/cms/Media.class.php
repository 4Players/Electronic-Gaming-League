<?php
# ================================ Copyright © 2005-2006 Inetopia, All rights reserved. ==========================
# 
#
# Purpose:
# ================================================================================================================



# -[ defines ]-



# -[ objectlist ] -




# -[ class ] -
class Media
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
	function Media (&$pDBInterfaceCon)
	{
		$this->pDBCon = $pDBInterfaceCon;
	}
	
	
	//-------------------------------------------------------------------------------
	// Purpose: constructor
	// Output : -
	//-------------------------------------------------------------------------------
	function GetMediaFiles( $match_id)
	{
		# define query
		$sql_query = 	" SELECT media.*, memb.id AS member_id, memb.nick_name AS member_nick FROM ".$GLOBALS['g_egltb_media_files']." AS media ".
						" LEFT JOIN ".$GLOBALS['g_egltb_members']." AS memb ".
						" ON media.member_id=memb.id ".
						" WHERE media.match_id=$match_id ".
						" ORDER BY media.created ASC";
		return $this->pDBCon->FetchArrayObject( $this->pDBCon->Query( $sql_query ) );
	}
	
	//-------------------------------------------------------------------------------
	// Purpose: 
	// Output : 
	//-------------------------------------------------------------------------------
	function GetSingleMFile( $media_id )
	{
		# define query
		$sql_query = 	" SELECT * FROM ".$GLOBALS['g_egltb_media_files']." ".
						" WHERE id=$media_id ";
		return $this->pDBCon->FetchObject( $this->pDBCon->Query( $sql_query ) );
	}
	
	
	
	//-------------------------------------------------------------------------------
	// Purpose: 
	// Output : 
	//-------------------------------------------------------------------------------
	function CreateMediaFile( $obj )
	{
		# creat insert query + execute => return true/false
		$sql_query = $this->pDBCon->CreateInsertQuery( $GLOBALS['g_egltb_media_files'], $obj );
		if(  ($this->pDBCon->Query( $sql_query ) ) )
			return $this->pDBCon->InsertId();
		return 0;
	}
	
	//-------------------------------------------------------------------------------
	// Purpose: 
	// Output : 
	//-------------------------------------------------------------------------------
	function UpdateMediaFile($obj, $media_id )
	{
		$sql_query = 	$this->pDBCon->CreateUpdateQuery( $GLOBALS['g_egltb_media_files'], $obj ) .
						" WHERE id=$media_id";
		return ($this->pDBCon->Query( $sql_query ) );
	}
	
	
	//-------------------------------------------------------------------------------
	// Purpose: 
	// Output : 
	//-------------------------------------------------------------------------------
	function Delete( $media_id )
	{
		$sql_query =	" DELETE FROM ".$GLOBALS['g_egltb_media_files']." WHERE id=$media_id ";
		return ($this->pDBCon->Query( $sql_query ) );
	}
	
	//-------------------------------------------------------------------------------
	// Purpose: 
	// Output : md5 str
	//-------------------------------------------------------------------------------	
	function CreateRandomMediaFilename()
	{
		return md5( time() . CreateRandomPassword(10) );
	}
	
};
	
?>