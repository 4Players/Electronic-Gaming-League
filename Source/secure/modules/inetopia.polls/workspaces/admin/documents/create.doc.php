<?php
	global $gl_oVars;

	
	$cPolls			= new Polls( $gl_oVars->cDBInterface );
	$cMyCategory	= new MyCategory( $gl_oVars->cDBInterface );	
	
	
	# ---------------------------------------------------------------------
	# fetch action data
	# ---------------------------------------------------------------------
	if( $_GET['a'] )
	{
		$poll_obj = NULL;
		
		# set date / clock
		list ($day, $month, $year) = explode('.', $_POST['start_time_date']); 
		list ($hour, $min) = explode(':', $_POST['start_time_clock']); 
		$poll_obj->start_time	= mktime( $hour, $min, 0, $month, $day, $year );
		
		list ($day, $month, $year) = explode('.', $_POST['end_time_date']); 
		list ($hour, $min) = explode(':', $_POST['end_time_clock']); 
		$poll_obj->end_time	= mktime( $hour, $min, 0, $month, $day, $year );

		$poll_obj->created		= EGL_TIME;
		$poll_obj->question 	= $_POST['poll_question'];
		$poll_obj->text 		= $_POST['poll_text'];
		$poll_obj->cat_id 		= $_POST['poll_cat_id'];
		
		# poll stopped?
		if( $_POST['poll_stopped'] == 'yes' ) $poll_obj->stopped = 1;
		else $poll_obj->stopped = 0;
			
		# show results during poll?
		if( $_POST['poll_show_results'] == 'yes' ) $poll_obj->show_results = 1;
		else $poll_obj->show_results = 0;
		
		
		// select locktype
		switch( $_POST['lock_type'] )
		{
			case 'no_lock': break;
			case 'ip_lock': $poll_obj->lock_ip=1; break;
			case 'memberid_lock': $poll_obj->lock_memberid=1; break;
		};
		
		
		#-------------------------------------------------
		# execute insert 'question' query
		#-------------------------------------------------
		if( $gl_oVars->cDBInterface->Query( $gl_oVars->cDBInterface->CreateInsertQuery( TB_POLLS, $poll_obj ) ) )
		{
			$gl_oVars->cTpl->assign( 'success', true ); 
		}//if
		else
		{
			DEBUG( MSGTYPE_ERROR, __FILE__, __LINE__, "Couldn't create poll [query-error]" );

		}// if, else
		
		
		
		$iPollId = (int)$gl_oVars->cDBInterface->InsertId();
		
		#--------------------------------------------------------------------------------------------------------		
		#--------------------------------------------------------------------------------------------------------		
		
		$answer_index_cnt=0;
		for( $a=0; $a < 10; $a++ )	/* 8 questions, defined in tpl */
		{
			$answer_obj = NULL;
			$str_answer = $_POST["poll_answer_{$a}"];
			if( strlen($str_answer) > 0 )
			{
				$answer_obj->poll_id 	= $iPollId;
				$answer_obj->answer 	= $str_answer;
				$answer_obj->sub_index	= $answer_index_cnt;
				$answer_obj->created 	= EGL_TIME;
				
				
				#-------------------------------------------------
				# execute insert 'question' query
				#-------------------------------------------------
				if( $gl_oVars->cDBInterface->Query(  $gl_oVars->cDBInterface->CreateInsertQuery( TB_POLLS_ANSWERS, $answer_obj ) ) )
				{
					$gl_oVars->cTpl->assign( 'success', true ); 
				}//if
				else
				{
				}// if, else
				
				$answer_index_cnt++;
			}//if
		}//for
		
		
		$gl_oVars->cTpl->assign( 'msg_type', 	'success' );
		$gl_oVars->cTpl->assign( 'msg_title', 	'Poll erstellt' );
		$gl_oVars->cTpl->assign( 'msg_text', 	'Umfrage wurde erfolgreich erstellt.' );
		
		
	}//if
	else
	{
	}//if,else

	
	
	# get root data
	$oCatRoot = $cMyCategory->GenerateTree( -1, -1 );
	$gl_oVars->cTpl->assign( 'categoryroot', $oCatRoot );	
?>