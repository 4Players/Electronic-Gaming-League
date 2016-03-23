<?php
global $gl_oVars;

# get data
$iMatchId = (int)$_GET['match_id'];


# classes
$cReports 	= new MatchReports( $gl_oVars->cDBInterface );
$cMedia 	= new Media( $gl_oVars->cDBInterface );
$cMatch 	= new Match( $gl_oVars->cDBInterface, $iMatchId );
$cTeam		= new Team( $gl_oVars->cDBInterface );


#~1
$oMatch = $cMatch->GetData();
	

if( $oMatch )
{
	
	/*
	
	$aParticipants = array();
	$str_id_list = $oMatch->challenger_id.','.$oMatch->opponent_id;
	
	#~2
	#================================================================
	if( $oMatch->participant_type == PARTTYPE_MEMBER )
	{
		$aParticipants = $gl_oVars->cMember->__GetMemberListData( $str_id_list );
		$gl_oVars->cTpl->assign( 'type', 'member' );
	}
	#================================================================
	else if( $oMatch->participant_type == PARTTYPE_TEAM )
	{
		
		$aParticipants = $gl_oVars->cMember->GetClanlistData( $str_id_list );
		$gl_oVars->cTpl->assign( 'type', 'team' );
	}	
	
	# sort participants
	#		ARRAY: 1 => challenger
	#		ARRAY: 2 => opponent 
	#
	
	if( $aParticipants[0]->participant_id != $oMatch->challenger_id )
	{
		$temp = $aParticipants[0];
		$aParticipants[0] = $aParticipants[1];
		$aParticipants[1] = $temp;
	}
	
	*/
	
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
	
	# fetch / read match results
	$oMatchResult = Match::FetchMatchResults( $oMatch );
	
	
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
		$msg_obj = array( 	"match_id"	=> $oMatch->id,
							"author_id" => $gl_oVars->oMemberData->id,
							"text"		=> $_POST['comment_text'],
							"created"	=> EGL_TIME
							);
		
		# try to create obj
		if( $cComments->CreateComment($msg_obj) )
		{
			# successful
			PageNavigation::Location( $gl_oVars->sURLFile."?page=".$gl_oVars->sURLPage."&match_id=".$oMatch->id."&comment=write" );
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
}
else
{
	$gl_oVars->cTpl->assign( 'msg_type',	'error' );
	$gl_oVars->cTpl->assign( 'msg_text',	'Das Match existiert nicht!' );

}


?>