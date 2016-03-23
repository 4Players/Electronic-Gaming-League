<?php
	global $gl_oVars;
	include( EGL_LIBS . "nusoap/nusoap.php" );
	
	
	
	$bench = new Bench();
	$soap = new soapclient( "http://127.0.0.1:8080/webserviceexample/start");


	//=======================================================	
	// On request
	//=======================================================	
	if( $_GET['a'] == 'go' )
	{
		// --------- create request ---------------------
		$body = "<command>\n";
		$body .= "	<exec cmd=\"".$_POST['exec']."\"/>\n";
		$body .= "	<parameter>\n";
		for( $iParam=0; $iParam < 100; $iParam++ )
		{
			$param_name 	= $_POST['param_'.$iParam.'_name'];
			$param_value 	= $_POST['param_'.$iParam.'_value'];
			
			// $param ??
			if( strlen($param_value) == 0 && strlen($param_value) == 0 )
				continue;
			$body .= "		<param name=\"{$param_name}\" value=\"{$param_value}\"/>\n";
		}//for
		$body .= "	</parameter>\n";
		$body .= "</command>\n";
		
		// --------- serialize request ---------------------
		$msg = $soap->serializeEnvelope( $body );
		
		// --------- send request --------------------------
		$bench->start();
		$response_array = $soap->send( $msg );
		$bench->stop();
		//echo "Faultcode: ".$soap->faultstring;	
		
		// --------- provide response data -----------------
		$gl_oVars->cTpl->assign( "soap", $soap );
		$gl_oVars->cTpl->assign( "bench_time", round( $bench->diff(), 3 ) );		
		
	}//if

?>