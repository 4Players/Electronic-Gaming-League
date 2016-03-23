<?php
	global $gl_oVars;

	//$cGamPool = new GamePool( $gl_oVars );e
	//$aGames = 
	$iGameId	= (int)$_GET['game_id'];
	if( $iGameId > 0 )
	{
		//$_SESSION['member']['game_id'] = (int)$iGameId;
		setcookie( "member[game_id]", $iGameId, EGL_COOKIETIME ); 
	}
	
	/*
	$url_params='';
	while( list( $name, $value ) = $_GET ) $url_params .= '&'.$name.'='.$value;*/
	
	header( "Location: ".$gl_oVars->sURLFile."?page=gameview.summary" );
?>