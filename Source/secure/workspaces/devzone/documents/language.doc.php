<?php
	global $gl_oVars;
	$gl_oVars->pcRuntimeEngine->SelectLanguage( $_GET['lng'] );
	
	if( isset($_GET['route_page']) ){
		PageNavigation::Location( $gl_oVars->sURLFile.'?page='.$_GET['route_page'] );
	}
	
?>