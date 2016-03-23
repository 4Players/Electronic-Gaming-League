<?php
# ================================ Copyright © 2005-2006 Inetopia, All rights reserved. ==========================
# 
#
# Purpose:
# ================================================================================================================



# -[ defines ]-



# -[ objectlist ] -




# -[ class ] -
class Country
{
	# -[ variables ]-
	var $pDBInterfaceCon 		= NULL;
	
	# -[ functions ]-

	
	# =========================================================================
	# PUBLIC
	# =========================================================================
	
	//-------------------------------------------------------------------------------
	// Purpose: constructor
	// Output : -
	//-------------------------------------------------------------------------------
	function Country (&$pDBInterfaceCon)
	{
		$this->pDBInterfaceCon = $pDBInterfaceCon;
	}


	//-------------------------------------------------------------------------------
	// Purpose: 
	// Output :
	//-------------------------------------------------------------------------------
	function GetCountry()
	{
		$sql_query = "SELECT * FROM ".$GLOBALS['g_egltb_countries']." ORDER BY name ASC";
		$qre = $this->pDBInterfaceCon->Query( $sql_query );
		if( $qre )
			return $this->pDBInterfaceCon->FetchObject( $qre );
		return NULL;
	}


	//-------------------------------------------------------------------------------
	// Purpose:
	// Output : 
	//-------------------------------------------------------------------------------
	function GetCountries()
	{
		$sql_query = "SELECT * FROM ".$GLOBALS['g_egltb_countries']." ORDER BY name ASC";
		return $this->pDBInterfaceCon->FetchArrayObject(
									$this->pDBInterfaceCon->Query( $sql_query )
														);
	}


};

?>