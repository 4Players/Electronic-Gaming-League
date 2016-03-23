<?php
	global $gl_oVars;
	
	$key = CreateRandomPassword();
	$gl_oVars->cTpl->assign( 'key', $key ); 

?>