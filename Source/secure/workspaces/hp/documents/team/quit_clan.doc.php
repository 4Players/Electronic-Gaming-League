<?php
	global $gl_oVars;
	
	$iTeamId	= (int)$_GET['team_id'];
	

	// objects / classes
	$cTeam = new Team( $gl_oVars->cDBInterface );
	$cClan = new Clan( $gl_oVars->cDBInterface );
	
	$oTeam = $cTeam->GetTeamById( $iTeamId );
	if( $oTeam->clan_id > 0 )
		$oClan = $cClan->GetClanById( $oTeam->clan_id );

	
	# --------------------------------------------
	# Confirmed => GO
	# --------------------------------------------
	if( $oClan )
	if( $_GET['a'] == 'confirm' )
	{
		//$oTeam = $cTeam->GetTeamById( $iTeamId );
		
		$t_data = array( 'clan_id'	=> EGL_NO_ID );
		if( $cTeam->SetTeamData( $t_data, $iTeamId ) ){
			PageNavigation::Location( $gl_oVars->sURLFile.'?page=team.center&team_id='.$iTeamId );
		}//if
	}//if $_GET['a']
	
	
	if( $oTeam )$gl_oVars->cTpl->assign( 'team', $oTeam );
	if( $oClan )$gl_oVars->cTpl->assign( 'clan', $oClan );
	
	// no clan joined?
	if( !$oClan )
	{
		$gl_oVars->cTpl->assign( 'msg_type', 	'info' );
		$gl_oVars->cTpl->assign( 'msg_title', 	'Information' );
		$gl_oVars->cTpl->assign( 'msg_text', 	'Das Team ist keinem Clan beigetreten' );
	}
?>