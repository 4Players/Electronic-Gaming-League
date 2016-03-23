<?php

	global $gl_oVars;
	
	$cFastChallenge = new FastChallenge( $gl_oVars->cDBInterface );
	$cLadder = new InetopiaLadder( $gl_oVars->cDBInterface );
		
	// fetch ladders
	$aFastChallengeLadders = $cFastChallenge->GetFastChallengeLadders();
	// to each ladder, providing fast-challenge mode
	for( $i=0; $i < sizeof($aFastChallengeLadders); $i++ ){
		$cFastChallenge->GenerateMatchesFromPool( $aFastChallengeLadders[$i]->id );
	}//for
?>