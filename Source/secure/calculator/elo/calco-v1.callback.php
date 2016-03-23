<?php

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
	$k				= 25;
	$DIV			= 400;
						
	$R2_CHALLENGER 	= 0;	# new challenger points / after evaluation
	$R2_OPPONENT 	= 0;	# new challenger points / after evaluation
	$ScoringPointC	= 0;
	
	#---------------------------------------------
	# CHALLENGER WINS
	#---------------------------------------------
	if( $params['winner'] == 'challenger' )
	{
		$ScoringPointC = 1.0;
	}
	#---------------------------------------------
	# OPPONENT WINS
	#---------------------------------------------
	elseif( $params['winner'] == 'opponent' )
	{
		$ScoringPointC = 0.0;
	}
	#---------------------------------------------
	# NOONE WINS
	#---------------------------------------------
	elseif( $params['winner'] == '' )
	{
		$ScoringPointC = 0.5;
	}

	$Ea = 1.0 / ( 1 + pow(10 , ($R_OPPONENT-$R_CHALLENGER)/$DIV) );
	$RatingDiffC = round( $k* ($ScoringPointC-$Ea));
	

	return array( 	'challenger_points' 		=> $R_CHALLENGER+$RatingDiffC,
					'opponent_points'			=> $R_OPPONENT-$RatingDiffC,
					
					'challenger_points_diff' 	=> $RatingDiffC,
					'opponent_points_diff' 		=> $RatingDiffC*(-1),
				);
}

?>