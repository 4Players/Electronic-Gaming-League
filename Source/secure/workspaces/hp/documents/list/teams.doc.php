<?php
	global $gl_oVars;

	
	$brun_search	= false;
	$str_public_key	= "";
	
	
	$where_clausel ="";
	
	# get all inputs
	while( list($var_name, $var_value) = each($_POST) ) 
	{
		if( strlen($var_value) > 0 )
		{
			$where_clausel .= "INSTR( teams.$var_name,'". $gl_oVars->cDBInterface->EscapeString($var_value). "')#";
			$brun_search = true;
		}
	}//while	
	
	if( $brun_search )
	{
		$where_clausel = str_replace( '#', ' && ', substr( $where_clausel, 0, strlen($where_clausel)-1));
		
		//.
		$sql_query =	" SELECT clan_acc.id AS clan_id, clan_acc.name AS clan_name, teams.* ".
						" FROM ".$GLOBALS['g_egltb_teams']." AS teams ".
						" LEFT JOIN ".$GLOBALS['g_egltb_clan_accounts']." AS clan_acc ".
						" ON teams.clan_id=clan_acc.id ".
						" WHERE $where_clausel";
						
		$aResults	= $gl_oVars->cDBInterface->FetchArrayObject( $gl_oVars->cDBInterface->Query( $sql_query ) );
		
		$gl_oVars->cTpl->assign( 'results', $aResults);
		$gl_oVars->cTpl->assign( 'num_results', sizeof($aResults));
	
		$gl_oVars->cTpl->assign( 'search_success', true);
	}
?>