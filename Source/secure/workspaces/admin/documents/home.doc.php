<?php 
	global $gl_oVars;

	if( !$gl_oVars->bLoggedIn )
	{
		$link = $gl_oVars->sURLFile."?page=login";
		header( "Location: {$link}" ); 
	}
?>