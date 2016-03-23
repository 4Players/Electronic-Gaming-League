<?php
function callback( $oVars, $params )
{
	# ----------------------------
	# LOGGED IN?
	# ----------------------------
	if( isset($_GET['member_id']) &&isset($_GET['code']) )
	{
		$cMember	= new Member( $oVars->cDBInterface );
		$oMember = $cMember->GetMemberDataById( (int)$_GET['member_id'] );
		
		if( strlen($oMember->activation_code) > 0 && $oMember->activation_code == $_GET['code'] )
			return 1;
	}
	return 0;
}