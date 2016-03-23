<?php
	# define global communication interface
	global $gl_oVars;
	
	
	# fetch heade data/url
	$poll_id = (int)$_GET['poll_id'];
	
	
	# declare classes / objects
	$cPolls = new Polls( $gl_oVars->cDBInterface );
	$cMyCategory	= new MyCategory( $gl_oVars->cDBInterface );	
	
	
	# get poll data
	$oPoll  	= $cPolls->GetPoll( $poll_id );
	//$aAnswers 	= $cPolls->GetPollAnswers( $oPoll->id );

	
	# valid poll object?
	if( $oPoll )
	{
		
		# ===============================
		# delete answer
		# ===============================
		if( $_GET['a'] == 'delete_answer' )
		{
			$iAnswerId = (int)$_GET['answer_id'];
			$oAnswer = $cPolls->GetPollAnswer( $iAnswerId );
			$cPolls->deleteAnswer( $iAnswerId );

			$sql_query = " UPDATE ".TB_POLLS_ANSWERS."  SET sub_index=sub_index-1 WHERE poll_id={$poll_id} && sub_index > ".$oAnswer->sub_index;
			$gl_oVars->cDBInterface->Query( $sql_query );
			
			$gl_oVars->cTpl->assign( 'success', true ); 
			$gl_oVars->cTpl->assign('msg_type', 	'success' );
			$gl_oVars->cTpl->assign('msg_title', 	'Gelöscht!' );
			$gl_oVars->cTpl->assign('msg_text', 	'Die Antwort wurde erfolgreich gelöscht.' );

		}
		
		# ===============================
		# delete answer
		# ===============================
		else if( $_GET['a'] == 'delete_poll' )
		{
			
			$cPolls->deletePoll( $poll_id );
			$cPolls->deletePollAnswers( $poll_id );
			
			
			$gl_oVars->cTpl->assign( 'success', true ); 
			$gl_oVars->cTpl->assign('msg_type', 	'success' );
			$gl_oVars->cTpl->assign('msg_title', 	'Gelöscht!' );
			$gl_oVars->cTpl->assign('msg_text', 	'Die Umfrage wurde erfolgreich gelöscht.' );

		}
		# ===============================
		# delete answer
		# ===============================
		else if( $_GET['a'] == 'change_subindex' )
		{
			$iAnswerId = (int)$_GET['answer_id'];
			$oAnswer = $cPolls->GetPollAnswer( $iAnswerId );
			$num_answers = sizeof( $cPolls->GetPollAnswers( $oPoll->id ) );
			//echo $num_answers;
			
			if( $_GET['dir'] == 'down' && $oAnswer->sub_index < $num_answers-1 )
			{
				$sql_query1 = " UPDATE ".TB_POLLS_ANSWERS."  SET sub_index=sub_index-1 WHERE poll_id={$poll_id} && sub_index=".($oAnswer->sub_index+1);
				$sql_query2 = " UPDATE ".TB_POLLS_ANSWERS."  SET sub_index=sub_index+1 WHERE poll_id={$poll_id} && id=$iAnswerId";	
				
				$gl_oVars->cDBInterface->Query( $sql_query1 );
				$gl_oVars->cDBInterface->Query( $sql_query2 );
			}
			elseif( $_GET['dir'] == 'up' && $oAnswer->sub_index > 0)
			{
				
				$sql_query1 = " UPDATE ".TB_POLLS_ANSWERS."  SET sub_index=sub_index+1 WHERE poll_id={$poll_id} && sub_index=".($oAnswer->sub_index-1);
				$sql_query2 = " UPDATE ".TB_POLLS_ANSWERS."  SET sub_index=sub_index-1 WHERE poll_id={$poll_id} && id=$iAnswerId";	
				$gl_oVars->cDBInterface->Query( $sql_query1 );
				$gl_oVars->cDBInterface->Query( $sql_query2 );
			}
			
		}
		# ===============================	
		# FILL Templates with DATA
		# ===============================	
			
		# fetch answers
		$aAnswers 	= $cPolls->GetPollAnswers( $oPoll->id );
		$gl_oVars->cTpl->assign( 'poll', $oPoll );
		$gl_oVars->cTpl->assign( 'answers', $aAnswers );
			
		# get root data
		$oCatRoot = $cMyCategory->GenerateTree( -1, -1 );
		$gl_oVars->cTpl->assign( 'categoryroot', $oCatRoot );	
			
		
	}//if
	
	#----------------------------------------
	# CHANGE DATA	
	#----------------------------------------	
		if( $_POST['a'] == 'change' )
		{
			$poll_obj = NULL;
			
			# set date / clock
			list ($day, $month, $year) = explode('.', $_POST['start_time_date']); 
			list ($hour, $min) = explode(':', $_POST['start_time_clock']); 
			$poll_obj->start_time	= mktime( $hour, $min, 0, $month, $day, $year );
			
			list ($day, $month, $year) = explode('.', $_POST['end_time_date']); 
			list ($hour, $min) = explode(':', $_POST['end_time_clock']); 
			$poll_obj->end_time	= mktime( $hour, $min, 0, $month, $day, $year );

			# simple poll data
			$poll_obj->question 	= $_POST['poll_question'];
			$poll_obj->text 		= $_POST['poll_text'];
			$poll_obj->cat_id 		= $_POST['poll_cat_id'];
			
			# poll stopped?
			if( $_POST['poll_stopped'] == 'yes' ) $poll_obj->stopped = 1;
			else $poll_obj->stopped = 0;
			
			# show results during poll?
			if( $_POST['poll_show_results'] == 'yes' ) $poll_obj->show_results = 1;
			else $poll_obj->show_results = 0;
			
			
			$poll_obj->lock_ip = 0;
			$poll_obj->lock_memberid = 0;
			
			// select locktype
			switch( $_POST['lock_type'] )
			{
				case 'no_lock': break;
				case 'ip_lock': $poll_obj->lock_ip=1; break;
				case 'memberid_lock': $poll_obj->lock_memberid=1; break;
			}; # switch
			
			
			#-------------------------------------------------
			# execute insert 'question' query
			#-------------------------------------------------
			if( $gl_oVars->cDBInterface->Query( $gl_oVars->cDBInterface->CreateUpdateQuery( TB_POLLS, $poll_obj )." WHERE id=".$poll_id ) )
			{
				$gl_oVars->cTpl->assign( 'success', true ); 
			}//if
			else
			{
				DEBUG( MSGTYPE_ERROR, __FILE__, __LINE__, "Couldn't update poll [query-error]" );
			}// if, else
			
			
			
			
			############################################
			# UPDATE ANSWERS
			############################################
			
			$answer_index_cnt=0;
			for( $a=0; $a < sizeof($aAnswers); $a++ )	/* 8 questions, defined in tpl */
			{
				$answer_obj = NULL;
				$str_answer = $_POST["poll_answer_{$a}"];
	
				if( strlen($str_answer) > 0 && $aAnswers[$a]->answer != $str_answer )
				{
					//$answer_obj->poll_id 	= $iPollId;
					$answer_obj->answer 	= $str_answer;
					//$answer_obj->sub_index	= $answer_index_cnt;
					$answer_obj->created 	= EGL_TIME;
					
					#-------------------------------------------------
					# execute insert 'question' query
					#-------------------------------------------------
					if( $gl_oVars->cDBInterface->Query(  $gl_oVars->cDBInterface->CreateUpdateQuery( TB_POLLS_ANSWERS, $answer_obj )." WHERE id=".$aAnswers[$a]->id ) )
					{
						$gl_oVars->cTpl->assign( 'success', true ); 
					}//if
					else
					{
					}// if, else
					
					$answer_index_cnt++;
				}//if
			}//for


			############################################
			# NEW ANSWER
			############################################
			$answer_index_cnt=sizeof( $cPolls->GetPollAnswers( $oPoll->id ) );
			
			for( $a=0; $a < 5; $a++ )	/* 8 questions, defined in tpl */
			{
				$answer_obj = NULL;
				$str_answer = $_POST["poll_new_answer_{$a}"];
				if( strlen($str_answer) > 0 )
				{
					$answer_obj->poll_id 	= $oPoll->id;
					$answer_obj->answer 	= $str_answer;
					$answer_obj->sub_index	= $answer_index_cnt;
					$answer_obj->created 	= EGL_TIME;
					
					
					#-------------------------------------------------
					# execute insert 'question' query
					#-------------------------------------------------
					if( $gl_oVars->cDBInterface->Query(  $gl_oVars->cDBInterface->CreateInsertQuery( TB_POLLS_ANSWERS, $answer_obj ) ) )
					{
						$gl_oVars->cTpl->assign( 'success', true ); 
						$answer_index_cnt++;
					}//if
					else
					{
					}// if, else
				}//if
			}//for		
			
			
			$gl_oVars->cTpl->assign('msg_type', 	'success' );
			$gl_oVars->cTpl->assign('msg_title', 	'Update erfolgreich' );
			$gl_oVars->cTpl->assign('msg_text', 	'Die Umfrage wurde erfolgreich geupdatet.' );
			
		}//if $_POST['a'] == "change"
	
?>