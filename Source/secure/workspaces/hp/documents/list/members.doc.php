<?php
	global $gl_oVars;

	$cCountry 		= new Country( $gl_oVars->cDBInterface );
	$brun_search 	= false;
	$str_public_key	= "";
	
	
	$aSearchObj = array();
	

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
		$aResults = $gl_oVars->cDBInterface->FetchArrayObject($gl_oVars->cDBInterface->Query( $gl_oVars->cDBInterface->CreateSelectQuery( $GLOBALS['g_egltb_members'], $aSearchObj, true, NULL, ' LIMIT 0,50', false, 'INSTR($VAR,\'$VALUE\')' ) ));
		
		
		$gl_oVars->cTpl->assign( 'results', $aResults);
		$gl_oVars->cTpl->assign( 'num_results', sizeof($aResults));
	
		$gl_oVars->cTpl->assign( 'search_success', true);
		
		$gl_oVars->cTpl->assign( 'countries', $cCountry->GetCountries() );
	}
?>