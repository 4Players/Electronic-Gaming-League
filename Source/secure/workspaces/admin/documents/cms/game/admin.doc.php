<?php
	global $gl_oVars;
	
	$iGameId	= (int)$_GET['game_id'];
	
	$cGamePool 		= new GamePool( $gl_oVars->cDBInterface );
	$cGameAccount 	= new GameAccounts( $gl_oVars->cDBInterface );
	$cMyCategory	= new MyCategory( $gl_oVars->cDBInterface );
	
	# fetch gamedata
	$oGame			= $cGamePool->GetGameById($iGameId );
	$oGameAcc		= $cGameAccount->GetGameAccountType( $oGame->gameacctype_id );
	$aGameAccounts	= $cGameAccount->GetGameAccountTypes();
	
	
	
	# CHECK ACTION => adding game??
	if( $_GET['a'] == "change_game" )
	{
		$release_date = 0;
		if( strlen($_POST['game_release_date']) )
		{
			list ($day, $month, $year) = explode('.', $_POST['game_release_date']); 
			$release_date	= mktime( 1, 0, 0, $month, $day, $year );
		}
	
		# declare updat queryobject, execution by object/class
		$game_obj = array(	"name"				=> $_POST['game_name'],
							"token" 			=> $_POST['game_token'],
							"hp"				=> $_POST['game_hp'],
							"cat_id" 			=> $_POST['game_cat_id'],
							"publisher"			=> $_POST['game_publisher'],
							"developer"			=> $_POST['game_developer'],
							"release_date"		=> $release_date,
							"description" 		=> $_POST['game_description'],
							"short_description" => $_POST['game_short_description'],
							"forum_id"			=> $_POST['forum_id'],
						);
							
		if( $cGamePool->SetGameData( $game_obj, $iGameId ) )
		{

			$gl_oVars->cTpl->assign( "msg_type",	"success" );
			$gl_oVars->cTpl->assign( "msg_title",	"Spiel bearbeitet" );
			$gl_oVars->cTpl->assign( "msg_text",	"Spielen wurden erfolgreich geändert." );
			
			$gl_oVars->cTpl->assign( "success", true );
		}
		else 
		{
			$gl_oVars->cTpl->assign( "msg_type",	"error" );
			$gl_oVars->cTpl->assign( "msg_title",	"Fehler" );
			$gl_oVars->cTpl->assign( "msg_text",	"Es ist ein Fehler aufgetreten. Das Spiel konnte nicht bearbeitet werden. Bitte entnehmen Sie weitere Informationen aus den Build-Protokollen." );
		}
		
	}//if
	elseif( $_GET['a'] == "update_gameaccount" )
	{
		$iSelectedGameAccType = (int)$_POST['selected_gameacctype'];

		if( $iSelectedGameAccType == 0 )
		{
			$gameacc_obj = NULL;
			$gameacc_obj->name 		= $_POST['name'];
			$gameacc_obj->length 	= (int)$_POST['length'];
			if( strlen($gameacc_obj->name) == 0 ) $gameacc_obj->name = "UNKNOWN";
			$iGameAccountTypeId =$cGameAccount->CreateGameAccountType( $gameacc_obj );

			// assign gameacctype to game
			 $cGamePool->SetGameData( 	array(	'gameacctype_id'	=> $iGameAccountTypeId,
											 ), 
										$iGameId );
			//$gl_oVars->cDBInterface->Query( "UPDATE `{$GLOBALS['g_egltb_gameaccount_types']}` AS gameacctypes SET game_id=-1 WHERE game_id={$iGameId}" );
			//$gl_oVars->cDBInterface->Query( "UPDATE `{$GLOBALS['g_egltb_gameaccount_types']}` AS gameacctypes SET game_id=$iGameId WHERE id={$iGameAccountTypeId}" );
		}
		else if( $iSelectedGameAccType != $oGameAcc->id )
		{
			if( $iSelectedGameAccType != 0 )
			{
				$newGameAcc = $cGameAccount->GetGameAccountType($iSelectedGameAccType);
				//$gl_oVars->cDBInterface->Query( "UPDATE `{$GLOBALS['g_egltb_gameaccount_types']}` AS gameacctypes SET game_id=-1 WHERE game_id={$iGameId}" );
				//$gl_oVars->cDBInterface->Query( "UPDATE `{$GLOBALS['g_egltb_gameaccount_types']}` AS gameacctypes SET game_id=$iGameId WHERE id={$iSelectedGameAccType}" );
				
				// assign gameacctype to game
				$cGamePool->SetGameData( 	array(	'gameacctype_id'	=> $iSelectedGameAccType,
													 ), 
											$iGameId );
			}//if
		}
		else
		{
			if( $iSelectedGameAccType != -1 )
			{
				if( strlen($_POST['name']) == 0 )
				{
					$aGames = $cGameAccount->GetGamesSelectedGameAccTypes( $iSelectedGameAccType );
					if( sizeof($aGames) == 1 ){
						$gl_oVars->cDBInterface->Query( "DELETE FROM `{$GLOBALS['g_egltb_gameaccount_types']}` WHERE id={$iSelectedGameAccType}" );
					}//if
					
					// assign gameacctype to game
					$cGamePool->SetGameData( 	array(	'gameacctype_id'	=> EGL_NO_ID,
														 ), 
												$iGameId );
					
				}//if
				else 
				{
					$update_obj 		= array( 'name' 	=> $_POST['name'],
												 'length' 	=> $_POST['length'],
												);
					$cGameAccount->SetGameAccountTypeData( $update_obj, $iSelectedGameAccType );
				}
			}
			else
			{
			}
		}
		
		$gl_oVars->cTpl->assign( "msg_type",	"success" );
		$gl_oVars->cTpl->assign( "msg_title",	"GameAccount gewählt" );
		$gl_oVars->cTpl->assign( "msg_text",	"Spieldaten wurden erfolgreich geändert." );
			
		$gl_oVars->cTpl->assign( "success", true );
		
		
	}
	elseif( $_GET['a'] == "delete_game" )
	{
		if( $cGamePool->DeleteGameById( $iGameId ) )
		{

			$gl_oVars->cTpl->assign( "msg_type",	"success" );
			$gl_oVars->cTpl->assign( "msg_title",	"Spiel gelöscht" );
			$gl_oVars->cTpl->assign( "msg_text",	"Das Spiel wurde erfolgreich gelöscht." );
			
			$gl_oVars->cTpl->assign( "success", true );
		}
		else 
		{
			$gl_oVars->cTpl->assign( "msg_type",	"error" );
			$gl_oVars->cTpl->assign( "msg_title",	"Fehler" );
			$gl_oVars->cTpl->assign( "msg_text",	"Es ist ein Fehler aufgetreten. Das Spiel konnte nicht gelöscht werden. Bitte entnehmen Sie weitere Informationen aus den Build-Protokollen." );
		}
	}//if
	elseif( $_GET['a'] == "upload_image" )
	{
				$games_root = "";
				if( $_POST['image_size'] == "small" )$games_root =  EGLDIR_GAMES.'small/';
				if( $_POST['image_size'] == "big" )$games_root =  EGLDIR_GAMES.'big/';
				
	
				# check for right size
				$tmp_file 		= $_FILES['upload_file']['tmp_name'];
				$tmp_filesize 	= filesize( $tmp_file ) / 1024; # => convert to kb
				
				# check
				$extension			= get_file_extension( $_FILES['upload_file']['name'], -1 );
				#$extension 		= "jpg";
				
				# define file_name saving/saved
				$saved_file		= md5( $oGame->id.CreateRandomPassword(4)).'.'.$extension;
			
			
				# delete old data
				if( $oGame->logo_file != 'non' )	
					if( file_exists( $games_root . $oGame->logo_small_file ) )  
						_unlink( $games_root . $oGame->logo_small_file  );
				
								
			
				#---------------------------
				# save ... 
				#---------------------------
				if( _copy( $tmp_file, $games_root . $saved_file ) )	# image_size bekannt ? => small / big
				{	
					$up_obj 		= NULL;
					if( $_POST['image_size'] == "small" ) $up_obj->logo_small_file 	= $saved_file;
					if( $_POST['image_size'] == "big" ) $up_obj->logo_big_file 	= $saved_file;
					
					$b_success 			= false;
					$b_success 			= $cGamePool->SetGameData( $up_obj, $oGame->id );
					
														
					#---------------------------
					# update profil
					#---------------------------
					if( $b_success )
					{
						# set new memberdata
						#$g_cMember->UpdateProfil($member_obj);
						
						#--------------------
						# set success messages
						#--------------------

						$gl_oVars->cTpl->assign( 'success', true );
						
						$gl_oVars->cTpl->assign( 'msg_type', 	'success' );
						$gl_oVars->cTpl->assign( 'msg_title', 	'Upload erfolgreich' );
						$gl_oVars->cTpl->assign( 'msg_text', 	'Sie haben erfolgreich Ihr Bild hochgeladen !' );
						
					}//if update profil
				}// if save logo
				else
				{
					$error_code = $_FILES['upload_file']['error'];
					switch($error_code)
					{
						case UPLOAD_ERR_INI_SIZE: 	DEBUG(MSGTYPE_INFO, __FILE__, __LINE__, "Couldn't copy tmp logofile [{$tmp_file}] to [{$dest_file}] - Uploadfile too big according to upload_max_filesize in php.ini"); break;
						case UPLOAD_ERR_FORM_SIZE: 	DEBUG(MSGTYPE_INFO, __FILE__, __LINE__, "Couldn't copy tmp logofile [{$tmp_file}] to [{$dest_file}] - Uploadfile too big according to HTML formular value MAX_FILE_SIZE"); break;
						case UPLOAD_ERR_PARTIAL: 	DEBUG(MSGTYPE_INFO, __FILE__, __LINE__, "Couldn't copy tmp logofile [{$tmp_file}] to [{$dest_file}] - Uploadfile uploaded partially"); break;
						case UPLOAD_ERR_NO_FILE: 	DEBUG(MSGTYPE_WARNING, __FILE__, __LINE__, "Couldn't copy tmp logofile [{$tmp_file}] to [{$dest_file}] - File not uploaded"); break;
						default: DEBUG(MSGTYPE_WARNING, __FILE__, __LINE__, "Couldn't copy tmp logofile [{$tmp_file}] to [{$dest_file}] - Unknown problem"); break;
					}//switch
					
				
					$gl_oVars->cTpl->assign( 'msg_type', 	'error' );
					$gl_oVars->cTpl->assign( 'msg_title', 	'Fehler' );
					
					if( $error_code == UPLOAD_ERR_INI_SIZE ) $gl_oVars->cTpl->assign( 'msg_text', 	'Die Datei überschreitet die maximale Dateigröße' );
					if( $error_code == UPLOAD_ERR_FORM_SIZE ) $gl_oVars->cTpl->assign( 'msg_text', 	'Die Datei überschreitet die maximale Dateigröße' );
					if( $error_code == UPLOAD_ERR_PARTIAL ) $gl_oVars->cTpl->assign( 'msg_text', 	'Datei konnte nur teilweise hochgeladen werden. Bitte versuchen Sie den Vorgang erneut.' );
					if( $error_code == UPLOAD_ERR_NO_FILE ) $gl_oVars->cTpl->assign( 'msg_text', 	'Unbekannter Fehler aufgetreten. Bitte melden Sie dies umgehend Ihrem Webmaster. Vielen Dank!' );
					
				} // else copy file
		
	}//if
	else
	{
	}
	
	# forum-installed?
	$forum_moduleid = '92BA6E58-6108-45fd-ADD1-A1E0B8EB8415';
	if( $gl_oVars->cModuleManager->ModuleAvailable( $forum_moduleid ) ){
		$oForumTree = module_sendmessage( $forum_moduleid, 'get_forumtree', $__DATA__, 0, 0 );
		
		$gl_oVars->cTpl->assign( 'forumtree', $oForumTree );
	}
	
	
	# get root data
	$oCatRoot = $cMyCategory->GenerateTree( -1, -1 );
	$gl_oVars->cTpl->assign( 'categoryroot', $oCatRoot );
	
	$gl_oVars->cTpl->assign( "game", $oGame );
	$gl_oVars->cTpl->assign( "gameaccount", $oGameAcc );
	$gl_oVars->cTpl->assign( "gameaccounts", $aGameAccounts );
?>
