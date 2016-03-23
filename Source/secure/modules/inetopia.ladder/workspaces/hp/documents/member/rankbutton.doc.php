<?php
	global $gl_oVars;
	
	$cLadderSystem = new InetopiaLadder( $gl_oVars->cDBInterface );
	
	
	// fetch member-data
	$aLadders = $cLadderSystem->GetJoined1on1LadderByMemberId( $gl_oVars->iMemberId );
	$gl_oVars->cTpl->assign( 'LADDERS', $aLadders );
	$gl_oVars->cTpl->assign( 'MEMBER_ID', $gl_oVars->iMemberId  );
?>