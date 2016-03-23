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
	if( $oVars->bLoggedIn )
	{
		// fetch,paramlist, given in the pageaccessmanagement
		$oparam = parseParameterString($params['parameters']);
	
		$iPackageId = (int)$oparam['package_id'];
		$iMemberId  = (int)$oVars->iMemberId;
		
	
		// module installed & activated
		if( $oVars->cModuleManager->ModuleActivated( '9C8010A6-3576-4ba3-9A97-95739C043B1A' ) )
		{
			$cPremiumCore = new PremiumCore( $oVars->cDBInterface );
			
			$oSum = $cPremiumCore->GetPremiumPackageAccess( $iPackageId, PARTTYPE_MEMBER, $iMemberId );
			if( $oSum->access_time*60 > EGL_TIME-$oSum->first_activation )
			{
				//$expired_time = $oPrem->first_activation+$oPrem->access_time*60;
				//echo "Access bis: ".strftime( "%H:%M:%S", $expired_time );
				return 1;
			}
			else
			{
				// setting up-expired
				//module_sendmessage( '9C8010A6-3576-4ba3-9A97-95739C043B1A', 'update_code', $__DATA__ );
				return -1;
			}
			
		}//if module,premium activated
		
	}//logged in
	return -1;
}