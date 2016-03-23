<?php
	global $gl_oVars;

	
	$cGameAccount = new GameAccounts( $gl_oVars->cDBInterface );

	# get all gameaccount-types
	$aGameAccountTypes = $cGameAccount->GetGameAccountTypes();

	
	if( !isset($_GET['a']))
	{
		
		$gl_oVars->cTpl->assign( 'msg_type',	'warning' );
		$gl_oVars->cTpl->assign( 'msg_text',	$gl_oVars->aLngBuffer['basic']['c4537'] );
		
	}
	else if( $_GET['a'] == 'go' )
	{
		$oGameAcc 		= NULL;
		$oGameAccType 	= NULL;
		
		
		# fetch gameacc data from db
		$oGameAccType = $cGameAccount->GetGameAccountType( (int)$_POST['gameacc_type'] );
		
		
		# account_type currently exists ??
		if( $oGameAccType )
		if( ($oGameAcc=$cGameAccount->GetGameAccountByType( $gl_oVars->oMemberData->id, (int)$_POST['gameacc_type'] )))
		{
			# yes
		
			# more than 1 week, since last change ?
			if( (EGL_TIME-$oGameAcc->change_time) >= (3600*24*7) )
			{
				$gameacc_data = NULL;
				$gameacc_data->change_time = EGL_TIME;
				$gameacc_data->changed 	= 1;
				$gameacc_data->value 	= $_POST['gameacc_value'];
										
				if( $cGameAccount->SetGameAccountData( $gameacc_data, $oGameAcc->id ))
				{
					$bSuccess = true;
					# Success
					
					$gl_oVars->cTpl->assign( 'msg_type',	'success' );
					$gl_oVars->cTpl->assign( 'msg_text',	$gl_oVars->aLngBuffer['basic']['c4538'] );
							
					# set page as success page
					$gl_oVars->cTpl->assign( 'success',	1 );
					
				}//if setgameaccountdata
			}
			else
			
			# CHECK media file selected
			if( $_POST['gameacc_activate_media'] == 'accept' )
			{
				# check for right size
				$tmp_file 		= $_FILES['gameacc_media_file']['tmp_name'];
				$tmp_filesize 	= filesize( $tmp_file ) / 1024; # => convert to kb
				
				
				
				$extension			= get_file_extension( $_FILES['gameacc_media_file']['name'], -1 );
				
				# define file_name saving/saved
				$saved_file		= md5($oGameAcc->id.CreateRandomPassword(4)).'.'.$extension;
				
				# try to copy media file
				if( copy( $tmp_file, FIX_URL_SEP(EGLDIR_GAMEACC_REPORTS . $saved_file) ) )
				{
					$bRightSyntax 	= true;
					$bSuccess		= false;
					
					
					# check syntax - regular
					if( strlen($oGameAccType->syntax) > 0)
						if( !preg_match( $oGameAccType->syntax, $_POST['gameacc_value'] ))
							$bRightSyntax = false;
					
					# check length
					if( $oGameAccType->length )
					{
						if( strlen($_POST['gameacc_value']) !=  $oGameAccType->length )
							$bRightSyntax = false;
					}
					else
						if(strlen($_POST['gameacc_value']) == 0) $bRightSyntax = false; # INPUT AVAILABLE ??
						
						
					if( $bRightSyntax )
					{		
					
						# add reportdata 
						#-------------------------------------------------
						$report_data = NULL;
						$report_data->gameaccount_id 	= $oGameAcc->id;
						$report_data->text 				= $_POST['gameacc_text'];
						$report_data->media_filename 	= $saved_file;
						$report_data->old_value 		= $oGameAcc->value;
						$report_data->new_value 		= $_POST['gameacc_value'];
						$report_data->created		 	= EGL_TIME;
						
						
						# CREATE report
						
						$gameacc_data = NULL;
						$gameacc_data->change_time = EGL_TIME;
						$gameacc_data->changed 	= 1;
						$gameacc_data->value 	= $_POST['gameacc_value'];
						
						
						# try creating report
						if( $cGameAccount->CreateGameAccountReport($report_data) )
						{
							# UPDATE game_account
								# changed = true
								# value = new value
							if( $cGameAccount->SetGameAccountData( $gameacc_data, $oGameAcc->id ))
							{
								$bSuccess = true;
								# Success
							}//if setgameaccountdata
						}# // if creategameaccountreport
						
						
						
						
						if( $bSuccess )
						{
							// success
							$gl_oVars->cTpl->assign( 'msg_type',	'success' );
							$gl_oVars->cTpl->assign( 'msg_text',	$gl_oVars->aLngBuffer['basic']['c4538'] );
							
							# set page as success page
							$gl_oVars->cTpl->assign( 'success',	1 );
		
						}//if
						else
						{
							// unknown error
							$gl_oVars->cTpl->assign( 'msg_type', 	'error' );
							$gl_oVars->cTpl->assign( 'msg_text', 	$gl_oVars->aLngBuffer['basic']['c4539'] );
						} // if $bSuccess
					} # if $bRight Syntax
					else
					{
						
						$gl_oVars->cTpl->assign( 'msg_type',	'error' );
						$gl_oVars->cTpl->assign( 'msg_text',	$gl_oVars->aLngBuffer['basic']['c4540'] );
						
					}  # if !$bRightSyntax
						
				}
				else
				{
					// unknown error
					$gl_oVars->cTpl->assign( 'msg_type', 	'error' );
					$gl_oVars->cTpl->assign( 'msg_text', 	$gl_oVars->aLngBuffer['basic']['c4539'] );
				}
				

			}
			else
			{
				$gl_oVars->cTpl->assign( 'msg_type', 	'error' );
				$gl_oVars->cTpl->assign( 'msg_text', 	$gl_oVars->aLngBuffer['basic']['c4543'] );
			}// if !($_POST['gameacc_activate_media'] == 'accept')
		}
		else
		{
			
			$oUsedGameAcc = NULL;
			if( $oUsedGameAcc=$cGameAccount->GetGameAccountValue( $_POST['gameacc_type'], $_POST['gameacc_value'] ))
			{
				$gl_oVars->cTpl->assign( 'msg_type',	'error' );
				$gl_oVars->cTpl->assign( 'msg_text',	$gl_oVars->aLngBuffer['basic']['c4544'] );
				
			}
			else
			{
				
				# no
				$bRightSyntax = true;
				
				# check syntax - regular
				if( strlen($oGameAccType->syntax) > 0)
					if( !preg_match( $oGameAccType->syntax, $_POST['gameacc_value'] ))
						$bRightSyntax = false;
				
				# check length
				if( $oGameAccType->length )
				{
					if( strlen($_POST['gameacc_value']) !=  $oGameAccType->length )
						$bRightSyntax = false;
				}
				else
					if(strlen($_POST['gameacc_value']) == 0) $bRightSyntax = false; /* INPUT AVAILABLE ??*/ 
					
						
				# =======================
				# SYNTAX CHECK
				# =======================
				if( $bRightSyntax )
				{
				
					#----------------------------------------------------------------
					$obj = NULL;
					$obj->member_id 		= $gl_oVars->oMemberData->id;
					$obj->gameacctype_id 	= (int)$_POST['gameacc_type'];
					$obj->value				= $_POST['gameacc_value'];
					$obj->created			= EGL_TIME;
					$obj->change_time		= EGL_TIME;
				
					
					# finally ADD TO DB
					if( $cGameAccount->AddGameAccount( $obj ) )
					{
						$gl_oVars->cTpl->assign( 'msg_type',	'success' );
						$gl_oVars->cTpl->assign( 'msg_text',	$gl_oVars->aLngBuffer['basic']['c4545'] );
						
						# set page as success page
						$gl_oVars->cTpl->assign( 'success',	1 );
					}//if
					else
					{
						$gl_oVars->cTpl->assign( 'msg_type',	'error' );
						$gl_oVars->cTpl->assign( 'msg_text',	$gl_oVars->aLngBuffer['basic']['c4546'] );
					}
					
				} # $bRightSyntax
				else
				{
					$gl_oVars->cTpl->assign( 'msg_type',	'error' );
					$gl_oVars->cTpl->assign( 'msg_text',	$gl_oVars->aLngBuffer['basic']['c4547'] );
				} // if !$bRightSyntax
				
			} // gameacc_value not used	

		} // if $oGameAcc avaiable
	} // if !isset $_GET['a']
	
	
	
	# provide the tpl-engine with account data
	$gl_oVars->cTpl->assign( 'gameaccounts', $aGameAccountTypes );
?>