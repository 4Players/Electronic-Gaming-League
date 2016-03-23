<?php
	global $gl_oVars;

	$cPremiumCore = new PremiumCore( $gl_oVars->cDBInterface );
	
	
	//$cPremiumCore->RefreshPremiumAccounts(); wird bereits beim laden des moduls ausgeführt

	// fetch codes
	$aActivatedCodes 	= $cPremiumCore->getActivatedCodes( PARTTYPE_MEMBER, $gl_oVars->iMemberId );
	$aPackages			= $cPremiumCore->GetPremiumAccess( PARTTYPE_MEMBER, $gl_oVars->iMemberId  );
	
	for( $i=0; $i < sizeof($aPackages); $i++ ){
		$aPackages[$i]->expired = ($aPackages[$i]->first_activation+$aPackages[$i]->access_time*60);
	}
	
	$gl_oVars->cTpl->assign( 'PACKAGES', $aPackages );
	$gl_oVars->cTpl->assign( 'activated_codes', $aActivatedCodes );
?>