<?php
	global $gl_oVars;
	
	
	$iLadderId	= (int)$_GET['ladder_id'];

	# declare objects/classes
	$cLadderSystem	= new InetopiaLadder( $gl_oVars->cDBInterface );
	
	# fetch data
	$oLadder = $cLadderSystem->GetLadderbyID( $iLadderId );
	
	$gl_oVars->cTpl->assign( 'ladder', $oLadder );

?>