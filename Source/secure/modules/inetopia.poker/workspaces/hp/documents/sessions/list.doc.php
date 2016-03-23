<?php
	global $gl_oVars;
	
	
	$cPokerSessions = new PokerSessions( $gl_oVars->cDBInterface );
	$aPokerSessions = $cPokerSessions->GetSessions();
	
	
	
	$gl_oVars->cTpl->assign( 'poker_sessions', $aPokerSessions );
?>