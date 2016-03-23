<?php
	global $gl_oVars;

	$cCountry 		= new Country( $gl_oVars->cDBInterface );
	$cGameAccount 	= new GameAccounts( $gl_oVars->cDBInterface );
	$brun_search 	= false;
	$aSearchObj 	= array();
	

	# get all inputs
	while( list($var_name, $var_value) = each($_POST) ) 
	{
		if( strlen($var_value) > 0 )
		{
			$aSearchObj[$var_name] = $var_value;
			$brun_search = true;
		}
	}//while	


	if( $brun_search )
	{
		# create results
		$sql_query = 	" SELECT members.*,gameacc.value FROM ".$GLOBALS['g_egltb_gameaccounts']." AS gameacc ".
						",".$GLOBALS['g_egltb_members']." AS members ".
						" WHERE gameacc.member_id=members.id ".
						" AND gameacc.gameacctype_id=".(int)$_POST['gameacctype_id']." AND  gameacc.value='".$gl_oVars->cDBInterface->EscapeString($_POST['value'])."' " ;
						
		# execute query
		$aResults = $gl_oVars->cDBInterface->FetchArrayObject( $gl_oVars->cDBInterface->Query($sql_query));
		
		$gl_oVars->cTpl->assign( 'results', $aResults );
		$gl_oVars->cTpl->assign( 'num_results', sizeof($aResults));
		$gl_oVars->cTpl->assign( 'search_success', true);
		$gl_oVars->cTpl->assign( 'countries', $cCountry->GetCountries() );
		
	}
	$gl_oVars->cTpl->assign( 'gameacctypes', $cGameAccount->GetGameAccountTypes() );
?>