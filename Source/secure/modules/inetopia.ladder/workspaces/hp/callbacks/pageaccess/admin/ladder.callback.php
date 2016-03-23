<?php
# ================================ Copyright  2005-2006 Inetopia, All rights reserved. ==========================
# 
#
# Purpose: Callback-Check for PageAccess Manageer
# ================================================================================================================

function callback( $oVars, $params )
{
	/**
	 * $params
	 * 		=> data		: permission-list
	 */
	if( !isset($_GET['ladder_id']) )
	{
		return 1;
	}
	else
	{
		if( isset($params['current_permission']) > 0 ){
			if( (int)$params['current_permission']->data == $_GET['ladder_id'] ){
				return 1;
			}
			else if( $params['current_permission']->data == 'all' ){
				return 1;
			}
		}//if
	}//if
	return 0;
}//function
?>