<?php
	global $gl_oVars;
	$iNewsId	=(int)$_GET['news_id'];

	
	# fetch news data
	$cNews = new News( $gl_oVars->cDBInterface );
	$cMyCategory	= new MyCategory( $gl_oVars->cDBInterface );
	
			
	$oNews = $cNews->GetSingleNews( $iNewsId );
	
	
	if( $oNews ){
	# ----------------------------------------------
	# go action
	# ----------------------------------------------
	if( $_GET['a'] == 'go' )
	{
		$bUploadScript = false;
		if( $_POST['imagetype'] == 'uploadfile' ) $bUploadScript = true;
		
		

		// run upload script
		if( $bUploadScript )
		{
			$news_images_root = EGL_PUBLIC.'files'.EGL_DIRSEP.'news_pool'.EGL_DIRSEP;
			
			# check for right size
			$tmp_file 		= $_FILES['upload_file']['tmp_name'];
			$tmp_filesize 	= filesize( $tmp_file ) / 1024; # => convert to kb
					
			# check
			$extension_addion 	= $_POST['file_extension'];
			$extension			= get_file_extension( $_FILES['upload_file']['name'], -1 );
			#$extension 		= "jpg";
					
			# define file_name saving/saved
			$saved_file		= CreateRandomPassword(4).'_'.$iNewsId.'_'.$extension_addion.'.'.$extension;
				
			/*	
			# delete old data
			if( $oNews->logo_file != 'non' )	
				if( file_exists( $news_images_root . $oNews->image_file ) )  
					_unlink( $news_images_root . $oNews->image_file  );*/
									
				
			#---------------------------
			# save ... 
			#---------------------------
			if( _copy( $tmp_file, $news_images_root . $saved_file ) )	# image_size bekannt ? => small / big
			{	
				$up_obj 				= NULL;
				$up_obj->image_file 	= $saved_file;
				
				$b_success 			= false;
				$b_success 			= $cNews->SetNewData( $up_obj, $iNewsId );
						
															
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
					$gl_oVars->cTpl->assign( 'msg_text', 	'Das Bild wurde erfolgreich hochgeladen !' );
					
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
						
				if( $error_code == UPLOAD_ERR_INI_SIZE ) $gl_oVars->cTpl->assign( 'msg_text', 	'Die Datei ï¿½berschreitet die maximale Dateigrï¿½ï¿½e' );
				if( $error_code == UPLOAD_ERR_FORM_SIZE ) $gl_oVars->cTpl->assign( 'msg_text', 	'Die Datei ï¿½berschreitet die maximale Dateigrï¿½ï¿½e' );
				if( $error_code == UPLOAD_ERR_PARTIAL ) $gl_oVars->cTpl->assign( 'msg_text', 	'Datei konnte nur teilweise hochgeladen werden. Bitte versuchen Sie den Vorgang erneut.' );
				if( $error_code == UPLOAD_ERR_NO_FILE ) $gl_oVars->cTpl->assign( 'msg_text', 	'Unbekannter Fehler aufgetreten. Bitte melden Sie dies umgehend Ihrem Webmaster. Vielen Dank!' );
						
			} // else copy file

		}// run upload script
		
		
		$update_obj = NULL;
		
		list ($day, $month, $year) = explode('.', $_POST['release_date']); 
		list ($hour, $min, $sec) = explode(':', $_POST['release_clock']); 
		$release_timestamp	= mktime( $hour, $min, $sec, $month, $day, $year );		
		
		$update_obj = 
		array( 	// 'cat_id'	=> $_POST['news_cat_id'],
				'title'		=> $_POST['news_title'],
				'subject'	=> $_POST['news_subject'],
				'short_text'=> $_POST['news_short_text'],
				'text'		=> $_POST['news_text'],
				'released'	=> $release_timestamp );

					
		if( $_POST['imagetype'] == 'non' ) $update_obj['image_file'] = 'non';
		if( $_POST['imagetype'] == 'exists' )$update_obj['image_file'] = $_POST['image_file'];

						
		# execute update
		
		if( $cNews->SetNewData( $update_obj, $iNewsId ) )
		{
			$gl_oVars->cTpl->assign( 'success',  	true );
			$gl_oVars->cTpl->assign( 'msg_type',  	'success' );
			$gl_oVars->cTpl->assign( 'msg_text',  	'Die Newsänderung wurde vom System übernommen' );
			
		}
		else 
		{
		}
		
	}//if
	elseif ($_GET['a'] == 'delete')
	{
		$iNewsId	=(int)$_GET['news_id'];
		
		if( $_POST['delete_accepted'] == 'yes' )
		{
			if( $cNews->DeleteNews( $iNewsId ) )
			{
				$gl_oVars->cTpl->assign( 'delete_success',  	true );
				PageNavigation::Location( $gl_oVars->sURLFile.'?page='.$gl_oVars->sModuleId.':administration.categories&cat_id='.(int)$_GET['cat_id'] );
			}//if
		}//if

	}
	else
	{
		# nichts :o
	}
	
	$aImageFiles 	= array();
	$myDir 			= new MyDirectory();
	
	// open
	if( $myDir->Open( EGL_PUBLIC . 'files/news_pool' ))
	{
		$aImageFiles = $myDir->GetFiles();	
	}
	$gl_oVars->cTpl->assign( 'imagefiles', $aImageFiles );
	
	
	# get root data
	$oCatRoot = $cMyCategory->GenerateTree( -1, -1 );
	$gl_oVars->cTpl->assign( 'categoryroot', $oCatRoot );	
		
	
	$oNews = $cNews->GetSingleNews( $iNewsId );
	$gl_oVars->cTpl->assign( 'news', $oNews );
	

	
	// upload settings	
	$server_settings = array( 'file_uploads' => get_cfg_var('file_uploads'),
							  'upload_max_filesize' => get_cfg_var('upload_max_filesize'),
							  'memory_limit' => get_cfg_var('memory_limit'),
							  'post_max_size' => get_cfg_var('post_max_size'),
							  'max_execution_time' => get_cfg_var('max_execution_time') );
	$gl_oVars->cTpl->assign( 'UPLOAD_SETTINGS', $server_settings );
				
	}//	news exits?
	else{
		$gl_oVars->cTpl->assign( 'msg_type',  	'error' );
		$gl_oVars->cTpl->assign( 'msg_text',  	'Die News existiert nicht' );	
	}
	
?>