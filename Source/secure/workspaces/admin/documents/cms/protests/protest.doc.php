<?php
	global $gl_oVars;
	
	# ------------------------------------------------------------------------
	$iProtestId	= (int)$_GET['protest_id'];
	

	
	$cMatch 	= NULL;
	$cProtests	= new Protests( $gl_oVars->cDBInterface );


	/*if( $oProtest )
	if( $oProtest->match_id != EGL_NO_ID )
	{
		$cMatch = new Match( $gl_oVars->cDBInterface, $oProtest->match_id );
		$oMatch = $cMatch->GetData();
	}*/
	
	
	#---------------------------------------------------------------
	# A C T I O N 
	#---------------------------------------------------------------
	
	if( $_GET['a'] == 'go' )
	{
		$pro_obj = NULL;
		$pro_obj->admin_text = $_POST['admin_text'];
		if( $_POST['administrated'] == 'yes' ) $pro_obj->administrated = 1;
		else $pro_obj->administrated = 0;
		
		if( $cProtests->SetProtestData( $pro_obj, $iProtestId ) )
		{
		}//if setprotestdata
		
	}
	else 
	{
		$ac_obj = NULL;
		$ac_obj->admin_id = $gl_oVars->oMemberData->id;
		$ac_obj->adminaccess_time = EGL_TIME;

		if( $cProtests->SetProtestData( $ac_obj, $iProtestId) )
		{
		}//if setprotestdata
	}//if $_GET go
	
	
	# create comment manage object for members
	$cComments = & new Comments( $gl_oVars->cDBInterface, $GLOBALS['g_egltb_protest_comments'], "protest_id" );

	
	#----------------------------------------------------
	# comment input detected ?
	#----------------------------------------------------
	if( Isset( $_POST['comment_text'] ) &&
		strlen($_POST['comment_text']) > 0 &&
		$gl_oVars->bLoggedIn )
	{
		$msg_obj = NULL;
		$msg_obj->protest_id 	= $iProtestId;;
		$msg_obj->author_id 	= $gl_oVars->oMemberData->id;
		$msg_obj->text 			= $_POST['comment_text'];	
		$msg_obj->created 		= time();
		
		# try to create obj
		if( $cComments->CreateComment($msg_obj) )
		{
			# successful
				
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
	
	# fetch data
	$oProtest	= $cProtests->GetProtest($iProtestId);

	
	
	# tpl

	$gl_oVars->cTpl->assign( 'comments',  $aProtestComments );
	$gl_oVars->cTpl->assign( 'num_comments',  (int)$iProtestCounter );

	
	if( $oProtest ) $gl_oVars->cTpl->assign( 'protest',  $oProtest );
	#if( $oMatch )$gl_oVars->cTpl->assign( 'match',  $oMatch );

?>