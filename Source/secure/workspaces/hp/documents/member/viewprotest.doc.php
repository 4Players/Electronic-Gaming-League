<?php
	global $gl_oVars;
	
	# ------------------------------------------------------------------------
	$iProtestId	= (int)$_GET['protest_id'];
	$_GET['comment']='write';

	
	$cMatch 	= NULL;
	$cProtests	= new Protests( $gl_oVars->cDBInterface );

	# fetch data
	$oProtest	= $cProtests->GetProtest($iProtestId);

	/*if( $oProtest )
	if( $oProtest->match_id != EGL_NO_ID )
	{
		$cMatch = new CMatch( $gl_oVars->cDBInterface, $oProtest->match_id );
		$oMatch = $cMatch->GetData();
	}*/
	
	if( $oProtest->member_id == $gl_oVars->iMemberId )
	{
		#---------------------------------------------------------------
		# A C T I O N 
		#---------------------------------------------------------------
		  
		if( $_GET['a'] == 'go' )
		{
			$pro_obj = array( 'admin_text' 	=> $_POST['admin_text'] );
			if( $_POST['administrated'] == 'yes' )
				$pro_obj['administrated'] = 1;
			else $pro_obj['administrated'] = 0;
			
			if( $cProtests->SetProtestData( $pro_obj, $iProtestId ) )
			{
				PageNavigation::Location( $gl_oVars->sURLFile.'?page='.$gl_oVars->sURLPage.'&protest_id='.$iProtestId );
			}//if setprotestdata
			
		}
		else 
		{
			$ac_obj = array( 	'admin_id'			=> $gl_oVars->oMemberData->id,
								'adminaccess_time' 	=> EGL_TIME,
							);
	
			if( $cProtests->SetProtestData( $ac_obj, $iProtestId) )
			{
				//PageNavigation::Location( $gl_oVars->sURLFile.'?page='.$gl_oVars->sURLPage.'&protest_id='.$iProtestId );
			}//if setprotestdata
		}//if $_GET go
		
		
		# create comment manage object for members
		$cComments = new Comments( $gl_oVars->cDBInterface, $GLOBALS['g_egltb_protest_comments'], 'protest_id' );
	
		
		#----------------------------------------------------
		# comment input detected ?
		#----------------------------------------------------
		if( Isset( $_POST['comment_text'] ) &&
			strlen($_POST['comment_text']) > 0  )
		{
			$msg_obj = array( 	'protest_id' 	=> $iProtestId,
								'author_id'		=> $gl_oVars->oMemberData->id,
								'text'			=> $_POST['comment_text'],
								'created' 		=> EGL_TIME,
							);
			
			# try to create obj
			if( $cComments->CreateComment($msg_obj) )
			{
				# successful
				PageNavigation::Location( $gl_oVars->sURLFile.'?page='.$gl_oVars->sURLPage.'&protest_id='.$iProtestId );
			}
				
		}#/if
	
		$aProtestComments	= NULL;
		$iProtestCounter  	= -1;
	
		# get comment buffer
		if( $_GET['comment'] == 'write' ||
			$_GET['comment'] == 'show' )
		{
	
			# try to catch the comments of current displayed member
			$aProtestComments = $cComments->GetComments( $oProtest->id );
			$iProtestCounter = sizeof($aProtestComments);
		}
			
		# counter already read, else => read
		if( $iProtestCounter == -1 )
			$iProtestCounter = $cComments->GetCommentsCount( $oProtest->id );	
		
	
		$gl_oVars->cTpl->assign( 'comments',  $aProtestComments );
		$gl_oVars->cTpl->assign( 'num_comments',  (int)$iProtestCounter );
	
		
		if( $oProtest ) $gl_oVars->cTpl->assign( 'protest',  $oProtest );
		#if( $oMatch )$gl_oVars->cTpl->assign( 'match',  $oMatch );
	}
	else
	{
		$gl_oVars->cTpl->assign( 'msg_type',	'error' );
		$gl_oVars->cTpl->assign( 'msg_text',	'Du hast keinen Zugriff auf diesen Protest' );
	}
?>