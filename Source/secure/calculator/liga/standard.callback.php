<?php
# =================================================================================
# Copyright (c)2006 Inetopia. All rights reserved. Alle Rechte vorbehalten.
#
#
#

/**
 * compute points basing on standard liga system
 *
 * win 		+ 3
 * lose 	- 3
 * draw		+1
 *
 * @param global_vars_t $oVars
 * @param array			$params
 */

function callback(  $oVars, $params )
{
	/*
		ARRAY $params
		--------------------
			integer			 	challenger_points	: 
			integer 			opponent_points		:
			integer 			winner				: 'challenger' / 'opponent' / ''
			match_results_t		match_results		: match-result data
			integer 			data				: unspecified data
			
	*/
	
	$R_CHALLENGER 	= (int)$params['challenger_points'];
	$R_OPPONENT 	= (int)$params['opponent_points'];
						
	$R2_CHALLENGER 	= 0;	# new challenger points / after evaluation
	$R2_OPPONENT 	= 0;	# new challenger points / after evaluation
	
	
	#---------------------------------------------
	# CHALLENGER WINS
	#---------------------------------------------
	if( $params['winner'] == 'challenger' )
	{
		$R2_CHALLENGER 	=  3;
		$R2_OPPONENT 	=  0;
	}
	#---------------------------------------------
	# OPPONENT WINS
	#---------------------------------------------
	if( $params['winner'] == 'opponent' )
	{
		$R2_CHALLENGER 	=  0;
		$R2_OPPONENT 	=  3;
	}
	#---------------------------------------------
	# NOONE WINS / DRAW
	#---------------------------------------------
	if( $params['winner'] != 'opponent' && $params['winner'] != 'challenger' )
	{
		$R2_CHALLENGER 	=  0;
		$R2_OPPONENT 	=  0;
	}

	return array( 	'challenger_points' => $R_CHALLENGER+$R2_CHALLENGER,
					'opponent_points'	=> $R_OPPONENT+$R2_OPPONENT,
					
					'challenger_points_diff' => $R2_CHALLENGER,
					'opponent_points_diff' => $R2_OPPONENT,
				);
}//function

?>