<?php
	/* Include the NuSOAP library. */ 
	require_once( EGL_SECURE.'libs/nusoap/nusoap.php');
	# create the server object
	$server = new soap_server;
	# register the lookup service
	$server->register('getRanking');
	
	
	/**
	 * getRanking
	 * 
	 */
	function getRanking( $participant_id, $ladder_id  ) 
	{
		# global access variable
		global $gl_oVars;
		
		# fetch ladder data
		$oLadder = $gl_oVars->cDBInterface->FetchObject( $gl_oVars->cDBInterface->Query( " SELECT * FROM {$GLOBALS['g_egltb_ladders']} WHERE id={$ladder_id}" ));
		
		if( $oLadder )
		{
			$sql_query  = 	" SELECT participant_id,last_points,points ".
							" FROM `{$GLOBALS['g_egltb_ladder_participants']}` ".
							" WHERE ladder_id={$ladder_id} ".
							" ORDER BY points DESC ";
			$aRanking = $gl_oVars->cDBInterface->FetchArrayObject( $gl_oVars->cDBInterface->Query( $sql_query ) );
			
			# look for participant-id
			for( $i=0; $i < sizeof($aRanking); $i++ )
			{
				if( $aRanking[$i]->participant_id == $participant_id )
				{
					return array( 	'participant_id' 	=> $aRanking[$i]->participant_id,
									'points' 			=> $aRanking[$i]->points,
									'last_points' 		=> $aRanking[$i]->last_points,
									'rank' 				=> ($i+1),
									'ladder' 			=> $oLadder->name,
								);
				}//if
			}//for
		}//if
		
		return array( 	'participant_id' 	=> 	0,
						'points' 			=> 	0,
						'last_points' 		=> 	0,
						'rank' 				=> 	0,
					);
	}
	

	// send the result as a SOAP response over HTTP
	$server->service($GLOBALS['HTTP_RAW_POST_DATA']);
?>