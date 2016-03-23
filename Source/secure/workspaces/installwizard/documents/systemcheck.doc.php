<?php
	global $gl_oVars;
	if( $_GET['a'] == 'next' ){
		$gl_oVars->pcRuntimeEngine->SelectLanguage( $_POST['lng'] );
		
		PageNavigation::Location( $gl_oVars->sURLFile.'?page=mode' );
	}

?>