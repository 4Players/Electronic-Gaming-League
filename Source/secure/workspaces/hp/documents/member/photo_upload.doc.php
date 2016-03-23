<?php
		global $gl_oVars;
		
		# create base photo object
		#$cPhoto = new Photo( $gl_oVars->cDBInterface, $GLOBALS['g_egltb_photo_pool']);
		
		$path_photos	= EGLDIR_PHOTOS."";
		
		
		# ----------------------------
		# Upload ??
		# ----------------------------
		if( $_GET['a'] == 'go' )
		{
			# ------------------
			# Only delete photo?
			# ------------------
			if( $_POST['upload_photo_delete'] == '1' )
			{
				
				# get memerdata
				#$oMemberData	= $g_cMember->GetData();
				
				
				# delete old data
				if( $gl_oVars->oMemberData->photo_file != 'non' )
				{
					# if filexists => delete
					if( file_exists( $path_photos . $gl_oVars->oMemberData->photo_file ) ) 
						unlink( $path_photos . $gl_oVars->oMemberData->photo_file  );
					
					$member_obj = NULL;
					$member_obj->photo_file = "non";
				
					# update profil
					if( $gl_oVars->cMember->SetMemberData($member_obj ) )
					{
						# set new memberdata
						# $g_cMember->UpdateProfil($member_obj);
						
						$gl_oVars->cTpl->assign( 'photo_success', true );
						
						$gl_oVars->cTpl->assign( 'msg_type', 	'success' );
						//$gl_oVars->cTpl->assign( 'msg_title', 	'Bild gelöscht' );
						$gl_oVars->cTpl->assign( 'msg_text', 	$gl_oVars->aLngBuffer['basic']['c4554'] );						
					}//if update profil
				}
				
			}
			else
			{	
				# check for right size
				$tmp_file 		= $_FILES['upload_photo_file']['tmp_name'];
				$tmp_filesize 	= filesize( $tmp_file ) / 1024; # => convert to kb
			
				
				$extension			= get_file_extension( $_FILES['upload_photo_file']['name'], -1 );
				#$extension 		= 'jpg';

				
				# define file_name saving/saved
				$saved_file		= md5($gl_oVars->oMemberData->id.CreateRandomPassword(4)).'.'.$extension;
				$dest_file 		= EGLDIR_PHOTOS . $saved_file;
			
			
				# get memerdata
				#$oMemberData	= $g_cMember->GetData();	# global readed => $g_oMemberData
			
				# delete old data
				if( $gl_oVars->oMemberData->photo_file != 'non' )
					if( file_exists( EGLDIR_PHOTOS . $gl_oVars->oMemberData->photo_file) ) 
						_unlink( EGLDIR_PHOTOS . $gl_oVars->oMemberData->photo_file);
			
				# copy file
				if( _copy( $tmp_file,  $dest_file ) )
				{
					#---------------------------
					# save ... 
					#---------------------------
					$member_obj = NULL;
					$member_obj->photo_file = $saved_file;
				
					#---------------------------
					# update profil
					#---------------------------
					if( $gl_oVars->cMember->SetMemberData($member_obj ) )
					{
						# set new memberdata
						#$g_cMember->UpdateProfil($member_obj);

					
					
						#--------------------
						# set success messages
						#--------------------

						$gl_oVars->cTpl->assign( 'photo_success', true );
					
						$gl_oVars->cTpl->assign( 'msg_type', 	'success' );
						//$gl_oVars->cTpl->assign( 'msg_title', 	'Upload erfolgreich' );
						$gl_oVars->cTpl->assign( 'msg_text', 	$gl_oVars->aLngBuffer['basic']['c4555'] );
					}# set member data
				}//copy
				else
				{
					$error_code = $_FILES['upload_photo_file']['error'];
					switch($error_code)
					{
						case UPLOAD_ERR_INI_SIZE: 	DEBUG(MSGTYPE_INFO, __FILE__, __LINE__, "Couldn't copy tmp photofile [{$tmp_file}] to [{$dest_file}] - Uploadfile too big according to upload_max_filesize in php.ini"); break;
						case UPLOAD_ERR_FORM_SIZE: 	DEBUG(MSGTYPE_INFO, __FILE__, __LINE__, "Couldn't copy tmp photofile [{$tmp_file}] to [{$dest_file}] - Uploadfile too big according to HTML formular value MAX_FILE_SIZE"); break;
						case UPLOAD_ERR_PARTIAL: 	DEBUG(MSGTYPE_INFO, __FILE__, __LINE__, "Couldn't copy tmp photofile [{$tmp_file}] to [{$dest_file}] - Uploadfile uploaded partially"); break;
						case UPLOAD_ERR_NO_FILE: 	DEBUG(MSGTYPE_WARNING, __FILE__, __LINE__, "Couldn't copy tmp photofile [{$tmp_file}] to [{$dest_file}] - File not uploaded"); break;
						default: DEBUG(MSGTYPE_WARNING, __FILE__, __LINE__, "Couldn't copy tmp photofile [{$tmp_file}] to [{$dest_file}] - Unknown problem"); break;
					}//switch
					
					
					$gl_oVars->cTpl->assign( 'msg_type', 	'error' );
					$gl_oVars->cTpl->assign( 'msg_title', 	'Fehler' );
					
					if( $error_code == UPLOAD_ERR_INI_SIZE ) $gl_oVars->cTpl->assign( 'msg_text', 	$gl_oVars->aLngBuffer['basic']['c4556'] );
					if( $error_code == UPLOAD_ERR_FORM_SIZE ) $gl_oVars->cTpl->assign( 'msg_text', 	$gl_oVars->aLngBuffer['basic']['c4557'] );
					if( $error_code == UPLOAD_ERR_PARTIAL ) $gl_oVars->cTpl->assign( 'msg_text', 	$gl_oVars->aLngBuffer['basic']['c4558'] );
					if( $error_code == UPLOAD_ERR_NO_FILE ) $gl_oVars->cTpl->assign( 'msg_text', 	$gl_oVars->aLngBuffer['basic']['c4559'] );
					
				}
			}# on Upload
			
		}// $_GET['a']
		
		

?>