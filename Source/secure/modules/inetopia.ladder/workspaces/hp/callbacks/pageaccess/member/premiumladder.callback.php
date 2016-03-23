<?php
# ================================ Copyright  2005-2006 Inetopia, All rights reserved. ==========================
# 
#
# Purpose: Callback-Check - Checking LadderJoined
# ================================================================================================================

function callback( $oVars, $params )
{
	/**
	 * $params
	 * 		=> data		: permission-list
	 */
	if( $oVars->bLoggedIn )
	if( isset($_GET['ladder_id']) )
	{
		// fetch,paramlist, given in the pageaccessmanagement
		$oparam = parseParameterString($params['parameters']);

		$iLadderId 	= (int)$_GET['ladder_id'];
		
		$iPremLadder= (int)$oparam['ladder_id'];
		$iPackageId = (int)$oparam['package_id'];
		$iMemberId  = (int)$oVars->iMemberId;
		
		/*
			Ladder?
		*/
		if( $iPremLadder != $iLadderId )
		{
			return 0;
		}
		
		$cLadderSystem = new InetopiaLadder( $oVars->cDBInterface );
		if( $cLadderSystem->IsEnteredLadder( $iLadderId, $oVars->iMemberId ) )
		{	
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
		}// ladder joined?
						
	}//if
	
	return -1;
}//function
?>