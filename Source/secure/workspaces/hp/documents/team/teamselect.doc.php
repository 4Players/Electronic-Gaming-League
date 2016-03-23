<?php
	global $gl_oVars;

	
	# class declares
	$cLadderSystem	= new InetopiaLadder( $gl_oVars->cDBInterface );
	$cTeam	= new Team( $gl_oVars->cDBInterface );

	$aTeams = $cTeam->GetJoinedTeamlist( $gl_oVars->iMemberId );
	

	# modify params
	$_GET['params']=str_replace( ',','&', $_GET['params']);
	

	$gl_oVars->cTpl->assign( 'teams', $aTeams );
?>