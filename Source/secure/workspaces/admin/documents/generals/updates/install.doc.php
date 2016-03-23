<?php
	global $gl_oVars;

	
	
	
	$cUpdateProtocol = new UpdateProtocol();
	$cUpdateProtocol->Init( $_GET['update_id'] );
	$cUpdateProtocol->Install();
	
	

?>