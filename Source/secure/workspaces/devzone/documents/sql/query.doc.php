<?php
	global $gl_oVars;
	
	if( isset($_POST['query']))
	{
		
		$query =  $_POST['query'];
		$query = str_replace( '{TIME}', EGL_TIME, $query );
		$qre = $gl_oVars->cDBInterface->Query( $query );
		
		if( $qre )
		{
			$html_output = $gl_oVars->cDBInterface->CreateHTMLOutput( $qre );
			if( $html_output == 'no results' ){
				$gl_oVars->cTpl->assign( 'NO_RESULTS', true );
			}//if
			else{
				$gl_oVars->cTpl->assign( 'OUTPUT', $html_output );
			}
			
		}//if
		if( !$qre) $gl_oVars->cTpl->assign( 'ERROR', $gl_oVars->cDBInterface->GetLastError() );
	}//if
?>