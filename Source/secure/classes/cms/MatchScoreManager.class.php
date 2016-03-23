<?php
# ================================ Copyright © 2005-2006 Inetopia, All rights reserved. ==========================
# 
#
# Purpose:
# ================================================================================================================



# -[ defines ]-



# -[ objectlist ] -




# -[ class ] -
class MatchScoreManager
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
	function MatchScoreManager (&$pDBCon)
	{
		$this->pDBCon = $pDBCon;
	}
	
	
	//-------------------------------------------------------------------------------
	// Purpose:
	// Output :
	//-------------------------------------------------------------------------------
	function ComputeFinale( $oMatch )
	{
		$cMatchStrucure = new MatchStructures( $this->pDBCon );
		$cMatchStrucure->GetMatchStructure( $oMatch->matchstrucutre_id );
		
		//$oMatch
		
	}//function

};
?>