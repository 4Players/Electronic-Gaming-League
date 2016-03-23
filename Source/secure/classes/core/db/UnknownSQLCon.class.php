<?php
# ================================ Copyright © 2005-2006 Inetopia, All rights reserved. ==========================
# 
#
# Purpose:
# ================================================================================================================



# -[ defines ]-
//...

# -[ class ] -
class UnknownSQLCon extends DBConnection 
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
	function UnknownSQLCon ()
	{
	}
	
	//-------------------------------------------------------------------------------
	// Purpose: try to connect the mysql server
	//-------------------------------------------------------------------------------
	function Connect ( $server, $user, $password, $dbname=null )
	{
		DEBUG( MSGTYPE_ERROR, __FILE__, __LINE__, "DBInterface::Connect() failed - unknown object" );
		return 0;
	}
	
	
	function GetLastError()  {return $this->sLastError;}
	
	//-------------------------------------------------------------------------------
	// Purpose: try to connect the mysql database with oly settings
	//-------------------------------------------------------------------------------
	function Reconnect  ()
	{
		DEBUG( MSGTYPE_ERROR, __FILE__, __LINE__, "DBInterface::Reconnect() failed - unknown object" );
		return 0;
	}
	
	
		
	//-------------------------------------------------------------------------------
	// Purpose: try to connect the mysql database
	//-------------------------------------------------------------------------------
	function Disconnect ()
	{
		DEBUG( MSGTYPE_ERROR, __FILE__, __LINE__, "DBInterface::Disconnect() failed - unknown object" );
		return 0;
	}	
	
	//-------------------------------------------------------------------------------
	// Purpose: return current connected status
	//-------------------------------------------------------------------------------
	function Connected ()
	{
		DEBUG( MSGTYPE_ERROR, __FILE__, __LINE__, "DBInterface::Connected() failed - unknown object" );
		return 0;

	}
	
	
	//-------------------------------------------------------------------------------
	// Purpose: return last automatic created id by incrematical counter
	//-------------------------------------------------------------------------------
	function InsertId()
	{
		DEBUG( MSGTYPE_ERROR, __FILE__, __LINE__, "DBInterface::Connected() failed - unknown object" );
		return 0;
	}

	
	//-------------------------------------------------------------------------------
	// Purpose: try to select the given db
	//-------------------------------------------------------------------------------
	function Select_db ( $db )
	{
		DEBUG( MSGTYPE_ERROR, __FILE__, __LINE__, "DBInterface::Connected() failed - unknown object" );
		return 0;
	}
	
	
	//-------------------------------------------------------------------------------
	// Purpose: request a query from current connection
	//-------------------------------------------------------------------------------
	function Query ( $query )
	{
		DEBUG( MSGTYPE_ERROR, __FILE__, __LINE__, "DBInterface::Query() failed - unknown object" );
		return 0;

	}
	
	
	//-------------------------------------------------------------------------------
	// Purpose: return the count of the affected rows
	//-------------------------------------------------------------------------------
	function AffectedRowCount()
	{
		DEBUG( MSGTYPE_ERROR, __FILE__, __LINE__, "DBInterface::AffectedRowCount() failed - unknown object" );
		return 0;
	}
	
	
	
	function FreeResult( $result )
	{
		DEBUG( MSGTYPE_ERROR, __FILE__, __LINE__, "DBInterface::FreeResult() failed - unknown object" );
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
		DEBUG( MSGTYPE_ERROR, __FILE__, __LINE__, "DBInterface::FetchArrayObject() failed - unknown object" );
		return 0;

	}

	
	
	//-------------------------------------------------------------------------------
	// Purpose: return the result object
	//-------------------------------------------------------------------------------	
	function FetchObject( $result )
	{
		DEBUG( MSGTYPE_ERROR, __FILE__, __LINE__, "DBInterface::FetchObject() failed - unknown object" );
		return 0;

	}
	
	
	//-------------------------------------------------------------------------------
	// Purpose: return the result object
	//-------------------------------------------------------------------------------	
	function FetchRow( $result )
	{
		DEBUG( MSGTYPE_ERROR, __FILE__, __LINE__, "DBInterface::FetchRow) failed - unknown object" );
		return 0;	
	}
	
	function GetTableList(){ return array(); }
	
	//-------------------------------------------------------------------------------
	// Purpose:
	//-------------------------------------------------------------------------------
	function EscapeString( $str )
	{
		DEBUG( MSGTYPE_ERROR, __FILE__, __LINE__, "DBInterface::EscapeString() failed - unknown object" );
		return 0;

	}
		

};



# FORCED BY ENGINE => otherwise ERROR while loading
// return EGL_MODULE_AVAILABLE;

?>