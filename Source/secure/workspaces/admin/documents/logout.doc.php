<?php
	$_SESSION['admin']['loggedin'] = false;
	unset( $_SESSION['admin']['loggedin'] );

	Session::Destroy();
	
	header( "Location: ".$gl_oVars->sURLFile."?page=login" ); 	
?>