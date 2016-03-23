<?php
# ================================ Copyright © 2005-2006 Inetopia, All rights reserved. ==========================
# 
#
# Purpose:
# ================================================================================================================


# -[ defines ]-




# -[ class ] -
class InetNewsletter
{
	# -[ variables ]-
	var $sTbData	= 'unknown';
	var $pDBCon	= NULL;			# pointer to current mysql object 
	
	# -[ functions ]-
	
	
	//-------------------------------------------------------------------------------
	// Purpose: constructor
	// Output :
	//-------------------------------------------------------------------------------
	function InetNewsletter ( &$pDBCon, $tbdata )
	{
		$this->pDBCon = &$pDBCon;
		$this->sTbData =  $tbdata;
	}
	
	
	//-------------------------------------------------------------------------------
	// Purpose: add a mail to the maillist
	//-------------------------------------------------------------------------------
	function AddMail( $obj )
	{		
		$s_query = $this->pDBCon->CreateInsertQuery($this->sTbData, $obj );
		return ($this->pDBCon->Query( $s_query));
	}
	
	
	//-------------------------------------------------------------------------------
	// Purpose: add a mail to the maillist
	//-------------------------------------------------------------------------------
	function AddDraft( $obj )
	{		
		$s_query = $this->pDBCon->CreateInsertQuery( "egl_inetopia_newsletter_drafts", $obj );
		return ($this->pDBCon->Query( $s_query));
	}
	
	
	//-------------------------------------------------------------------------------
	// Purpose: remove a mail from a maillist
	//-------------------------------------------------------------------------------
	function RemoveMail( $email )
	{
		$s_query = "DELETE FROM ".$this->sTbData." WHERE email='{$email}'";
		echo "test";
		$qre = ($this->pDBCon->Query( $s_query));
		return $this->pDBCon->AffectedRowCount();
	}
	
	
	
	//-------------------------------------------------------------------------------
	// Purpose: remove a mail from a maillist
	//-------------------------------------------------------------------------------
	function DeleteDraft( $draft_id )
	{
		$s_query = "DELETE FROM `egl_inetopia_newsletter_drafts` WHERE id={$draft_id}";
		$qre = ($this->pDBCon->Query( $s_query));
		return $this->pDBCon->AffectedRowCount();
	}
	
	
	
	//-------------------------------------------------------------------------------
	// Purpose: remove a mail from a maillist
	//-------------------------------------------------------------------------------
	function DeleteMail( $id )
	{
		$s_query = "DELETE FROM ".$this->sTbData." WHERE id=$id";
		$qre = ($this->pDBCon->Query( $s_query));
		return $this->pDBCon->AffectedRowCount();
	}

	
	//-------------------------------------------------------------------------------
	// Purpose: try to get the code of the overgiven email
	//-------------------------------------------------------------------------------
	function CheckMailCode( $email, $code )
	{
		$md5 = md5( strtolower($email).$code );
		#echo $md5;
		$query = "SELECT * FROM ".$this->sTbData." WHERE email='$email'";
		$qre = ($this->pDBCon->Query( $query));
		$data = $this->pDBCon->FetchObject($qre);
		
		# check code
		if( $data )
			if( $md5 == md5(strtolower($data->email).$data->code))
				return true;
		return false;
	}
	
	
	//-------------------------------------------------------------------------------
	// Purpose:
	//-------------------------------------------------------------------------------	
	function GetNumMails()
	{
		$query = "SELECT COUNT(*) AS num_mails FROM ".$this->sTbData."";
		$qre = ($this->pDBCon->Query( $query));
		$data = $this->pDBCon->FetchObject($qre);
		return $data->num_mails;
	}
		
	//-------------------------------------------------------------------------------
	// Purpose:
	//-------------------------------------------------------------------------------	
	function GetNumSentMails()
	{
		$query = "SELECT SUM(num_mails) AS num_sent_mails FROM ".$this->sTbData."";
		$qre = ($this->pDBCon->Query( $query));
		$data = $this->pDBCon->FetchObject($qre);
		return $data->num_sent_mails;
	}
	
	//-------------------------------------------------------------------------------
	// Purpose:
	//-------------------------------------------------------------------------------	
	function GetNumNewsletterDrafts()
	{
		$query = "SELECT COUNT(drafts.id) AS num_drafts FROM `egl_inetopia_newsletter_drafts` AS drafts";
		$qre = ($this->pDBCon->Query( $query));
		$data = $this->pDBCon->FetchObject($qre);
		return $data->num_drafts;
	}
	
	
	
	//-------------------------------------------------------------------------------
	// Purpose:
	//-------------------------------------------------------------------------------	
	function GetAllMails($on, $to, $start, $cnt)
	{
		# prüfe Mysql-Verbindung
		if( !$this->pDBCon->Connected() )
			return false;
			
		$sLimit = "";
		$sSearch= "";
		if( $cnt > 0 ) $sLimit = " LIMIT $start,$cnt ";
		if( $on > 0 && $to > 0 ) $sSearch = " WHERE (created >= $on && created <= $to ) ";
		// create query
		$query = "SELECT * FROM ".($this->sTbData)." ORDER BY created DESC $sLimit";

		// execute query
		$qre = $this->pDBCon->Query( $query );
		
		
		//echo mysql_error();
		if( !$qre )	return false;
		return $this->pDBCon->FetchArrayObject( $qre );		
	}
	
	
	//-------------------------------------------------------------------------------
	// Purpose:
	//-------------------------------------------------------------------------------	
	function GetAlleMails()
	{
		// create query
		$query = "SELECT id,email,code FROM ".($this->sTbData)." ORDER BY created DESC ";

		// execute query
		$qre = $this->pDBCon->Query( $query );
		
		//echo mysql_error();
		if( !$qre )	return false;
		return $this->pDBCon->FetchArrayObject( $qre );		
	}
	
	//-------------------------------------------------------------------------------
	// Purpose:
	//-------------------------------------------------------------------------------	
	function GetNewsletterDrafts()
	{
		// create query
		$query = "SELECT * FROM `egl_inetopia_newsletter_drafts` ORDER BY created DESC ";

		// execute query
		$qre = $this->pDBCon->Query( $query );
		if( !$qre )	return false;
		return $this->pDBCon->FetchArrayObject( $qre );		
	}
	
	
	
	//-------------------------------------------------------------------------------
	// Purpose:
	//-------------------------------------------------------------------------------	
	function GetNewsletterDraft( $draft_id )
	{
		// create query
		$query = "SELECT * FROM `egl_inetopia_newsletter_drafts` WHERE id={$draft_id} ";

		// execute query
		$qre = $this->pDBCon->Query( $query );
		
		
		//echo mysql_error();
		if( !$qre )	return false;
		return $this->pDBCon->FetchObject( $qre );		
	}

	
	
	//-------------------------------------------------------------------------------
	// Purpose:
	//-------------------------------------------------------------------------------	
	function IncMailCounter()
	{
		// create query
		$query = "UPDATE ".($this->sTbData)." SET num_mails=num_mails+1";

		// execute query
		$qre = $this->pDBCon->Query( $query );		
	}
		
	
	//-------------------------------------------------------------------------------
	// Purpose:
	//-------------------------------------------------------------------------------	
	function MailExists( $email )
	{
		$query = "SELECT COUNT(*) AS num_mails FROM ".$this->sTbData." WHERE email='$email'";
		$qre = ($this->pDBCon->Query( $query));
		$data = $this->pDBCon->FetchObject($qre);
		return $data->num_mails;
	}
	
	
	
};



?>