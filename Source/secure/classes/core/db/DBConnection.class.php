<?php
# ================================ Copyright © 2005-2006 Inetopia, All rights reserved. ==========================
# 
#
# Purpose:
# ================================================================================================================



# -[ defines ]-



# -[ objectlist ] -




# -[ class ] -
class DBConnection
{
	# -[ variables ]-
	var	$sServer		= "";
	var	$sDatabase		= "";
	var	$sUser			= "";
	var	$sPassword		= "";
	var	$hHandle	 	= NULL;
	var	$sLastError		= "no errors";
	var $last_result	= NULL;
	var $bConnected		= false;

	# -[ functions ]-
	
	# =========================================================================
	# PUBLIC
	# =========================================================================
	
	//-------------------------------------------------------------------------------
	// Purpose: constructor
	// Output : -
	//-------------------------------------------------------------------------------
	function DBConnection ()
	{
	}
	

	
	//-------------------------------------------------------------------------------
	// Purpose: constructor
	// Output : -
	//-------------------------------------------------------------------------------
	function  __OpenConnection( $db_connection )
	{
		if( get_class($db_connection) == 'db_connecting_data')
		{
			if( !$this->Connect( $db_connection->server, $db_connection->username, $db_connection->password, $db_connection->database ) )
			{
				//DEBUG( MSGTYPE_WARNING, __FILE__, __LINE__, "CDBConnection::__OpenConnection(); Couldn't connect DB [{$this->sLastError}]" );
				return 0;
			}
			
			
			/*
			EXPORTED TO CDBConnection::Connect
			// only for connection-types using extra db selections (mysql)
			if( !$this->Select_db( $db_connection->database ) )
			{
				DEBUG( MSGTYPE_ERROR, __FILE__, __LINE__, "CDBConnection::__OpenConnection(); Couldn't select DB" );
				$this->Disconnect();
				return 0;
			}
			*/
			
			return 1;
		}
		else
		{
			DEBUG( MSGTYPE_ERROR, __FILE__, __LINE__, "DatabaseConnectingData must be typed by `db_connecting_data`" );
			return 0;
		}
	}
	
	function Connect ( $server, $user, $password, $dbname=null ) {return 0;}
	function FetchObject( $result ) { return 0; }
	function FetchArrayObject( $result ){ return 0; }
	function FetchArray( $result ) { return 0; }
	function FetchRow( $result ) { return 0; }
	
	function AffectedRowCount(){return 0;}
	function Query ( $query ){return 0;}
	function InsertId(){return -1;}
	function Select_db ( $db ){ return 0;}
	function GetLastError()  { return "function not included"; }
	function FreeResult($result) { return 0; }
		
	//-------------------------------------------------------------------------------
	// Purpose: create mysql update query => object / array
	//-------------------------------------------------------------------------------
	function CreateUpdateQuery( $tb, $obj  )
	{
		$update 	= "";
		
		# list vars	
		$vars = NULL;
		if( is_object( $obj ))
			$vars = get_object_vars( $obj );
		elseif( is_array($obj))$vars = $obj;
		else return 'error';
		
		# list array vars
		while( list($var_name, $var_value) = each($vars) ) 
		{
			$update .= '`'.$var_name.'`="'.$this->EscapeString($var_value).'",';	
		}
	
		if( strlen($update) > 0 ) $update = substr( $update, 0, strlen($update)-1 );
		else return "";

		return "UPDATE `".$tb."` SET ".$update." ";		# + extern where clausel
	}
	
	
	//-------------------------------------------------------------------------------
	// Purpose: create mysql insert query => object / array
	//-------------------------------------------------------------------------------
	function CreateInsertQuery( $tb, $obj )
	{
		$insert_str 	= "";
		$values_str		= "";
		
		$vars = NULL;
		if( is_object( $obj ))
			$vars = get_object_vars( $obj );
		elseif( is_array($obj))$vars = $obj;
		else return 'error';

		// ...
		while( list($var_name, $var_value) = each($vars) ) 
		{
			$insert_str .= '`'.$var_name.'`,';	
			$values_str .= '"'.$this->EscapeString($var_value).'",';
		}//while
		
	
		if( strlen($insert_str) > 0 ) $insert_str = substr( $insert_str, 0, strlen($insert_str)-1 ); else return "";
		if( strlen($values_str) > 0 ) $values_str = substr( $values_str, 0, strlen($values_str)-1 ); else return "";
		
		return "INSERT INTO `".$tb."` ({$insert_str})VALUES(".$values_str.")";
	}
	
	
	
	//-------------------------------------------------------------------------------
	// Purpose: create mysql select query
	//-------------------------------------------------------------------------------
	function CreateSelectQuery( $tb, $obj, $all_fields=NULL, $b_or=NULL, $advanced_clausel=NULL, $counter=false, $compare_function='' )
	{
		$select_fields = "";
		$where_clausel = "";
		
		$vars = NULL;
		if( is_object( $obj ))
			$vars = get_object_vars( $obj );
		elseif( is_array($obj))$vars = $obj;
		else return 'error';
		
		while( list($var_name, $var_value) = each($vars) ) 
		{
			# only valued items ?
			if( !$all_fields )
			{
				# fields
				$select_fields .= $var_name . ",";	
			}
			
			# compare function
			if( strlen($compare_function) > 0 )
			{
				$where_clausel .= str_replace( '$VALUE', $this->EscapeString($var_value), 	str_replace( '$VAR', $var_name, $compare_function ) )."#";
			}
			else
			{
				$where_clausel .= '`'.$var_name.'`="'.$this->EscapeString($var_value).'"#';
			}//if
			
		}//while

		if($all_fields) $select_fields=" * ";
		
		/* set all_field as select_fields*/ 
		if( strlen($all_fields) > 3 )
		{
			$select_fields = $all_fields;
		}//if
		
		else if( strlen($select_fields) > 0 ) $select_fields = substr( $select_fields, 0, strlen($select_fields)-1 ); else return "";
			
		# correct where clausel
		if( strlen($where_clausel) > 0 ) $where_clausel = substr( $where_clausel, 0, strlen($where_clausel)-1 ); else return "";

		# and / or clausel
		if( $b_or ) ($where_clausel=str_replace( '#', ' OR ', $where_clausel ));
		else ($where_clausel=str_replace( '#', ' AND ', $where_clausel ));
		
		# is counter ??
		if( $counter )
			$select_fields = "COUNT(*) AS row_count";
		
		return  "SELECT $select_fields FROM ".$tb." WHERE $where_clausel $advanced_clausel ";
	}
	


	//-------------------------------------------------------------------------------
	// Purpose: create mysql search query [where]
	//-------------------------------------------------------------------------------
	function Create_WHERE_String( $compare_function, $obj, $bOR=false )
	{
		$vars = array();
		if( is_object( $obj ))
			$vars = get_object_vars( $obj );
		elseif( is_array($obj))$vars = $obj;
		else return 'error';
		
		while( list($var_name, $var_value) = each($vars) ) 
		{
		
			# compare function
			if( strlen($compare_function) > 0 )
			{
				$where_clausel .= str_replace( '$VALUE', $this->EscapeString($var_value), 	str_replace( '$VAR', $var_name, $compare_function ) )."#";
			}
			else
			{
				$where_clausel .= $var_name."='".$this->EscapeString($var_value)."'#";
			}//if
			
		}//while
		# correct where clausel
		if( strlen($where_clausel) > 0 ) $where_clausel = substr( $where_clausel, 0, strlen($where_clausel)-1 ); else return "";
		
		# and / or clausel
		if( $bOR ) ($where_clausel=str_replace( '#', ' OR ', $where_clausel ));
		else ($where_clausel=str_replace( '#', ' AND ', $where_clausel ));
		
		return $where_clausel;
	}
	
	
	//-------------------------------------------------------------------------------
	// Purpose:
	//-------------------------------------------------------------------------------
	function CreateHTMLOutput( $result )
	{
		if( !$result ) return  'ERROR: Could not evaluate result - unknown result';

		$html_buffer .= "<!-- SQLResultViewer MRV, started! -->\n";
		$html_buffer .= "<table border=0 cellpadding=4 cellspacing=1 bgcolor='#F5F5F5'>\n";
		
		# fetch array of results
		$aResults = $this->FetchArrayObject( $result );
		
		if( sizeof($aResults) == 0 ) return  'no results';
		$oFields = $aResults[0];	# get 0;

		# write fields
		$vars = NULL;
		if( is_object( $oFields ) ) $vars = get_object_vars( $oFields );
		else $vars = $oFields;
		$html_buffer .= "<tr bgcolor='#D3DCE3'>\n";
		$html_buffer .= "<td width='1' bgcolor='#FFCC99'><font face='arial' color='#A2AD87'>Index</font></td>\n";
		$num_fields=0;
		while( list($var_name, $var_value) = each($vars) ) 
		{
			$html_buffer .= "<td><font color='#000000' face='arial'><b>".htmlspecialchars($var_name)."</b></font></td>\n";
			$num_fields++;
		}
		$html_buffer .= "</tr>\n";
		
		
		
		# write rows
		for( $row=0; $row < sizeof($aResults); $row++ )
		{
			$vars = NULL;
			if( is_object( $aResults[$row] ))
				$vars = get_object_vars( $aResults[$row] );
			else $vars = $aResults[$row];

			# set row color
			if( $row % 2 == 0 )
				$html_buffer .= "<tr onmouseover=\"javascript:this.style.backgroundColor='#CCFFCC';\" onmouseout=\"javascript:this.style.backgroundColor='#E5E5E5';\" bgcolor='#E5E5E5'>\n";
			else
				$html_buffer .= "<tr onmouseover=\"javascript:this.style.backgroundColor='#CCFFCC';\" onmouseout=\"javascript:this.style.backgroundColor='#D5D5D5';\" bgcolor='#D5D5D5'>\n";
			$html_buffer .= "<td align='center' bgcolor='#FFCC99'><font face='arial' color='#000000'><i>".$row."</i></font></td>\n";
			while( list($var_name, $var_value) = each($vars) ) 
				$html_buffer .= "<td><font color='#000000'>".htmlspecialchars($var_value)."</font></td>\n";
			$html_buffer .= "</tr>";
		}//for
		
		$html_buffer .= "<tr><td colspan=(".($num_fields+1).")><font face='arial' size=1 face='arial' color='#000000'> <b>MysqlResultViewer</b>, Copyright &copy; 2005 <A _target='_blank' href='http://www.inetopia.de'><font size=1 face='arial' color='#000000'>Inetopia</font></a>, All rights reserved.</font></td></tr>\n";
		$html_buffer .= "</table>\n";
		
		$html_buffer .= "<!-- SQL ResultViewer MRV, Closed! Copyright(c)2006 Inetopia -->\n\n";
		return $html_buffer;
	}// CreateHTMLOutput
	
	

	
	//-------------------------------------------------------------------------------
	// Purpose:
	//-------------------------------------------------------------------------------
	function EscapeString( $str )
	{
		return "no escape functionality";
	}
	
	/*
	//-------------------------------------------------------------------------------
	// Purpose:
	//-------------------------------------------------------------------------------
	function EscapeRealString( $str )
	{
		return mysql_real_escape_string( $str );
	}	*/
};


?>