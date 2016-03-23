<?php
	global $gl_oVars;

	
	if( $_SESSION['admin']['loading'] )
	{
		$_SESSION['admin']['loggedin'] = true;
		unset( $_SESSION['admin']['loading']);
		$gl_oVars->cTpl->assign( 'is_loggedin', true );
	}

	$pw_settings = new egl_pw_settings();
	
	if( $_GET['a'] == 'go' )
	{
		if( $_POST['login_name'] == $pw_settings->configsheet_login_name &&
			$_POST['login_password'] == $pw_settings->configsheet_login_password )
		{
			
			$_SESSION['admin']['loading'] = true;
			$gl_oVars->cTpl->assign( 'is_loading', true );
		}//if
	}//if

?>