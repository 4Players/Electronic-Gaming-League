<?php
# ================================ Copyright  2005-2006 Inetopia, All rights reserved. ==========================
# Inetopia 
#
# Purpose: Calculator - standard elo
# ================================================================================================================


/**
 * compute points basing on standard elo system
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
			
		
		--------------------
		1 		-> WIN
		0.5 	-> DRAW
		0 		-> LOSE
	*/

	$R_CHALLENGER 	= (int)$params['challenger_points'];
	$R_OPPONENT 	= (int)$params['opponent_points'];
	$k				= 25; //$params['k'];
	$DIV			= 400; //$params['div']
						
	$R2_CHALLENGER 	= 0;	# new challenger points / after evaluation
	$R2_OPPONENT 	= 0;	# new challenger points / after evaluation
	
	
	$Ea = 1/( 1 + pow(10 , ($R_CHALLENGER-$R_OPPONENT)/$DIV) );
	
	#---------------------------------------------
	# CHALLENGER WINS
	#---------------------------------------------
	if( $params['winner'] == 'challenger' )
	{
		$R2_CHALLENGER 	=  round( $k* (1 - $Ea) );
		$R2_OPPONENT 	=  round( $k* (0 - $Ea) );
	}
	#---------------------------------------------
	# OPPONENT WINS
	#---------------------------------------------
	elseif( $params['winner'] == 'opponent' )
	{
		$R2_CHALLENGER 	=  round( $k* (0 - $Ea) );
		$R2_OPPONENT 	=  round( $k* (1 - $Ea) );
	}
	#---------------------------------------------
	# NOONE WINS
	#---------------------------------------------
	elseif( $params['winner'] == '' )
	{
		$R2_CHALLENGER 	=  round( $k* (0.5 - $Ea) );
		$R2_OPPONENT 	=  round( $k* (0.5 - $Ea) );
	}

	return array( 	'challenger_points' => $R_CHALLENGER+$R2_CHALLENGER,
					'opponent_points'	=> $R_OPPONENT+$R2_OPPONENT,
					
					'challenger_points_diff' => $R2_CHALLENGER,
					'opponent_points_diff' => $R2_OPPONENT,
				);
}

?>