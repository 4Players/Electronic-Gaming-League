<?php

	// ------------------------------------------------------
		// fetch 
		// ------------------------------------------------------
		$param = array( 'limit_start' 	=> 0,
						'limit_cnt'		=> 5 );
		include( "../secure/libs/nusoap/nusoap.php" );
			
		// define path to server application
		$serverpath ='http://www.electronicgamingleague.de:80/services/news/';
			
		// create client object
		$client = new soapclient($serverpath);
			
		// make the call
		$aEGLNews = $client->call( 'getNews' , $param );
		
		echo sizeof($aEGLNews);
		
		// if a fault occurred, output error info
		if (isset($fault)) 
		{
			//print "Error: ". $fault;
		} 
		else 
		{
		}
			    
?>