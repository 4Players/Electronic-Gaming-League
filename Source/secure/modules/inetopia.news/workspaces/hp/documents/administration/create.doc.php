<?php
	global $gl_oVars;
	
	$cNews = new News( $gl_oVars->cDBInterface );
	$cMyCategory	= new MyCategory( $gl_oVars->cDBInterface );

	
	#----------------------------------------------
	# test
	#----------------------------------------------
	if( $_GET['a'] == 'go' )
	{
		$bUploadScript = false;
		if( $_POST['imagetype'] == 'uploadfile' ) $bUploadScript = true;
		$image_file_saved_file = "";
		
		// run upload script
		if( $bUploadScript && $_FILES['upload_file'])
		{
			$news_images_root = EGL_PUBLIC.'files'.EGL_DIRSEP.'news_pool'.EGL_DIRSEP;
			
			//$oNews = $cNews->GetSingleNews( $iNewsId );
			
			# check for right size
			$tmp_file 		= $_FILES['upload_file']['tmp_name'];
			$tmp_filesize 	= filesize( $tmp_file ) / 1024; # => convert to kb
					
			# check
			$extension_addion 	= $_POST['file_extension'];
			$extension			= get_file_extension( $_FILES['upload_file']['name'], -1 );
			#$extension 		= "jpg";
					
			# define file_name saving/saved
			# $saved_file		= md5( $oNews->id.CreateRandomPassword(4)).$extension_addion.'.'.$extension;
			$saved_file		= CreateRandomPassword(4).'_'.$iNewsId.'_'.$extension_addion.'.'.$extension;
			
			/*	
			# delete old data
			if( $oNews->logo_file != 'non' )	
				if( file_exists( $news_images_root . $oNews->image_file ) )  
					_unlink( $news_images_root . $oNews->image_file  );
					*/
				
			#---------------------------
			# save ... 
			#---------------------------
			if( _copy( $tmp_file, $news_images_root . $saved_file ) )	# image_size bekannt ? => small / big
			{	
				
				//$up_obj 				= NULL;
				//$up_obj->image_file 	= $saved_file;
				
				$b_success 			= tue;
				//$b_success 			= $cNews->SetNewData( $up_obj, $oGame->id );
				$image_file_saved_file	= $saved_file;
						
															
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
						
				if( $error_code == UPLOAD_ERR_INI_SIZE ) $gl_oVars->cTpl->assign( 'msg_text', 	'Die Datei �berschreitet die maximale Dateigr��e' );
				if( $error_code == UPLOAD_ERR_FORM_SIZE ) $gl_oVars->cTpl->assign( 'msg_text', 	'Die Datei �berschreitet die maximale Dateigr��e' );
				if( $error_code == UPLOAD_ERR_PARTIAL ) $gl_oVars->cTpl->assign( 'msg_text', 	'Datei konnte nur teilweise hochgeladen werden. Bitte versuchen Sie den Vorgang erneut.' );
				if( $error_code == UPLOAD_ERR_NO_FILE ) $gl_oVars->cTpl->assign( 'msg_text', 	'Unbekannter Fehler aufgetreten. Bitte melden Sie dies umgehend Ihrem Webmaster. Vielen Dank!' );
						
			} // else copy file

		}// run upload script

			
		
		list ($day, $month, $year) = explode('.', $_POST['release_date']); 
		list ($hour, $min, $sec) = explode(':', $_POST['release_clock']); 
		$release_timestamp	= mktime( $hour, $min, $sec, $month, $day, $year );
		
		// set standard
		$_POST['news_cat_id'] = $_GET['cat_id'];

		/*
		$news_obj = NULL;
		$news_obj->cat_id 		= $_POST['news_cat_id']; //$_POST['news_cat_id'];
		$news_obj->subject 		= $_POST['news_subject'];
		$news_obj->title	 	= $_POST['news_title'];
		$news_obj->short_text	= $_POST['news_short_text'];
		$news_obj->text 		= $_POST['news_text'];
		$news_obj->member_id	= $gl_oVars->iMemberId;*/
		
		$news_obj = 
		array( 	'cat_id'	=> $_POST['news_cat_id'],
				'title'		=> $_POST['news_title'],
				'subject'	=> $_POST['news_subject'],
				'short_text'=> $_POST['news_short_text'],
				'text'		=> $_POST['news_text'],
				'member_id'	=> $gl_oVars->iMemberId,
				'released'	=> $release_timestamp,
				'created'	=> EGL_TIME );
						
		
		//$news_obj->member_id 	= EGL_NO_ID; //$gl_oVars->oMemberData->id;
		//$news_objrelease	 	= $release_timestamp;
		//$news_obj->created 		= EGL_TIME;
		if( $_POST['imagetype'] == 'non' ) $news_obj['image_file'] = 'non';
		if( $_POST['imagetype'] == 'exists' )$news_obj['image_file'] = $_POST['image_file'];
		if( $_POST['imagetype'] == 'uploadfile' )$news_obj['image_file'] = $image_file_saved_file;


		if( $cNews->CreateNews( $news_obj ) )
		{
			$gl_oVars->cTpl->assign( 'msg_type', 	'success' ); 
			$gl_oVars->cTpl->assign( 'msg_title', 	'News erstellt' ); 
			$gl_oVars->cTpl->assign( 'msg_text', 	'Die News wurde erfolgreich erstellt.' ); 
			
			$gl_oVars->cTpl->assign( "success", true );
			
			PageNavigation::Location( $gl_oVars->sURLFile.'?page='.$gl_oVars->sModuleId.':administration.categories&cat_id='.(int)$_GET['cat_id'] );
		}
		
	}//if

	# get root data
	$oCatRoot = $cMyCategory->GenerateTree( -1, -1 );
	$gl_oVars->cTpl->assign( 'categoryroot', $oCatRoot );
	
	
	$aImageFiles 	= array();
	$myDir 			= new MyDirectory();
	
	// open
	if( $myDir->Open( EGL_PUBLIC . 'files/news_pool' ))
	{
		$aImageFiles = $myDir->GetFiles();	
	}
	$gl_oVars->cTpl->assign( 'imagefiles', $aImageFiles );
	

	
	
	// upload settings	
	$server_settings = array( 'file_uploads' 				=> get_cfg_var('file_uploads'),
							  'upload_max_filesize' 		=> get_cfg_var('upload_max_filesize'),
							  'memory_limit'				=> get_cfg_var('memory_limit'),
							  'post_max_size' 				=> get_cfg_var('post_max_size'),
							  'max_execution_time' 			=> get_cfg_var('max_execution_time') );
	$gl_oVars->cTpl->assign( 'UPLOAD_SETTINGS', $server_settings );

?>