<?php
global $gl_oVars;


# get data
$iMatchId = (int)$_GET['match_id'];

if( !isset($_GET['match_id']) )
	$iMatchId=(int)$_POST['match_id'];

# show comments
$_GET['comment'] = 'write';

# classes
$cReports 	= new MatchReports( $gl_oVars->cDBInterface );
$cMedia 	= new Media( $gl_oVars->cDBInterface );
$cMatch 	= new Match( $gl_oVars->cDBInterface, $iMatchId );
$cTeam		= new Team( $gl_oVars->cDBInterface );


#~1
$oMatch = $cMatch->GetData();
	

if( $oMatch )
{
	$oChallenger	= NULL;
	$oOpponent		= NULL;
		
		
	if( $oMatch->participant_type == PARTTYPE_MEMBER)
	{
		$oChallenger	= $gl_oVars->cMember->GetMemberInfoAsParttype( $oMatch->challenger_id );
		$oOpponent		= $gl_oVars->cMember->GetMemberInfoAsParttype( $oMatch->opponent_id );
	}
	if( $oMatch->participant_type == PARTTYPE_TEAM)
	{
		$oChallenger	= $cTeam->GetTeamInfoAsParttype( $oMatch->challenger_id );
		$oOpponent		= $cTeam->GetTeamInfoAsParttype( $oMatch->opponent_id );
	}
		
	
	
	
	#------------------------------
	# A C T I O N - GG
	#------------------------------
	if( $_GET['a'] == 'update_score' )
	{
	
		#  declare match result structure				
		$oMatchResults = new match_results_t();
		$match_maps = '';
				
		# -------------------------------------------------
		# Scores
		# -------------------------------------------------
		for( $iMap=0; $iMap < $oMatch->num_maps; $iMap++ )
		{
			$pRes = &$oMatchResults->aMapResults[sizeof($oMatchResults->aMapResults)];
			$map_name = $_POST['match_map_'.$iMap];
					
			$pRes = new map_result_t;
			$pRes->map_name = $map_name;
			if( strlen($map_name) > 0 ) $match_maps .= $map_name.',';
			
			
			# fetch rnd 
			for( $iRnd=0; $iRnd < $oMatch->num_rounds; $iRnd++ )
			{
				$rnd_challenger_score 	= $_POST['match_score_'.$iMap.'_round_'.$iRnd.'_challenger'];
				$rnd_opponent_score 	= $_POST['match_score_'.$iMap.'_round_'.$iRnd.'_opponent'];
				
				$pRnd = &$pRes->aRounds[sizeof($pRes->aRounds)];
				
				$pRnd = new round_t;
				$pRnd->challenger_score = $rnd_challenger_score;
				$pRnd->opponent_score = $rnd_opponent_score;
			
			}//for $iRnd 
		}//for $iMap
		
		
		# create db format, to save
		/*
			results		= ....
			maps		= ....
		*/
		$db_data = NULL;
		$db_data = Match::ConvertToMatchDBResult( $oMatchResults );
		
		# convert match score date to richt syntax
		//$match_report_t->oMatchUpdate->results		= $obj->results;
		$obj_match_update =  array( 'results'	=> $db_data->results,
									'maps'		=> $db_data->maps 
								  );
						
						
		# CHANMGE MATCH data
		if( !$cMatch->SetMatchData( $obj_match_update, $oMatch->id ) )
		{
			$gl_oVars->cTpl->assign( 'msg_type', 		'error' );
			$gl_oVars->cTpl->assign( 'msg_title', 		'Update' );
			$gl_oVars->cTpl->assign( 'msg_text', 		'Es ist ein Fehler beim Update aufgetreten. Bitte entnehmen Sie weitere Informatione aus den Build-Protokollen.' );
		}//if
		else
		{
			$gl_oVars->cTpl->assign( 'success',			 true );
			$gl_oVars->cTpl->assign( 'msg_type', 		'success' );
			$gl_oVars->cTpl->assign( 'msg_title', 		'Update' );
			$gl_oVars->cTpl->assign( 'msg_text', 		'Die Matcheinstellungen wurden erfolgreich vom System übernommen.' );
			
			PageNavigation::Location( $gl_oVars->sURLFile.'?page='.$gl_oVars->sURLRealPage.'&match_id='.$iMatchId );
		}
	}
	#--------------------------------------------------------------
	# UPDATE PARAMETERS
	#--------------------------------------------------------------
	else if( $_GET['a'] == 'update_parameters' )
	{
		$match_obj = array( 	'status'	=> $_POST['match_status'],
								'report_id'	=> $_POST['report_id'],
								
							);
		# CHANMGE MATCH data
		if( $cMatch->SetMatchData( $match_obj, $oMatch->id ) )
		{
			$gl_oVars->cTpl->assign( 'success',			 true );
			$gl_oVars->cTpl->assign( 'msg_type', 		'success' );
			$gl_oVars->cTpl->assign( 'msg_title', 		'Update' );
			$gl_oVars->cTpl->assign( 'msg_text', 		'Die Matcheinstellungen wurden erfolgreich vom System übernommen.' );
			
			PageNavigation::Location( $gl_oVars->sURLFile.'?page='.$gl_oVars->sURLRealPage.'&match_id='.$iMatchId );
			
		}//if		
	}
	
	#--------------------------------------------------------------
	# ADD MAP
	#--------------------------------------------------------------
	else if( $_GET['a'] == 'add_map' )
	{	
		$iInsertIndex = (int)$_GET['index'];
		
		# fetch match results
		$oMatchResults = new match_results_t();
		$oMatchResults = Match::FetchMatchResults( $oMatch );

		$new_map = new map_result_t();
		$new_map->map_name 	= '???';
		$new_map->aRounds	= $oMatchResults->aMapResults[0]->aRounds;
		for( $i=0; $i < sizeof($new_map->aRounds); $i++){
			$new_map->aRounds[$i]->challenger_score = 0;
			$new_map->aRounds[$i]->opponent_score 	= 0;
		}

		# merge array to new map result structure
		$oMatchResults->aMapResults = 	array_merge( array_merge( 	array_slice( $oMatchResults->aMapResults, 0, $iInsertIndex ),
																	array($new_map)
									  							),
													array_slice( $oMatchResults->aMapResults, $iInsertIndex, sizeof($oMatchResults->aMapResults)-($iInsertIndex) )
						  						);
		
		# generate db-structure from <match_results_t> object
		$match_db = Match::ConvertToMatchDBResult( $oMatchResults );
		$match_obj = array( 	'results'	=> $match_db->results,
								'maps'		=> $match_db->maps,
								'num_maps'	=> (int)sizeof($oMatchResults->aMapResults)
							);
		# CHANMGE MATCH data
		if( $cMatch->SetMatchData( $match_obj, $oMatch->id ) )
		{
			$gl_oVars->cTpl->assign( 'success',			 true );
			$gl_oVars->cTpl->assign( 'msg_type', 		'success' );
			$gl_oVars->cTpl->assign( 'msg_title', 		'Update' );
			$gl_oVars->cTpl->assign( 'msg_text', 		'Die Mapkonfiguration wurden erfolgreich vom System übernommen.' );
			
			PageNavigation::Location( $gl_oVars->sURLFile.'?page='.$gl_oVars->sURLRealPage.'&match_id='.$iMatchId );
			
		}//if	
									
	}	
	#--------------------------------------------------------------
	# REMOVE MAP
	#--------------------------------------------------------------
	else if( $_GET['a'] == 'remove_map' )
	{	
		$iInsertIndex = (int)$_GET['index'];
		
		# fetch match results
		$oMatchResults = new match_results_t();
		$oMatchResults = Match::FetchMatchResults( $oMatch );
		
		DeleteItemOfArray( $oMatchResults->aMapResults, $iInsertIndex );
		
		# generate db-structure from <match_results_t> object
		$match_db = Match::ConvertToMatchDBResult( $oMatchResults );
		$match_obj = array( 	'results'	=> $match_db->results,
								'maps'		=> $match_db->maps,
								'num_maps'	=> (int)sizeof($oMatchResults->aMapResults)
							);
		# CHANMGE MATCH data
		if( $cMatch->SetMatchData( $match_obj, $oMatch->id ) )
		{
			$gl_oVars->cTpl->assign( 'success',			 true );
			$gl_oVars->cTpl->assign( 'msg_type', 		'success' );
			$gl_oVars->cTpl->assign( 'msg_title', 		'Update' );
			$gl_oVars->cTpl->assign( 'msg_text', 		'Die Mapkonfiguration wurden erfolgreich vom System übernommen.' );
			
			PageNavigation::Location( $gl_oVars->sURLFile.'?page='.$gl_oVars->sURLRealPage.'&match_id='.$iMatchId );
		}//if	
	}	
	#--------------------------------------------------------------
	# EVALUATE MATCH
	#--------------------------------------------------------------
	else if( $_GET['a'] == 'restore_evaluation' )
	{
		$iMatchId = (int)$_GET['match_id'];

		# match currently evaluated?
		if( $oMatch->evaluated )
		{
			$match_report_t = new match_report_t;
			
			$match_report_t->oChallenger 			= $oChallenger;
			$match_report_t->oOpponent 				= $oOpponent;
			$match_report_t->oMatch 				= $oMatch;
			$match_report_t->iParttype 				= $oMatch->participant_type;
			$match_report_t->bFirstReport 			= false;
			$match_report_t->bSecondReport 			= false;
			$match_report_t->bAdmin					= true;
			
			$match_report_t->oMatchResults 			= Match::FetchMatchResults( $oMatch );
			$match_report_t->oMatchUpdate			= NULL;
			
			/**************
				can be updated/modified by module
			**************/
			$match_report_t->oMatchUpdate->status	= MATCH_CLOSED;
			
			
			# SEND #DATA# TO CMOD
			$result = module_sendmessage( $oMatch->module_id, 'match_revoke_evaluation', $match_report_t /*writeable*/  );

			if( $result == MODULERESULT_UNKNOWN )
			{
			}
			else if( $result )
			{
				$gl_oVars->cTpl->assign( 'success',			 true );
				$gl_oVars->cTpl->assign( 'msg_type', 		'success' );
				$gl_oVars->cTpl->assign( 'msg_title', 		'Match zurückgesetzt' );
				$gl_oVars->cTpl->assign( 'msg_text', 		'Das Match wurde vom System erfolgreich zurückgesetzt.' );
			}
			else
			{
				$gl_oVars->cTpl->assign( 'msg_type', 		'error' );
				$gl_oVars->cTpl->assign( 'msg_title', 		'Fehler' );
				$gl_oVars->cTpl->assign( 'msg_text', 		'Es ein Fehler beim Zurücksetzten des Matches aufgetreten. Mehr Informationen entnehmen Sie bitte aus den Build-Protokollen.' );				
			}
			
		}
		else
		{
			$gl_oVars->cTpl->assign( 'msg_type', 		'error' );
			$gl_oVars->cTpl->assign( 'msg_title', 		'Fehler' );
			$gl_oVars->cTpl->assign( 'msg_text', 		'Das Match kann nicht zurückgesetzt werden, da es bereits ausgewertet wurde!' );				
		}
	}	
	#--------------------------------------------------------------
	# EVALUATE MATCH
	#--------------------------------------------------------------
	else if( $_GET['a'] == 'evaluate_match' )
	{
		
		$match_report_t = new match_report_t;
		
		$match_report_t->oChallenger 			= $oChallenger;
		$match_report_t->oOpponent 				= $oOpponent;
		$match_report_t->oMatch 				= $oMatch;
		$match_report_t->iParttype 				= $oMatch->participant_type;
		$match_report_t->bFirstReport 			= false;
		$match_report_t->bSecondReport 			= false;
		$match_report_t->bAdmin					= true;
		
		$match_report_t->oMatchResults 			= Match::FetchMatchResults( $oMatch );
		$match_report_t->oMatchUpdate			= NULL;
		
		/**************
			can be updated/modified by module
		**************/
		$match_report_t->oMatchUpdate->status	= MATCH_CLOSED;
		
		
		# SEND #DATA# TO CMOD
		$result = module_sendmessage( $oMatch->module_id, 'match_evaluate', $match_report_t /*writeable*/  );

		/**************
		 ATTENTION:
		 
		 `$match_report_t->oMatchUpdate` <match_report_t> has been modified by the module, while evaluation!!
		**************************/
				
		# have to be updated
		if( is_object($match_report_t->oMatchUpdate) )
		{
			# CHANMGE MATCH data
			if( $cMatch->SetMatchData( $match_report_t->oMatchUpdate, $oMatch->id ) )
			{
				$gl_oVars->cTpl->assign( 'success',			 true );
				$gl_oVars->cTpl->assign( 'msg_type', 		'success' );
				$gl_oVars->cTpl->assign( 'msg_title', 		'Evaluation' );
				$gl_oVars->cTpl->assign( 'msg_text', 		'Das match wurde erfolgreich ausgewertet.' );
			}//if
			else
			{
				$gl_oVars->cTpl->assign( 'msg_type', 		'error' );
				$gl_oVars->cTpl->assign( 'msg_title', 		'Evaluation' );
				$gl_oVars->cTpl->assign( 'msg_text', 		'Es ist ein unbekannter Fehler bei der Auswertung des Matches aufgetreten.' );
			}
		}
		else
		{
			$gl_oVars->cTpl->assign( 'success',			 true );
			$gl_oVars->cTpl->assign( 'msg_type', 		'success' );
			$gl_oVars->cTpl->assign( 'msg_title', 		'Evaluation' );
			$gl_oVars->cTpl->assign( 'msg_text', 		'Das match wurde erfolgreich ausgewertet.' );
		}

	}
	else if( $_GET['a'] == 'delete_media' )
	{
		$iMediaId	= (int)$_GET['media_id'];
		$oMediaFile = $cMedia->GetSingleMFile( $iMediaId );
		
		$media_file = FIX_URL_SEP( EGL_PUBLIC . EGLDIR_MEDIA . $oMediaFile->file_name );
		
		# delete file
		if( $cMedia->Delete( $oMediaFile->id ) )
		{
			@unlink( $media_file );
			
			$gl_oVars->cTpl->assign( 'success',			 true );
			$gl_oVars->cTpl->assign( 'msg_type', 		'success' );
			$gl_oVars->cTpl->assign( 'msg_title', 		'Gelï¿½scht' );
			$gl_oVars->cTpl->assign( 'msg_text', 		'Die Media-Datei wurde erfolgreich gelöscht.' );
			PageNavigation::Location( $gl_oVars->sURLFile.'?page='.$gl_oVars->sURLRealPage.'&match_id='.$iMatchId );
		}
		
	}
	else
	{
		
		# fetch / read match results <match_results_t>
		$oMatchResult = NULL;
		
		$oMatchResult = Match::FetchMatchResults( $oMatch );
		/*if( $oMatch->report_id != EGL_NO_ID )
		{
			$oMatchResult = Match::FetchMatchResults( $oMatch );
		}
		else
		{
			$oMatchResult = Match::FetchMatchStructure( $oMatch );
		}*/
		
		
		#~3+4
		# read matches from db
		$aMediaFiles	= $cMedia->GetMediaFiles($oMatch->id);
		$aReports		= $cReports->GetReports($oMatch->id);
		
		
		# create comment manage object for members
		$cComments = & new Comments( $gl_oVars->cDBInterface, $GLOBALS['g_egltb_match_comments'], "match_id" );
		
		
		#----------------------------------------------------
		# comment input detected ?
		#----------------------------------------------------
		if( Isset( $_POST['comment_text'] ) &&
			strlen($_POST['comment_text']) > 0 &&
			$gl_oVars->bLoggedIn )
		{
			$msg_obj = NULL;
			$msg_obj->match_id 	= $oMatch->id;
			$msg_obj->author_id = $gl_oVars->oMemberData->id;
			$msg_obj->text 		= $_POST['comment_text'];	
			$msg_obj->created 	= time();
			
			# try to create obj
			if( $cComments->CreateComment($msg_obj) )
			{
				# successful
				PageNavigation::Location( $gl_oVars->sURLFile.'?page='.$gl_oVars->sURLRealPage.'&match_id='.$iMatchId.'&comment=show' );
			}
			
		}#/if
	
		$aMatchComments	= NULL;
		$iMatchCommentCounter  = -1;
		
		# get comment buffer
		if( $_GET['comment'] == 'write' ||
			$_GET['comment'] == 'show' )
		{
			# try to catch the comments of current displayed member
			$aMatchComments = $cComments->GetComments( $oMatch->id );
			$iMatchCommentCounter = sizeof($aMatchComments);
		}
		
		# counter already read, else => read
		if( $iMatchCommentCounter == -1 )
			$iMatchCommentCounter = $cComments->GetCommentsCount( $oMatch->id );
				
			
		# save data as a var into template
		$gl_oVars->cTpl->assign( 'comments',		$aMatchComments ); 
		$gl_oVars->cTpl->assign( 'comment_count', 	$iMatchCommentCounter );
	
			
		#----------------------------------------------------------------------------
		
		
		$gl_oVars->cTpl->assign( 'media_files', 	$aMediaFiles );
		$gl_oVars->cTpl->assign( 'reports', 		$aReports ) ;
		$gl_oVars->cTpl->assign( 'match_result', 	$oMatchResult  );
		$gl_oVars->cTpl->assign( 'challenger', 		$oChallenger  );
		$gl_oVars->cTpl->assign( 'opponent', 		$oOpponent  );
		$gl_oVars->cTpl->assign( 'match', 			$oMatch  );
		
		if( $oMatchResult->bDetailedRounds ) 
			$gl_oVars->cTpl->assign( 'display_detailed_rounds', true );
			
	}//if get[a] == 
}
else
{
	$gl_oVars->cTpl->assign( 'msg_type',	'error' );
	$gl_oVars->cTpl->assign( 'msg_title',	'Fehler' );
	$gl_oVars->cTpl->assign( 'msg_text',	'Das Match konnte nicht gefunden werden !' );
}


?>