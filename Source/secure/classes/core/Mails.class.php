<?php
# ================================ Copyright © 2005-2006 Inetopia, All rights reserved. ==========================
# 
#
# Purpose:
# ================================================================================================================



# -[ defines ]-



# -[ objectlist ] -




# -[ class ] -
class Mails
{
	
	# -[ functions ]-
	var $Smarty		= NULL;
	var $Phpmailer	= NULL;
	var $bHTML		= false;
	
	var $From		= "unknown@eglonline.de";
	var $FromName	= "Ínetopia.EGL";
	
	
	# =========================================================================
	# PUBLIC
	# =========================================================================
	
	//-------------------------------------------------------------------------------
	// Purpose: constructor
	// Output : -
	//-------------------------------------------------------------------------------
	function Mails ( $lng, $root='' )
	{
		$this->Smarty 		= new Smarty();
		//$this->Phpmailer 	= new PHPMailer();
		
		if( strlen($root) == 0 ){
			# set directorys
			$this->Smarty->compile_dir	= EGL_SECURE.'data'.EGL_DIRSEP.'smarty'.EGL_DIRSEP.'templates_c'.EGL_DIRSEP.'emails'.EGL_DIRSEP.$lng.EGL_DIRSEP;
			$this->Smarty->template_dir	= EGL_SECURE.'templates'.EGL_DIRSEP.'emails'.EGL_DIRSEP.$lng.EGL_DIRSEP;
		}//if
		else
		{
			# set directorys
			$this->Smarty->compile_dir	= EGL_SECURE.'data'.EGL_DIRSEP.'smarty'.EGL_DIRSEP.'templates_c'.EGL_DIRSEP.'emails'.EGL_DIRSEP.$lng.EGL_DIRSEP;
			if( $root[strlen($root)-1] == EGL_DIRSEP )
				$this->Smarty->template_dir	= $root.$lng.EGL_DIRSEP;
			else
				$this->Smarty->template_dir	= $root.EGL_DIRSEP.$lng.EGL_DIRSEP;
		}//if
	}
	
	
	//-------------------------------------------------------------------------------
	// Purpose: 
	// Output :
	//-------------------------------------------------------------------------------	
	function IsHTML( $bIs )
	{
		$this->bHTML = $bIs;
	}
	
	
	//-------------------------------------------------------------------------------
	// Purpose: 
	// Output :
	//-------------------------------------------------------------------------------	
	function Assign( $var, $data )
	{
		$this->Smarty->assign( $var, $data );
	}
	
	
	
	//-------------------------------------------------------------------------------
	// Purpose: 
	// Output :
	//-------------------------------------------------------------------------------	
	function SetSenderMail( $from_email, $from_name )
	{
		$this->From 	= $from_email;
		$this->FromName = $from_name;
	}
	
	//-------------------------------------------------------------------------------
	// Purpose: 
	// Output :
	//-------------------------------------------------------------------------------	
	function GetLastError(){
		return 'unknown';
	}
	
	
	//-------------------------------------------------------------------------------
	// Purpose: 
	// Output :
	//-------------------------------------------------------------------------------
	/*function SendeMail( $tpl, $subject, $email )
	{
		if( !$this->Smarty->Template_Exists($tpl) ) 
		{
			DEBUG( MSGTYPE_ERROR, __FILE__, __LINE__, "Couldn't send email to `$email`, template `$tpl` not found" );
			return 0;
		}
		
		// register function
		$this->Smarty->register_function("date",  "print_date");
		
		
		
		# set up mailer
		$this->Phpmailer->From 		= $this->From;		# email
		$this->Phpmailer->FromName 	= $this->FromName;
		

		# add single mail to receiverlist
		$this->Phpmailer->AddAddress( $email) ;

		
		$this->Phpmailer->WordWrap = 50;
		$this->Phpmailer->IsHTML($this->bHTML);

		$this->Phpmailer->Subject 	= $subject;
		$this->Phpmailer->Body 		= $this->Smarty->fetch( $tpl );
		if( $this->bHTML )
			$this->Phpmailer->Body = nl2br($this->Phpmailer->Body);
			
		# try mailing
		if( !$this->Phpmailer->Send() )
		{
			DEBUG( MSGTYPE_ERROR, __FILE__, __LINE__, "Couldn't send email to `$email`. ");
			return 0;
		}
		return 1;
	}*/
	
	function SendMail( $subject, $body, $email )
	{
		# Is the OS Windows or Mac or Linux
		if (strtoupper(substr(PHP_OS,0,3)=='WIN')) $eol="\r\n";
		elseif (strtoupper(substr(PHP_OS,0,3)=='MAC')) $eol="\r";
		else $eol="\n";
		
		# set up mailer
		$headers  = '';
		$headers .= 'From: '. $this->FromName.'<'.$this->From.'>'.$eol;
		$headers .= 'Reply-To: '.$this->FromName.'<'.$this->From.'>'.$eol;
		$headers .= 'X-Mailer: PHP/'.phpversion().$eol;
		$headers .= 'MIME-Version: 1.0'.$eol;
		
			
		if( $this->bHTML)
		{
			$headers .= 'Content-Type: text/html;'.$eol;
			//$headers .= "Content-Transfer-Encoding: 8bit".$eol;
			
		}
		else
		{
			$headers .= 'Content-Type: text/plain;'.$eol;
			//$headers .= "Content-Transfer-Encoding: 8bit".$eol;
		}
		
		if( @mail( $email, $subject, $body, $headers ) ){
			return 1;
		}
		else
		{
			DEBUG( MSGTYPE_ERROR, __FILE__, __LINE__, "Couldn't send email to `".$email."`. ");
			return 0;
		}		
	}
		
	
	function SendeMail( $tpl, $subject, $email )
	{
		if( !$this->Smarty->Template_Exists($tpl) ) 
		{
			DEBUG( MSGTYPE_ERROR, __FILE__, __LINE__, "Couldn't send email to `$email`, template `$tpl` not found" );
			return 0;
		}
		// register function
		$this->Smarty->register_function("date",  "print_date");
		
		# Is the OS Windows or Mac or Linux
		if (strtoupper(substr(PHP_OS,0,3)=='WIN')) $eol="\r\n";
		elseif (strtoupper(substr(PHP_OS,0,3)=='MAC')) $eol="\r";
		else $eol="\n";
		
			
		$msg 		= '';
		$body 		= $this->Smarty->fetch( $tpl );
		
		//echo "body: ".$body;
		
		# set up mailer
		$headers  = '';
		$headers .= 'From: '. $this->FromName.'<'.$this->From.'>'.$eol;
		$headers .= 'Reply-To: '.$this->FromName.'<'.$this->From.'>'.$eol;
		$headers .= 'X-Mailer: PHP/'.phpversion().$eol;
		$headers .= 'MIME-Version: 1.0'.$eol;
		
			
		if( $this->bHTML)
		{
			$headers .= 'Content-Type: text/html;'.$eol;
			//$headers .= "Content-Transfer-Encoding: 8bit".$eol;
			
		}
		else
		{
			$headers .= 'Content-Type: text/plain;'.$eol;
			//$headers .= "Content-Transfer-Encoding: 8bit".$eol;
		}

	
		if( mail( $email, $subject, $body, $headers ) ){
			return 1;
		}
		else
		{
			DEBUG( MSGTYPE_WARNING, __FILE__, __LINE__, "Couldn't send email to `".$email."`. ");
			return 0;
		}
	}	
};

?>