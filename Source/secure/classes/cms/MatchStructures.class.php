<?php
# ================================ Copyright © 2005-2006 Inetopia, All rights reserved. ==========================
# 
#
# Purpose:
# ================================================================================================================



# -[ defines ]-



# -[ objectlist ] -




# -[ class ] -
class MatchStructures
{
	# -[ variables ]-
	var $pDBInterfaceCon	= NULL;
	
	# -[ functions ]-
	
	
	# =========================================================================
	# PUBLIC
	# =========================================================================
	
	//-------------------------------------------------------------------------------
	// Purpose: constructor
	// Output : -
	//-------------------------------------------------------------------------------
	function MatchStructures ( &$pDBInterfaceCon )
	{
		$this->pDBInterfaceCon = &$pDBInterfaceCon;
	}
	
	
	
	//-------------------------------------------------------------------------------
	// Purpose: 
	// Output : object of match_structure
	//-------------------------------------------------------------------------------
	function GetMatchStructure( $ms_id )
	{
		$sql_query = "SELECT * FROM `".$GLOBALS['g_egltb_match_structures']."` AS match_structures WHERE id=".(int)$ms_id."";
		$qre = $this->pDBInterfaceCon->Query( $sql_query );
		return $this->pDBInterfaceCon->FetchObject( $qre );
	}
	
	
	
	//-------------------------------------------------------------------------------
	// Purpose: 
	// Output : arraylist of match_structure objects
	//-------------------------------------------------------------------------------
	function GetMatchStructures()
	{
		$sql_query 	= " SELECT * FROM `".$GLOBALS['g_egltb_match_structures']."` AS match_structures".
					  " ORDER BY game_id ASC, created DESC";
		$qre = $this->pDBInterfaceCon->Query( $sql_query );
		return $this->pDBInterfaceCon->FetchArrayObject( $qre );
	}
	
	
	
	
	//-------------------------------------------------------------------------------
	// Purpose: 
	// Output :
	//-------------------------------------------------------------------------------
	function AddStructure( $obj )
	{
		# creat insert query + execute => return true/false
		$sql_query = $this->pDBInterfaceCon->CreateInsertQuery( $GLOBALS['g_egltb_match_structures'], $obj );
		return ($this->pDBInterfaceCon->Query( $sql_query ) );
	}
	
	
	
	//-------------------------------------------------------------------------------
	// Purpose: 
	// Output :
	//-------------------------------------------------------------------------------
	function DeleteStructure( $structure_id )
	{
		$sql_query = "DELETE FROM `".$GLOBALS['g_egltb_match_structures']."` WHERE id=".(int)$structure_id." ";
		return $this->pDBInterfaceCon->Query( $sql_query );
	}
	
	
	
	#------------------------------------------------------------------------------
	# Purpose: 
	#------------------------------------------------------------------------------
	function SetStructureData( $data, $ms_id )
	{
		$sql_query = 	$this->pDBInterfaceCon->CreateUpdateQuery( $GLOBALS['g_egltb_match_structures'], $data ) . 
						" WHERE id=".(int)$ms_id."";
		# execute query
		return $this->pDBInterfaceCon->Query( $sql_query );
	}
	
	
};

?>