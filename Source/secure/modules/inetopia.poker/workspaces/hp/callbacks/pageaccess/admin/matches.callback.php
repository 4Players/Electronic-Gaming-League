<?php
# ================================ Copyright © 2005-2006 Inetopia, All rights reserved. ==========================
# 
#
# Purpose:
# ================================================================================================================


/**
* Callback-FunC : admin.matches
*
* @param <global_vars_t>	reference to global vars
* @param array				parameters
*/
function callback( $oVars, $params )
{
	# 1. Fall: keine module_id
	if( $params->module_id == EGL_NO_ID )
	{
		return 1; // ja access
	}
	# 2. Fall: module_id, kein data(module_entity_id)
	else if( $params->module_id != EGL_NO_ID &&  (int)$params-data == 0 )
	{
		$iMatchId 	= (int)$_GET['match_id'];
		$oMatch 	= NULL;
		if( $iMatchId )
		{
			$cMatch = new Match( $oVars->cDBInterface, $iMatchId );
			$oMatch = $cMatch->GetData();
			
			if( $params->module_id == $oMatch->module_id )
			{
				return 1;
			}//if
		}//if
	}
	# 3. Fall module_id, data avaialbe(entity_id) 
	else if( $params->module_id != EGL_NO_ID &&  (int)$params-data > 0 )
	{
		$iMatchId 	= (int)$_GET['match_id'];
		$oMatch 	= NULL;
		if( $iMatchId )
		{
			$cMatch = new Match( $oVars->cDBInterface, $iMatchId );
			$oMatch = $cMatch->GetData();
			
			# correct match ?
			if( $oMatch->module_entry_id == $params->data )
			{
				return 1;
			}
		
			// return module_sendmessage( $params->module_id, 'match_entityid_check', $__DATA__, (int)$params->data );
		}//if
	}
	
	return 0;
}//function
?>