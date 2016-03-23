<?php
# ================================ Copyright © 2005-2006 Inetopia, All rights reserved. ==========================
# 
#
# Purpose:
# ================================================================================================================


# -[ defines ]-




# -[ class ] -
class SQLDump
{
	var $pDBInterface = NULL;
	# -[ variables ]-
	
	# -[ functions ]-

	/**
	* Concstructor
	*
	**/
	function SQLDump ( $pDBCon )
	{
		$this->pDBInterface = &$pDBCon;
	}

	
	
	
	
	
	/**
	* Dump single DB table
	* 
	* @param 	string	table name
	* @return	string	sql 
	**/
	function Dump_Table( $tb_name )
	{
		$DBResult = $this->pDBInterface->Query( " SELECT * FROM `{$tb_name}`" );
	}
};

?>