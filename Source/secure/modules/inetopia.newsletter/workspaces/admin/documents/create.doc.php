<?php
	global $gl_oVars;
	
	#  create newsletter object
	$cNewsletter = new InetNewsletter( $gl_oVars->cDBInterface, "egl_inetopia_newsletter" );

	
	$sModuleRoot = FIX_URL_SEP( MODULE_DIR . $gl_oVars->oModule->sModulePath.'/' );
	$sSignaturesRoot =  FIX_URL_SEP( $sModuleRoot . '/signatures/' );
	$sSendingRoot = FIX_URL_SEP( $sModuleRoot . 'sending/' );

	$bSendMail	= false;
	$aEmailList	= array();

	
	if( $_POST['newsletter_method'] == 'send_mail' )
	{
		$bSendMail = true;
	}
	if( $_POST['newsletter_method'] == 'save_draft' )
	{
		$draft_obj = NULL;
		$draft_obj->type					= $_POST['newsletter_type'];
		$draft_obj->from_name				= $_POST['newsletter_mailer_from_name'];
		$draft_obj->from_email				= $_POST['newsletter_mailer_from_email'];
		$draft_obj->title					= $_POST['newsletter_title'];
		$draft_obj->text					= $_POST['newsletter_message'];
		$draft_obj->signature				= $_POST['newsletter_signature'];
		$draft_obj->created					= EGL_TIME;
		if( $_POST['newsletter_add_distribute'] == 'yes' )$draft_obj->distribution_enabled	= 1;
		
		$cNewsletter->AddDraft( $draft_obj );
		$bSendMail = true;
	}
	if( $_POST['newsletter_method'] == 'only_save_draft' )
	{
		$draft_obj = NULL;
		$draft_obj->type					= $_POST['newsletter_type'];
		$draft_obj->from_name				= $_POST['newsletter_mailer_from_name'];
		$draft_obj->from_email				= $_POST['newsletter_mailer_from_email'];
		$draft_obj->title					= $_POST['newsletter_title'];
		$draft_obj->text					= $_POST['newsletter_message'];
		$draft_obj->signature				= $_POST['newsletter_signature'];
		$draft_obj->created					= EGL_TIME;
		if( $_POST['newsletter_add_distribute'] == 'yes' )$draft_obj->distribution_enabled	= 1;
		
		$cNewsletter->AddDraft( $draft_obj );
				
		$gl_oVars->cTpl->assign( 'msg_type',	'success');
		$gl_oVars->cTpl->assign( 'msg_title',	'Erfolgreich');
		$gl_oVars->cTpl->assign( 'msg_text',	'Der Newsletter wurde erfolgreich gespeichert.<br><br> Sie finden diesen direkt in der Vorlagen Übersicht');
		$gl_oVars->cTpl->assign( 'success',		true );
	}
		
	if( $_GET['a'] == 'go' )
	{
		if( $bSendMail )
		{
			$type 		= $_POST['newsletter_type'];
			$from_name 	= $_POST['newsletter_mailer_from_name'];
			$from_email	= $_POST['newsletter_mailer_from_email'];
			$title		= $_POST['newsletter_title'];
			$message	= $_POST['newsletter_message'];
			$signature	= $_POST['newsletter_signature'];
			$distribute	= $_POST['newsletter_add_distribute'];
			$mailinglist= $_POST['newsletter_mailinglist'];
			
			
			
			$cMailer = new PHPMailer();
			/*if( strlen($g_mailer_smtp) > 0 )
			{
				$cMailer->IsSMTP();
				$cMailer->Host = $g_mailer_smtp;
			}*/
	
			# set up mailer
			$cMailer->From 		= $from_email;
			$cMailer->FromName 	= $from_name;
			$cMailer->AddReplyTo( $from_email, $from_name );
	
			
			$cMailer->Subject 	= $title;
			$cMailer->Body 		.= $message;
			
			
			// signature has been set???
			if( $signature != 'non' )
			{
				$signature_file = $sSignaturesRoot . $signature;
				
				// file exisits??
				if( file_exists( $signature_file ) )
				{
					$cFile = new File();
					if( $cFile->Open( $signature_file, "r" ) )
					{
						$signature_text = $cFile->Read();
						$cFile->Close();
						
						// add signaure to body
						$cMailer->Body .= "\n".$signature_text;
					}//if
				}//if
			}//if
			
			
			$sURL = "";
	
			// austragen aktiviert??
			if( $distribute == "yes" )
			{
				$sURL = dirname( $_SERVER['HTTP_REFERER']).EGL_DIRSEP."index.php";
			}	
			
			
			
			#------------------------------------
			# get all emails
			#------------------------------------
			if( $mailinglist == "newsletterlist" )
			{
				$aEmailList = $cNewsletter->GetAlleMails();
			}
			if( $mailinglist == "memberlist" )
			{
				$aEmailList = $gl_oVars->cMember->GetMailingList();
			}
			if( $mailinglist == "adminlist" )
			{
				$cAdministrator = new Administrator( $gl_oVars->cDBInterface );
				$aEmailList = $cAdministrator->GetMailingList();
			}
			
			$iMailerCnt = 0;
			
			$bError = false;
			$bodyTemplate = $cMailer->Body;
			for( $i=0; $i < sizeof($aEmailList); $i++ )
			{
				// reset body
				$cMailer->Body = $bodyTemplate;
				
				// add specified addon
				if( $distribute == "yes" )
				{
					// nur wenn newsletterliste
					if( $mailinglist == "newsletterlist" )
					{
						$cMailer->Body .= "\n\n";
						$cMailer->Body .= "--------------------------------\n";
						$cMailer->Body .= "Wünschen Sie in Zukunft keinen Newsletter mehr?\nHier können Sie sich austragen.";
						$cMailer->Body .= "\n{$sURL}?page=".$gl_oVars->sModuleId.":newsletter&a=remove&email=".$aEmailList[$i]->email."&code=".$aEmailList[$i]->code."";
					}
					//if( $mailinglist == "memberlist" )
						# nichts :)
					
					$cMailer->WordWrap = 50;
					if( $type == 'html' ) 
					{
						$cMailer->IsHTML(true);
						$cMailer->Body = nl2br($cMailer->Body);
					}//if
	
				}//if
				
				$cMailer->AddAddress( $aEmailList[$i]->email );
				if( !$cMailer->Send() )
				{
					$bError = true;
					//break;
				}else $iMailerCnt++;
				$cMailer->ClearAddresses(); // clear last email
			}//for
			
			# try to send 
			if( !$bError )
			{
				// inc counter
				if( $mailinglist == "newsletterlist" )
				{
					$cNewsletter->IncMailCounter();
				}
				
				$gl_oVars->cTpl->assign( 'msg_type',	'success');
				$gl_oVars->cTpl->assign( 'msg_title',	'Erfolgreich');
				$gl_oVars->cTpl->assign( 'msg_text',	'Der Newsletter wurde erfolgreich versendet.<br><br> <b>Stats:</b><br> '.$iMailerCnt.' E-Mails wurden versendet.');
				$gl_oVars->cTpl->assign( 'success',		true );
			}
			else
			{
				$gl_oVars->cTpl->assign( 'msg_type',	'error');
				$gl_oVars->cTpl->assign( 'msg_title',	'Fehler');
				$gl_oVars->cTpl->assign( 'msg_text',	'Es ist ein Fehler aufgetreten. Einzelne Newsletter konnten nicht verschickt werden. Folgenden Gründe kamen während des Sendevorgangs auf.<br><br><b>ERROR:</b>'.$cMailer->ErrorInfo);
				$gl_oVars->cTpl->assign( 'success',		true );
				
				DEBUG( MSGTYPE_ERROR, __FILE__, __LINE__, "Error occured on sending Newsletter - Error report: ".$cMailer->ErrorInfo );
			}
				
		}//$bSend=true
	}
	else
	{
		$cDir = new MyDirectory();
		$cDir->Open( $sSignaturesRoot );
		$aFiles = $cDir->GetFiles();
		$cDir->Close();

		//$gl_oVars->cTpl->assign( 'mailer_from_name', $g_mailer_from_name );
		//$gl_oVars->cTpl->assign( 'mailer_from_email', $g_mailer_from_email );
		//$gl_oVars->cTpl->assign( 'mailer_smtp', $g_mailer_smtp );

		$gl_oVars->cTpl->assign( 'mailer_signatures', $aFiles );
		
		
		$iDraftId	= (int)$_GET['draft_id'];
		$oDraft		= NULL;
		$aDraftList	= array();
		
		if( Isset( $_GET['draft_id'] ))
		{
			$oDraft = $cNewsletter->GetNewsletterDraft( $iDraftId );
			$gl_oVars->cTpl->assign( "draft", $oDraft );
		}//if
	}


?>