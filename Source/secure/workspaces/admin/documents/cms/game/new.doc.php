<?php
	global $gl_oVars;
	
	$cGamePool = new GamePool( $gl_oVars->cDBInterface );
	
	
	# CHECK ACTION => adding game??
	if( $_GET['a'] == "add_game" )
	{
		$release_date = 0;
		if( strlen($_POST['game_release_date']) )
		{
			list ($day, $month, $year) = explode('.', $_POST['game_release_date']); 
			$release_date	= mktime( 1, 0, 0, $month, $day, $year );
		}
		
		$game_obj = array(	"name"					=> $_POST['game_name'],
							"token"					=> $_POST['game_token'],
							"hp"					=> $_POST['game_hp'],
							"publisher"				=> $_POST['game_publisher'],
							"developer"				=> $_POST['game_developer'],
							"release_date"			=> $release_date,
							"description" 			=> $_POST['game_description'],
							"short_description" 	=> $_POST['game_short_description'],
						);
						
		
		if( $cGamePool->AddGame( $game_obj ) )
		{
			$gl_oVars->cTpl->assign( "msg_type",	"success" );
			$gl_oVars->cTpl->assign( "msg_title",	"Spiel erstellt" );
			$gl_oVars->cTpl->assign( "msg_text",	"Das Spiel wurde erfolgreich erstellt. Weitere Einstellungen nehemn Sie bitte unter 'Spiel bearbeiten' vor." );
			
			$gl_oVars->cTpl->assign( "success", true );
		}
		else 
		{
			$gl_oVars->cTpl->assign( "msg_type",	"error" );
			$gl_oVars->cTpl->assign( "msg_title",	"Fehler" );
			$gl_oVars->cTpl->assign( "msg_text",	"Es ist ein Fehler aufgetreten. Das Spiel konnte nicht erstellt werden. Bitte entnehmen Sie weitere Informationen aus den Build-Protokollen." );
		}
		
	}//if
		
?>