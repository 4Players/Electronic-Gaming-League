<?php
	global $gl_oVars;
	
	$cCaller		= new CallbackManager();
	$calculator		= $_GET['calculator'];
				
	# init root callbacks for Calculator
	if( !$cCaller->Init( EGL_SECURE.'calculator'.EGL_DIRSEP, $gl_oVars ) ){
		DEBUG( MSGTYPE_ERROR, __FILE__, __LINE__, "Couldn't initialize CallbackManager" );
	}
	
	if( $cCaller->CallbackExists( $calculator ) )
	{
		$winner = '';
		if( $_POST['match_points_player_a'] == $_POST['match_points_player_b'] )
			$winner = '';
		if( $_POST['match_points_player_a'] > $_POST['match_points_player_b'] )
			$winner = 'challenger';
		if( $_POST['match_points_player_a'] < $_POST['match_points_player_b'] )
			$winner = 'opponent';
			
		$eval_results 	=	$cCaller->Call( $_GET['calculator'], array( 	'challenger_points' => $_POST['elo_points_player_a'],
																		  	'opponent_points' 	=> $_POST['elo_points_player_b'],
																		  	'winner'			=> $winner,
																		 // 	'match_results'		=> $data->oMatchResults,
														  					 //'div'				=> 400 
																		) );
																		
		$gl_oVars->cTpl->assign( 'newpoints_player_a', $eval_results['challenger_points_diff'] );
		$gl_oVars->cTpl->assign( 'newpoints_player_b', $eval_results['opponent_points_diff'] );
						
		$gl_oVars->cTpl->assign( 'points_player_a', $eval_results['challenger_points'] );
		$gl_oVars->cTpl->assign( 'points_player_b', $eval_results['opponent_points'] );
	}
	else
	{
		$gl_oVars->cTpl->assign( 'UNKNOWN_CALCO', true );
	}
	
	$gl_oVars->cTpl->assign( 'CALCO', $calculator );
	
?>