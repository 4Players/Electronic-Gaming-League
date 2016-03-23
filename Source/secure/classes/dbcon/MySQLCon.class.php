<?php
# ================================ Copyright � 2005-2006 Inetopia, All rights reserved. ==========================
# 
#
# Purpose:
# ================================================================================================================



# -[ defines ]-
//...

# -[ class ] -
class MySQLCon extends DBConnection 
{
	
	
	# -[ variables ]-
	/* defined in CDBConnection
	var	$sServer		= "";
	var	$sDatabas		= "";
	var	$sUser			= "";
	var	$sPassword		= "";
	var	$hHandle	 	= NULL;
	var	$sLastError		= "No Errors";
	*/
	
	# -[ functions ]-
	
	//-------------------------------------------------------------------------------
	// Purpose: constructor
	//-------------------------------------------------------------------------------
	function MySQLCon ()
	{
	}
	
	//-------------------------------------------------------------------------------
	// Purpose: try to connect the mysql server
	//-------------------------------------------------------------------------------
	function Connect ( $server, $user, $password, $dbname=null )
	{
		if( $this->hHandle != NULL ) return false;

		// update local variables
		$this->sServer 			= $server;
		$this->sUser			= $user;
		$this->sPassword		= $password;
		$this->sDatabase		= $dbname;
	
		if( !function_exists( 'mysql_connect' ) )
		{
			DEBUG( MSGTYPE_ERROR, __FILE__, __LINE__, 'Couldn\'t execute function `mysql_connect`' );
			$this->sLastError = 'Couldn\'t execute function `mysql_connect`';
			return 0;
		}else 
		// try to connect
		$this->hHandle = @mysql_connect( $this->sServer, $this->sUser, $this->sPassword );
		
		// check for successed connecting
		if( !$this->hHandle )
		{
			$this->sLastError = 'Coudn\'t connect MySQL Server: [ERROR] ' . mysql_error();
			$this->bConnected = false;
			return 0;
		}
		else
		{
			$this->sLastError = '';
			$this->bConnected = true;
		}


		// return handle to mysql connection
		if( $this->Select_db( $this->sDatabase ) )
			return $this->hHandle;
		else
		{
			$this->sLastError = 'Coudn\'t connect MySQL Server: [ERROR] ' . mysql_error($this->hHandle);
			return NULL;
		}
		return 0;
	}
	
	
	function GetLastError()  {return $this->sLastError;}
	
	//-------------------------------------------------------------------------------
	// Purpose: try to connect the mysql database with oly settings
	//-------------------------------------------------------------------------------
	function Reconnect  ()
	{
		if( $this->hHandle != NULL ) return false;
		return $this->Connect ( $this->sServer, $this->sUser, $this->sPassword );
	}
	
	
		
	//-------------------------------------------------------------------------------
	// Purpose: try to connect the mysql database
	//-------------------------------------------------------------------------------
	function Disconnect ()
	{
		// check for connection exsists
		if( $this->hHandle != NULL ) 
		{
			if( @mysql_close( $this->hHandle ) )
			{
				$this->bConnected = false;
				$this->hHandle = NULL;
				return 1;
			}
			else
			{
				$this->sLastError = 'Coudn\'t disconnect from the MySQL Server: [ERROR] ' . mysql_error($this->hHandle);
			}
			return 0;
		}
		else return -1;
	}	
	
	//-------------------------------------------------------------------------------
	// Purpose: return current connected status
	//-------------------------------------------------------------------------------
	function Connected ()
	{
		if( !$this->hHandle ) return false;
		else return true;
	}
	
	
	//-------------------------------------------------------------------------------
	// Purpose: return last automatic created id by incrematical counter
	//-------------------------------------------------------------------------------
	function InsertId()
	{
		if( ($insert_id = @mysql_insert_id( $this->hHandle )))
			return $insert_id;
		else 
			$this->sLastError = 'Coudn\'t fetch insert-id from MySQL: [ERROR] ' . mysql_error($this->hHandle);
		return 0;	
	}

	
	//-------------------------------------------------------------------------------
	// Purpose: try to select the given db
	//-------------------------------------------------------------------------------
	function Select_db ( $db )
	{
		if( $this->hHandle == NULL ) return false;
		if( @mysql_select_db( $db, $this->hHandle ) )
			return true;
		else 
			$this->sLastError = 'Coudn\'t select MySQL-db `'.$db.'`: [ERROR] ' . mysql_error($this->hHandle);
		return false;
	}
	
	
	//-------------------------------------------------------------------------------
	// Purpose: request a query from current connection
	//-------------------------------------------------------------------------------
	function Query ( $query )
	{
		if( $this->hHandle == NULL ) 
		{
			DEBUG( MSGTYPE_ERROR, __FILE__, __LINE__, "DB-Query error occured by calling unknown[NULL] database object: ".$query );
			return NULL;
		}
		$this->last_result = $result = @mysql_query( $query, $this->hHandle );
		if( !$result )
		{
			$this->sLastError = mysql_error( $this->hHandle );
			$query_report = $query;
			$query_report = str_replace( 'SELECT', 		"\nSELECT", $query_report );
			$query_report = str_replace( 'FROM', 		"\nFROM", $query_report );
			$query_report = str_replace( 'LEFT JOIN', 	"\nLEFT JOIN", $query_report );
			$query_report = str_replace( 'WHERE', 		"\nWHERE", $query_report );
			$query_report = str_replace( 'ORDER', 		"\nORDER", $query_report );
			$query_report = str_replace( 'LIMIT', 		"\nLIMIT", $query_report );
			
			DEBUG( MSGTYPE_ERROR, __FILE__, __LINE__, str_replace( "\n","<br/>", "Couldn't execute Query:\n ".$query_report.$this->sLastError."\nERROR {".mysql_errno($this->hHandle).'}' )); 
		}
		else
		{
			DEBUG( MSGTYPE_QUERY, __FILE__, __LINE__, $query);
		}
		return $result;
	}
	
	
	//-------------------------------------------------------------------------------
	// Purpose: return the count of the affected rows
	//-------------------------------------------------------------------------------
	function AffectedRowCount()
	{
		if( $this->hHandle == NULL ) return -1;
		return  @mysql_affected_rows( $this->hHandle );
	}
	
	
	/**
	* MySQLCon::FreeResult()
	*
	*/
	function FreeResult( $result )
	{
		if( $result ) return @mysql_freeresult($result);
		return 0;
	}
	
	
	# ============================================================================================
	# static public
	# ============================================================================================

	//-------------------------------------------------------------------------------
	// Purpose: return array containing the object result
	//-------------------------------------------------------------------------------	
	function FetchArrayObject( $result )
	{
		if( $result )
		{
			$aArray = array();
			$iCounter = 0;
			
			$data = NULL;
			while( ($data= @mysql_fetch_object( $result )) )
			{
				$aArray[$iCounter] = $data;
				$iCounter++;
			}
			if( $iCounter > 0 ) return $aArray;
		}
		return NULL;
	}

	
	
	//-------------------------------------------------------------------------------
	// Purpose: return result object
	//-------------------------------------------------------------------------------	
	function FetchObject( $result )
	{
		if( $result)
		{
			return( @mysql_fetch_object( $result ) );
		} return NULL;
	}
	
	
	
	//-------------------------------------------------------------------------------
	// Purpose: return  result row
	//-------------------------------------------------------------------------------	
	function FetchRow( $result )
	{
		if( $result)
		{
			return( @mysql_fetch_row( $result ) );
		} return NULL;
	}
	
	//-------------------------------------------------------------------------------
	// Purpose: return  result row
	//-------------------------------------------------------------------------------	
	function FetchArray( $result )
	{
		if( $result)
		{
			return( @mysql_fetch_array( $result ) );
		} return NULL;
	}	
	
	//-------------------------------------------------------------------------------
	// Purpose: return  result row
	//-------------------------------------------------------------------------------	
	function GetTableList(){
		$aTables = array();
		if( strlen($this->sDatabase) > 0 ){
			$result = @mysql_list_tables( $this->sDatabase );
			while( $row = $this->FetchRow($result) ){
				$aTables[sizeof($aTables)] = $row[0];
			}//if
		}//if
		return $aTables;
	}
	
	
	//-------------------------------------------------------------------------------
	// Purpose:
	//-------------------------------------------------------------------------------
	function EscapeString( $str )
	{
		if(	version_compare(phpversion(),"4.3.0")=="-1") 
		{
			return @mysql_escape_string($str);
		} //if
		else 
		{
			return @mysql_real_escape_string($str);
	   	} //if
	}
		

};



# FORCED BY ENGINE => otherwise ERROR while loading
 // return EGL_MODULE_AVAILABLE;

?>