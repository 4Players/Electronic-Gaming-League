<?php
# ================================ Copyright © 2005-2006 Inetopia, All rights reserved. ==========================
# 
#
# Purpose:
# ================================================================================================================


# -[ defines ]-




# -[ class ] -
class UploadFile
{
	# -[ variables ]-
	var $iType			= 0;
	var $pDBCon			= NULL;
	var $sPath			= "xxyy";
	var $sContentTb		= "unknown";
	
	
	# -[ functions ]-
	
	//-------------------------------------------------------------------------------
	//-------------------------------------------------------------------------------
	function UploadFile (&$pDBInterfaceCon, $tb )
	{
		$this->pDBCon = &$pDBInterfaceCon;
		$this->sContentTb = $tb;
	}
	
	//-------------------------------------------------------------------------------
	//-------------------------------------------------------------------------------
	function SetPath( $path ){	return ($this->sPath=$path);}
	function GetPath() {return ($this->sPath); }
	
	
	//-------------------------------------------------------------------------------
	// Purpose: get photo data
	// Output : object / false => error
	//-------------------------------------------------------------------------------
	function GetData( $id )
	{
		$sql_query = "SELECT * FROM ".$this->sContentTb." WHERE id=$id";
		$qre = $this->pDBCon->Query( $sql_query );
		if( !$qre ) return false;
		return ($this->pDBCon->FetchObject( $qre ) );
	}
	
	//-------------------------------------------------------------------------------
	// Purpose: copy/save photo to local path
	// Output : true/false
	//-------------------------------------------------------------------------------
	function Save( $temp_file, $save_file )
	{
		# copy file
		if (copy( $temp_file, $this->sPath . $save_file ))
		{
			$obj = NULL;
			$obj->file_name = $save_file;
			$obj->created	= time();

			# insert photo id
			if( $this->pDBCon->Query( $this->pDBCon->CreateInsertQuery( $this->sContentTb, $obj ) ) )
			{
				return $this->pDBCon->InsertId();
			}
			return -1;
		}	
		return false;		
	}
	
	
	//-------------------------------------------------------------------------------
	// Purpose: delete photo with given ID 
	// Output : true/false
	//-------------------------------------------------------------------------------
	function Delete( $id )
	{
		$data = $this->GetData( $id );
		if( !$data ) return false;
		
		$sql_query = "DELETE FROM ".$this->sContentTb." WHERE id=$id";
		$qre = $this->pDBCon->Query( $sql_query );
		if( !$qre ) return false;
		
		# try to delte file
		if( delete_file( $this->sPath . $data->file_name ) )
		{
			return true;
		}
		return true;
	}
	
	
};


?>