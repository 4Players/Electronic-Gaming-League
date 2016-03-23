<?php
# ================================ Copyright � 2005-2006 iNetopia, All rights reserved. ==========================
# 
#
# Purpose:
# ================================================================================================================



# -[ defines ]-


	
# -[ objectlist ] -


class newsday_t
{
	var $news 			= array();
	var $day			= -1;
	var $month			= -1;
	var $year			= -1;
	var $weekday 		= -1;
	var $btoday			= false;
	var $byesterday		= false;
};






# -[ class ] -
class News
{
	# -[ variables ]-
	var $pDBInterfaceCon		= NULL;
	
	# -[ functions ]-
	
	
	# =========================================================================
	# PUBLIC
	# =========================================================================
	
	//-------------------------------------------------------------------------------
	// Purpose: constructor
	// Output : -
	//-------------------------------------------------------------------------------
	function News ( &$pDBCon )
	{
		$this->pDBInterfaceCon=&$pDBCon;
	}
	
	
	//-------------------------------------------------------------------------------
	// Purpose: constructor
	// Output : -
	//-------------------------------------------------------------------------------
	function GetNews( $lim_start=0,$lim_end=10 )
	{
		$sLimit = NULL;
		if( $lim_end ) $sLimit =" LIMIT $lim_start,$lim_end ";
		$sql_query = 	" SELECT cats.name AS cat_name, members.id AS member_id, members.nick_name AS member_nick_name, news.*, COUNT(comments.news_id) AS num_comments ".
						" FROM ".$GLOBALS['g_egltb_news']." AS news ".
						" LEFT JOIN ".$GLOBALS['g_egltb_categories']." AS cats ".
						" ON cats.id = news.cat_id ".
						" LEFT JOIN ".$GLOBALS['g_egltb_news_comments']." AS comments ".
						" ON news.id=comments.news_id".
						" LEFT JOIN ".$GLOBALS['g_egltb_members']." AS members ".
						" ON members.id=news.member_id ".
						" GROUP BY news.id ".
						" ORDER BY news.released DESC ".
						" $sLimit ";
		return $this->pDBInterfaceCon->FetchArrayObject( $this->pDBInterfaceCon->Query( $sql_query));
	}
		
	
	//-------------------------------------------------------------------------------
	// Purpose: constructor
	// Output : -
	//-------------------------------------------------------------------------------
	function GetOverviewNews( $lim_start=0,$lim_end=10 )
	{
		$sLimit = NULL;
		if( $lim_end ) $sLimit =" LIMIT $lim_start,$lim_end ";
		$sql_query = 	" SELECT cats.name AS cat_name, members.id AS member_id, members.nick_name AS member_nick_name, news.*, COUNT(comments.news_id) AS num_comments,".
						" games.id AS game_id, games.name AS game_name, games.logo_small_file AS game_logo_small_file ".
						" FROM ".$GLOBALS['g_egltb_news']." AS news ".
						" LEFT JOIN ".$GLOBALS['g_egltb_categories']." AS cats ".
						" ON cats.id = news.cat_id ".
						" LEFT JOIN ".$GLOBALS['g_egltb_game_pool']." AS games ".
						" ON games.cat_id = cats.id ".
						" LEFT JOIN ".$GLOBALS['g_egltb_news_comments']." AS comments ".
						" ON news.id=comments.news_id".
						" LEFT JOIN ".$GLOBALS['g_egltb_members']." AS members ".
						" ON members.id=news.member_id ".
						" WHERE ".EGL_TIME." > news.released ".
						" GROUP BY news.id ".
						" ORDER BY news.released DESC ".
						" $sLimit ";
		/*
		$sql_query = 	" SELECT * ".
						" FROM ".$GLOBALS['g_egltb_news']." AS news ".
						" LEFT JOIN ".$GLOBALS['g_egltb_categories']." AS cats ".
						" ON cats.id = news.cat_id ".
						" LEFT JOIN ".$GLOBALS['g_egltb_game_pool']." AS games ".
						" ON games.cat_id = cats.id ".
						" ORDER BY news.released DESC ".
						" $sLimit ";*/
		return $this->pDBInterfaceCon->FetchArrayObject( $this->pDBInterfaceCon->Query( $sql_query));
	}
	
	
	/*
	//-------------------------------------------------------------------------------
	// Purpose: constructor
	// Output : -
	//-------------------------------------------------------------------------------
	function GetGameNews( $game_id, $limit=10 )
	{
		$sql_query = 	" SELECT members.id AS member_id, members.nick_name AS member_nick_name, news.*, COUNT(comments.news_id) AS num_comments ".
						" FROM ".$GLOBALS['g_egltb_news']." AS news ".
						" LEFT JOIN ".$GLOBALS['g_egltb_news_comments']." AS comments ".
						" ON news.id=comments.news_id".
						" LEFT JOIN ".$GLOBALS['g_egltb_members']." AS members ".
						" ON members.id=news.member_id ".
						" WHERE news.game_id={$game_id} ".
						" GROUP BY news.id ".
						" ORDER BY news.created DESC ".
						" LIMIT 0,{$limit} ";
		return $this->pDBInterfaceCon->FetchArrayObject( $this->pDBInterfaceCon->Query( $sql_query));
	}*/
	
	
	
	//-------------------------------------------------------------------------------
	// Purpose: constructor
	// Output : -
	//-------------------------------------------------------------------------------
	function GetCategoryNews( $cat_id, $limit=10, $enable_release=true )
	{
		$where_release = "";
		if( $enable_release ) $where_release = " && ".EGL_TIME." > news.released  ";
		$sql_query = 	" SELECT members.id AS member_id, members.nick_name AS member_nick_name, news.*, COUNT(comments.news_id) AS num_comments ".
						" FROM ".$GLOBALS['g_egltb_news']." AS news ".
						" LEFT JOIN ".$GLOBALS['g_egltb_news_comments']." AS comments ".
						" ON news.id=comments.news_id".
						" LEFT JOIN ".$GLOBALS['g_egltb_members']." AS members ".
						" ON members.id=news.member_id ".
						" WHERE news.cat_id={$cat_id} {$where_release} ".
						" GROUP BY news.id ".
						" ORDER BY news.released DESC ".
						" LIMIT 0,{$limit} ";
		return $this->pDBInterfaceCon->FetchArrayObject( $this->pDBInterfaceCon->Query( $sql_query));
	}
	
	
	
	//-------------------------------------------------------------------------------
	// Purpose:
	// Output : 
	//-------------------------------------------------------------------------------
	function GetCategoryAdministrator( $cat_id )
	{
		$sql_query =" SELECT permissions.id, permissions.permissions, permissions.cat_id, permissions.admin_id, permissions.data, permissions.created,
					  		 members.id AS member_id, members.nick_name, members.email ".
					" FROM {$GLOBALS['g_egltb_admin_permissions']} AS permissions ".
					" LEFT JOIN {$GLOBALS['g_egltb_admins']} AS admins ".
					" ON admins.id=permissions.admin_id ".
					" LEFT JOIN {$GLOBALS['g_egltb_members']} AS members ".
					" ON admins.member_id=members.id".
					" WHERE permissions.data='{$cat_id}' && permissions.module_id='".MODULEID_INETOPIA_NEWS."' ";
		return $this->pDBInterfaceCon->FetchArrayObject( $this->pDBInterfaceCon->Query( $sql_query ) );		
		
	}
	
	
	
	//-------------------------------------------------------------------------------
	// Purpose:
	// Output : 
	//-------------------------------------------------------------------------------
	function GetSingleNews( $news_id )
	{
		$sql_query 	= 	" SELECT members.id AS member_id, members.nick_name AS member_nick_name, news.* ".
						" FROM ".$GLOBALS['g_egltb_news']." AS news ".
						" LEFT JOIN ".$GLOBALS['g_egltb_members']." AS members ".
						" ON news.member_id=members.id".
						" WHERE news.id=$news_id ";
		return $this->pDBInterfaceCon->FetchObject( $this->pDBInterfaceCon->Query( $sql_query));
	}
	
	
	
	//-------------------------------------------------------------------------------
	// Purpose: constructor
	// Output : -
	//-------------------------------------------------------------------------------
	function GetNewsComments( $news_id )
	{
		$sql_query 	= " SELECT * FROM ".$GLOBALS['g_egltb_news_comments']." WHERE news_id=$news_id";
		return $this->pDBInterfaceCon->FetchArrayObject( $this->pDBInterfaceCon->Query( $sql_query));
	}
	
	
	//-------------------------------------------------------------------------------
	// Purpose: constructor
	// Output : -
	//-------------------------------------------------------------------------------
	function SetNewData( $obj, $id )
	{
		# execute query
		return $this->pDBInterfaceCon->Query( $this->pDBInterfaceCon->CreateUpdateQuery(  $GLOBALS['g_egltb_news'], $obj ) . " WHERE id=".(int)$id );
	}
	
	
	
	//-------------------------------------------------------------------------------
	// Purpose: constructor
	// Output : -
	//-------------------------------------------------------------------------------
	function CreateNews( $obj )
	{
		return $this->pDBInterfaceCon->Query( $this->pDBInterfaceCon->CreateInsertQuery( $GLOBALS['g_egltb_news'], $obj) );
	}
	
	
	
	//-------------------------------------------------------------------------------
	// Purpose: constructor
	// Output : -
	//-------------------------------------------------------------------------------
	function DeleteNews( $news_id )
	{
		if( $this->pDBInterfaceCon->Query( "DELETE FROM ".$GLOBALS['g_egltb_news']." WHERE id=$news_id" ) )
			if( $this->pDBInterfaceCon->Query( "DELETE FROM ".$GLOBALS['g_egltb_news_comments']." WHERE news_id=$news_id" ) )
				return 1;
		return 0;
	}
	
	
	//-------------------------------------------------------------------------------
	// Purpose: constructor
	// Output : -
	//-------------------------------------------------------------------------------
	function SortDaily( $aTempNews )
	{
		$aNews = array();
		
		
		$year 		= strftime( "%Y", EGL_TIME );
		$month 		= strftime( "%m", EGL_TIME );
		$day 		= strftime( "%d", EGL_TIME );	
	
			
		for( $i=0; $i < sizeof($aTempNews); $i++ )
		{
			$time = $aTempNews[$i]->created;
			
			$_year 		= strftime( "%Y", $time );
			$_month 	= strftime( "%m", $time );
			$_day 		= strftime( "%d", $time );	
		
	
			# get news from current day
			for( $n=0; $n < sizeof($aNews); $n++ )
			{
				if( $aNews[$n]->day 	== $_day &&
					$aNews[$n]->month 	== $_month &&
					$aNews[$n]->year 	== $_year )
					{
						$pNews->news[sizeof($pNews->news)] = $aTempNews[$i];
						break;
					}//if
			}//for
			
			
			# no item found ?
			if( $n == sizeof($aNews) )
			{
				#echo "add";
				$pNews = &$aNews[sizeof($aNews)];
				$pNews = new newsday_t;
				$pNews->day 	= $_day;
				$pNews->month 	= $_month;
				$pNews->year 	= $_year;
				
				if( $_day == $day && $_month == $month && $_year == $year )
				{	
					$pNews->btoday = true;
				}//if
				else if( $_day == $day-1 && $_month == $month && $_year == $year)
				{
					$pNews->byesterday = true;
				}
				
				$pNews->weekday	= GetWeekday( $pNews->day, $pNews->month, $pNews->year );
				
				$pNews->news[sizeof($pNews->news)] = $aTempNews[$i];
			}//if
			
			#$strftime( "%Y", time() )
		}//if
			
		return $aNews;
	}// function SortDaily
};

?>