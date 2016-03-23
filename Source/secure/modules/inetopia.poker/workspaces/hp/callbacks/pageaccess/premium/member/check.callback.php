<?php
# ================================ Copyright © 2005-2006 Inetopia, All rights reserved. ==========================
# 
#
# Purpose:
# ================================================================================================================


/**
* Callback-FunC : premium.member.check
*
* @param <global_vars_t>	reference to global vars
* @param array				parameters
*	array(	
			'current_permission'	=> base_access_t Object
			'permission_list'		=> array<base_access_t Object>
		 )
*
*

*/
function callback( $oVars, $params )
{

	$_PREMIUM_CODE_TIME	= 3600;
	
	//echo nl2br( print_r( $params, 1 ));
	
	
	
	# ----------------------------
	# LOGGED IN?
	# ----------------------------
	if( $oVars->bLoggedIn )
	{
		if( $oVars->oMemberData->premium_activation > 0 )
		{
			if( (EGL_TIME-$oVars->oMemberData->premium_activation) > $_PREMIUM_CODE_TIME )
			{
				// abgelaufen
				echo "Premium-Code abgelaufen";
				// -> DO NEW Premium-code activation
			}
			else
			{
				return 1;
			}
			
		}
		else
		{
			
		}
		
	}
	
	return 0;
}