<?php
# ================================ Copyright  2005-2006 Inetopia, All rights reserved. ==========================
# Inetopia 
#
# Purpose: Calculator - EGL-ELO
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
	
	$oMatchResults 	= $params['match_results'];
	$oMatchResults 	= new match_results_t;
	
	
	$R_CHALLENGER 	= (int)$params['challenger_points'];
	$R_OPPONENT 	= (int)$params['opponent_points'];
	$k				= 50; //$params['k'];
	$DIV			= 400; //$params['div']
						
	$R2_CHALLENGER 	= 0;	# new challenger points / after evaluation
	$R2_OPPONENT 	= 0;	# new challenger points / after evaluation
	
	
	
	

	
	
	return array( 	'challenger_points' => $R_CHALLENGER+$R2_CHALLENGER,
					'opponent_points'	=> $R_OPPONENT+$R2_OPPONENT,
					
					'challenger_points_diff' => $R2_CHALLENGER,
					'opponent_points_diff' => $R2_OPPONENT,
				);
}

?>