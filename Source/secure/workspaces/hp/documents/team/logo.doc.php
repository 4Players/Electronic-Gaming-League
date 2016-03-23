<?php
	global $gl_oVars;

	
	# create base logo object
	$cTeam 		= new Team( $gl_oVars->cDBInterface );
		
		
	$acc_data 	= NULL; 
	$acc_id 	= -1;
	$path_logos = "";

	// fetch teamfata		
	$acc_data 	= $cTeam->GetTeamByMember( (int)$_GET['team_id'], $gl_oVars->oMemberData->id );
		
	

	if( $acc_data )
	{
		
		if( $acc_data ) $acc_id	 	= $acc_data->id;
		$path_logos = EGLDIR_LOGOS.'teams/';

		
		$gl_oVars->cTpl->assign( 'account', $acc_data );
		$gl_oVars->cTpl->assign( 'type', $_GET['type'] );		# (??)
		$gl_oVars->cTpl->assign( 'path_logos', $path_logos );

		
		# ----------------------------
		# Upload ??
		# ----------------------------
		if( $_GET['a'] == 'go' && $acc_id > 0 )
		{
			# ------------------
			# Only delete Logo ?
			# ------------------
			if( $_POST['upload_logo_delete'] == '1' )
			{
			
				# define file_name saving/saved
				#$saved_file		= $acc_id.".jpg";
				
				
				# delete old data
				if( $acc_data->logo_file != 'non' )
				{
					# delete file 
					if( file_exists( $path_logos . $acc_data->logo_file ) )  
						_unlink( $path_logos . $acc_data->logo_file  );
					
					$up_obj 			= NULL;
					$up_obj->logo_file	= 'non';
					
					$b_success 			= false;
					$b_success 			= $cTeam->SetTeamData($up_obj, $acc_id );
						
					# update profil
					if( $b_success )
					{
						# set new memberdata
						# $g_cMember->UpdateProfil($member_obj);
						
						$gl_oVars->cTpl->assign( 'logo_success', true );
						
						// Bild gelöscht
						$gl_oVars->cTpl->assign( 'msg_type', 	'success' );
						$gl_oVars->cTpl->assign( 'msg_text', 	$gl_oVars->aLngBuffer['basic']['c4804'] );
					}//if update profil
				}
				
			}
			else
			{			

				# check for right size
				$tmp_file 		= $_FILES['upload_logo_file']['tmp_name'];
				$tmp_filesize 	= filesize( $tmp_file ) / 1024; # => convert to kb
				
			
				# check
				$extension			= get_file_extension( $_FILES['upload_logo_file']['name'], -1 );
				#$extension 		= "jpg";
				
				# define file_name saving/saved
				$saved_file		= md5( $acc_id.CreateRandomPassword(4)).'.'.$extension;
			
			
				# get memerdata
				#$oMemberData	= $g_cMember->GetData();	# global readed => $g_oMemberData
			
				# delete old data
				if( $acc_data->logo_file != 'non' )	
					if( file_exists( $path_logos . $acc_data->logo_file ) )  
						_unlink( $path_logos . $acc_data->logo_file  );
				
			
				#---------------------------
				# save ... 
				#---------------------------
				if( _copy( $tmp_file, $path_logos . $saved_file ) )
				{	
					$up_obj 			= NULL;
					$up_obj->logo_file 	= $saved_file;
					
					$b_success 			= false;
					$b_success 			= $cTeam->SetTeamData($up_obj, $acc_id );
										
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

						$gl_oVars->cTpl->assign( 'logo_success', true );
						
						$gl_oVars->cTpl->assign( 'msg_type', 	'success' );
						$gl_oVars->cTpl->assign( 'msg_text', 	$gl_oVars->aLngBuffer['basic']['c4805'] );
						
					}//if update profil
				}// if save logo
				else
				{
					$error_code = $_FILES['upload_logo_file']['error'];
					switch($error_code)
					{
						case UPLOAD_ERR_INI_SIZE: 	DEBUG(MSGTYPE_INFO, __FILE__, __LINE__, "Couldn't copy tmp logofile [{$tmp_file}] to [{$dest_file}] - Uploadfile too big according to upload_max_filesize in php.ini"); break;
						case UPLOAD_ERR_FORM_SIZE: 	DEBUG(MSGTYPE_INFO, __FILE__, __LINE__, "Couldn't copy tmp logofile [{$tmp_file}] to [{$dest_file}] - Uploadfile too big according to HTML formular value MAX_FILE_SIZE"); break;
						case UPLOAD_ERR_PARTIAL: 	DEBUG(MSGTYPE_INFO, __FILE__, __LINE__, "Couldn't copy tmp logofile [{$tmp_file}] to [{$dest_file}] - Uploadfile uploaded partially"); break;
						case UPLOAD_ERR_NO_FILE: 	DEBUG(MSGTYPE_WARNING, __FILE__, __LINE__, "Couldn't copy tmp logofile [{$tmp_file}] to [{$dest_file}] - File not uploaded"); break;
						default: DEBUG(MSGTYPE_WARNING, __FILE__, __LINE__, "Couldn't copy tmp logofile [{$tmp_file}] to [{$dest_file}] - Unknown problem"); break;
					}//switch
					
					
					$gl_oVars->cTpl->assign( 'msg_type', 	'error' );
					
					if( $error_code == UPLOAD_ERR_INI_SIZE ) $gl_oVars->cTpl->assign( 'msg_text', 	$gl_oVars->aLngBuffer['basic']['c4556'] );
					if( $error_code == UPLOAD_ERR_FORM_SIZE ) $gl_oVars->cTpl->assign( 'msg_text', 	$gl_oVars->aLngBuffer['basic']['c4557'] );
					if( $error_code == UPLOAD_ERR_PARTIAL ) $gl_oVars->cTpl->assign( 'msg_text', 	$gl_oVars->aLngBuffer['basic']['c4558'] );
					if( $error_code == UPLOAD_ERR_NO_FILE ) $gl_oVars->cTpl->assign( 'msg_text', 	$gl_oVars->aLngBuffer['basic']['c4559'] );
					
				} // else copy file
			}
			
		}// $_GET['a']
		
	}

?>