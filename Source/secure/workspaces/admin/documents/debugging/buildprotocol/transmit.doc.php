<?php
	global $gl_oVars;
	
	
	if( $_GET['a'] == "send" )
	{
		
		$mailer = new PHPMailer();

		$mailer->From = "bug-report@eglonline.de";
		$mailer->FromName = "EGL.ConfigSheet.Bugreporter";
		$mailer->IsHTML( false );
		
		$body	 = "----------------------------------------";
		$body	.= "\nAutomatischer Bug-Report: Generiert mit EGL v".EGL_CURRENT_VERSION." - ";
		$body	.= "-\n---------------------------------------";
		
		$body	.= "\n\n";
		$body	.= "\nErstellt am: ".strftime( "%D - %T", EGL_TIME );
		$body	.= "\nÜberschrift: ".$_POST['caption'];
		$body	.= "\n > [More] ".$_POST['caption_more'];
		$body	.= "\nName: ".$_POST['name'];
		$body	.= "\nKontaktmöglichkeit: ".$_POST['contact'];
		$body	.= "\nKurzbeschreibung: ".$_POST['shot_text'];
		$body	.= "\nDetailbeschreinung:\n".$_POST['long_text'];
		
		$body	.= "\n\n\nURL: ".$gl_oVars->sURLFile . " auf ".$_SERVER['HTTP_HOST'] . "/ ".$_SERVER['REMOTE_ADDR'];
		$body	.= "\nBrowser: ".$_SERVER['HTTP_USER_AGENT'];
		$mailer->Body = $body;
		
		$attached_buildfile = FIX_URL_SEP( EGL_SECURE."debug/output/".$_POST['buildfile'] );
		$mailer->AddAttachment( $attached_buildfile, "Buildprotokoll.htm" );
		$mailer->AddAddress( "bug-report@eglonline.de", "Ínetopia.EGL Team" );
		
			
		if(!$mailer->Send())
		{
			$gl_oVars->cTpl->assign( "message", "<br/><b>Es ist ein Fehler aufgetreten beim Senden Ihrer Nachricht an `bug-report@eglonline.de` <br/><br/> - [".$mailer->ErrorInfo."]</b>");
		}
		else
		{
			$gl_oVars->cTpl->assign( "message", "");
			$gl_oVars->cTpl->assign( "success", true );
		}
		
		$mailer->ClearAddresses();
		$mailer->ClearAttachments();
	}

	
	$gl_oVars->cTpl->assign( "buildprotocol_file",	$_GET['file'] );
	
?>