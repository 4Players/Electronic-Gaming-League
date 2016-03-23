<?php
	global $gl_oVars;

	$cPM = new PM( $gl_oVars->cDBInterface );

	# ---------------------------------------------
	# Try sending message
	# ---------------------------------------------
	if( $_GET['a'] == 'send' )
	{
		# search member 
		$oMemberResult = $gl_oVars->cMember->GetMemberIdByName( $_POST['pm_receiver'] );
		
		if( $oMemberResult )
		{
			
			# correct input 
			if( strlen($_POST['pm_title']) > 0 && strlen($_POST['pm_text']) > 0 )
			{
				
				# sending to myself ?
				if( $oMemberResult->id == $gl_oVars->iMemberId )
				{
					// Nachrichten können nicht an sich selbst geschickt werden !
					$gl_oVars->cTpl->assign( 'msg_type', 	'error' );
					$gl_oVars->cTpl->assign( 'msg_text', 	$gl_oVars->aLngBuffer['basic']['c4921'] );
				}
				else
				{
					# ---------------
					# sending....
					# ---------------
					
					$sender_obj 	= NULL;		# sender
					$receiver_obj 	= NULL;		# receiver
					
					# same informations
					$receiver_obj->title 		= $sender_obj->title	 	= $_POST['pm_title'];
					$receiver_obj->text 		= $sender_obj->text 		= $_POST['pm_text'];
					$receiver_obj->created 		= $sender_obj->created 		= time();
					$receiver_obj->sender_id	= $sender_obj->sender_id	= $gl_oVars->iMemberId;	
					$receiver_obj->receiver_id	= $sender_obj->receiver_id	= $oMemberResult->id;
					
					# sender ( me )			=> output
					$sender_obj->member_id 		= $gl_oVars->iMemberId;	
					
					# receiver ( other )	=>  input
					$receiver_obj->member_id 	= $oMemberResult->id;	
	
					# try sending...
					
					//$gl_oVars->cTpl->assign( 'pm_sent_name',  $oMemberResult->nick_name );
					
					
					# successed ?
					if( $gl_oVars->cMember->CreatePM( $sender_obj ) &&
						$gl_oVars->cMember->CreatePM( $receiver_obj ) )
					{
						// Ihre Nachricht wurde erfolgreich an {$pm_sent_name} gesendet
						$gl_oVars->cTpl->assign( 'msg_type', 	'success' );
						$gl_oVars->cTpl->assign( 'msg_text', 	Templates::ParseContent( $gl_oVars->aLngBuffer['basic']['c4922'],
																$gl_oVars->cTpl,
																array( 'pm_name' => $oMemberResult->nick_name ))
																);
						
						# sent
						$gl_oVars->cTpl->assign( 'pm_sent',	1 );
					}
					else
					{
						$gl_oVars->cTpl->assign( 'msg_type', 	'error' );
						$gl_oVars->cTpl->assign( 'msg_text', 	$gl_oVars->aLngBuffer['basic']['c4923'] );
					}
				} // if own ID ?
			
			}
			else 
			{
				# wrong input
				$gl_oVars->cTpl->assign( 'msg_type', 	'error' );
				$gl_oVars->cTpl->assign( 'msg_text', 	$gl_oVars->aLngBuffer['basic']['c4934'] );
			}
		
			
		}
		else
		{
			// Der Name des Empfängers konnte niemandem zugeordnet werden. Bitte überprüfen Sie nochmals die Schreibweise des Names
			# no member found 
			$gl_oVars->cTpl->assign( 'msg_type', 	'error' );
			$gl_oVars->cTpl->assign( 'msg_text', 	$gl_oVars->aLngBuffer['basic']['c4935'] );
		}
		
	} # if send


	# member_id set ?
	if( Isset( $_GET['member_id'] ) )
	{
		$nick_name = $gl_oVars->cMember->__GetMemberNickName( (int)$_GET['member_id'] );
		if($nick_name)
		{
			$_POST['pm_receiver'] = $nick_name;
		}//if
	}//if

	
	if( isset( $_GET['pm_id']))
	{
		$oRepm = $cPM->GetMessage($_GET['pm_id']);

		if( $oRepm && $oRepm->receiver_id == $gl_oVars->oMemberData->id )
		{
			$gl_oVars->cTpl->assign( 'pm_re_title', $oRepm->title );
		}//if
	}//if
	
	# save last input values
	$gl_oVars->cTpl->assign( 'pm_last_input', $_POST );

?>