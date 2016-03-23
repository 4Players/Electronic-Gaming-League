<?php
# ================================ Copyright © 2005-2006 Inetopia, All rights reserved. ==========================
# 
#
# Purpose:
# ================================================================================================================



# -[ defines ]-
//...


# -[ class ] -
class PostgreSQLCon extends DBConnection 
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
	function PostgreSQL ()
	{
	}
	
	//-------------------------------------------------------------------------------
	// Purpose: try to connect the postgreSQL server
	//-------------------------------------------------------------------------------
	function Connect ( $server, $user, $password, $dbname=null )
	{
		if( $this->hHandle != NULL ) return false;

		// update local variables
		$this->sServer 		= $server;
		$this->sUser		= $user;
		$this->sPassword	= $password;
		$this->sDatabase	= $dbname;
		
		// try to connect
		if( egl_extension_loaded( "php_pgsql" ) )
		{
			$this->hHandle = pg_connect( "host={$this->sServer} port=5432 dbname={$this->$this->sDatabase} user={$this->sUser} password={$this->sPassword}  ");
		
			// check for successed connecting
			if( !$this->hHandle )
				$this->sLastError = "Coudn't connect postgreSQL: [ERROR]";
			else
				$this->sLastError = "";
		
			// return handle to postgresql connection
			return $this->hHandle;
		}//if
		else
		{
			$this->sLastError = "PHP-Extension `php_pgsql` not loaded";
			return false;
		}
	}
	
	
	function GetLastError()  { return $this->sLastError; }
	
	//-------------------------------------------------------------------------------
	// Purpose: try to connect the postgreSQL database with oly settings
	//-------------------------------------------------------------------------------
	function Reconnect  ()
	{
		if( $this->hHandle != NULL ) return false;
		return $this->Connect ( $this->sServer, $this->sUser, $this->sPassword );
	}
	
	
		
	//-------------------------------------------------------------------------------
	// Purpose: try to connect the postgreSQL database
	//-------------------------------------------------------------------------------
	function Disconnect ()
	{
		// check for connection exsists
		if( $this->hHandle != NULL ) 
		{
			if( @pg_close( $this->hHandle ) )
			{
				$this->hHandle = NULL;
				$this->last_result = NULL;
				return 1;
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
		if( !$this->Handle) return false;
		else return @pg_get_pid( $this->hHandle );
	}

	
	//-------------------------------------------------------------------------------
	// Purpose: try to select the given db
	//-------------------------------------------------------------------------------
	function Select_db ( $db )
	{
		/*
		if( $this->hHandle == NULL ) return false;
		return @pg_( $db, $this->hHandle );
		*/
		return 1;
	}
	
	
	//-------------------------------------------------------------------------------
	// Purpose: request a query from current connection
	//-------------------------------------------------------------------------------
	function Query ( $query )
	{
		//global $query_counter;
		//lobal $query_list;
		
		//$query_counter++;
		//$query_list[sizeof($query_list)] = $query;
		
		if( $this->hHandle == NULL ) 
			return NULL;
		$result = pg_query( $this->hHandle, $query );
		if( !$result ) 
		{
			$this->sLastError = pg_errormessage( $this->hHandle );
		}
		return $result;
	}
	
	
	//-------------------------------------------------------------------------------
	// Purpose: return the count of the affected rows
	//-------------------------------------------------------------------------------
	function AffectedRowCount()
	{
		if( $this->hHandle == NULL || $this->last_result == NULL) 
			return NULL;
		return  @pg_affected_rows( $this->last_result );
	}
	
	
	function FreeResult( $result )
	{
		if( !$this->Handle) return false;
		else 
			if( $result ) 
				return pg_freeresult($result);
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
		if( !$this->Handle) return NULL;
		
		$aArray = array();
		$iCounter = 0;
		
		$data = NULL;
		while( ($data= @pg_fetch_object( $result )) )
		{
			$aArray[$iCounter] = $data;
			$iCounter++;
		}
		if( $iCounter > 0 ) return $aArray;
		return NULL;
	}

	
	
	//-------------------------------------------------------------------------------
	// Purpose: return the result object
	//-------------------------------------------------------------------------------	
	function FetchObject( $result )
	{
		if( !$this->Handle) return NULL;
		return( @pg_fetch_object( $result ) );
	}
	
		

	
	//-------------------------------------------------------------------------------
	// Purpose:
	//-------------------------------------------------------------------------------
	function EscapeString( $str )
	{
		if( !$this->Handle) return NULL;
		return pg_escape_string($str);
	}	
};



# FORCED BY ENGINE => otherwise ERROR while loading
return EGL_MODULE_AVAILABLE;

?>