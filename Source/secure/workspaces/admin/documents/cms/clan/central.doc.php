<?php

	global $gl_oVars;
	
	# ---------------
	$iClanId	= (int)$_GET['clan_id'];
	


	# define & declare objects & classes
	$cClan = new Clan( $gl_oVars->cDBInterface );

	$oClan = $cClan->GetClanById( $iClanId );
	

	
	
	$gl_oVars->cTpl->assign( "clan", $oClan );
?>