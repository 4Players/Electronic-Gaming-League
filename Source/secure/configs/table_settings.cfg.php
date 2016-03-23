<?php


//-------------------------------------
// Tabellen
//-------------------------------------

$g_egltb_admins					= "egl_admins";	
$g_egltb_admin_permissions		= "egl_admin_permissions";	


$g_egltb_members				= "egl_members";
$g_egltb_member_history			= "egl_member_history";


$g_egltb_onlinelist				= "egl_onlinelist";
$g_egltb_banlist				= "egl_banlist";

$g_egltb_categories				= "egl_categories";

$g_egltb_leagues				= "egl_ligen";
$g_egltb_configs				= "egl_configs";
$g_egltb_pm_messages			= "egl_pm_messages";
$g_egltb_photo_pool				= "egl_photo_pool";
$g_egltb_logo_pool				= "egl_logo_pool";
$g_egltb_clan_accounts			= "egl_clan_accounts";
$g_egltb_clan_members			= "egl_clan_members";
$g_egltb_clan_invites			= "egl_clan_invites";
$g_egltb_teams					= "egl_teams";
$g_egltb_team_joins				= "egl_team_joins";
$g_egltb_game_pool				= "egl_game_pool";
$g_egltb_countries				= "egl_countries";


$g_egltb_member_comments		= "egl_member_comments";
$g_egltb_clan_comments			= "egl_clan_comments";
$g_egltb_team_comments			= "egl_team_comments";


$g_egltb_matches				= "egl_matches";
$g_egltb_match_comments			= "egl_match_comments";
$g_egltb_match_structures		= "egl_match_structures";
$g_egltb_match_reports			= "egl_match_reports";
$g_egltb_protests				= "egl_protests";
$g_egltb_protest_comments		= "egl_protest_comments";


$g_egltb_media_files			= "egl_media_files";

$g_egltb_cups					= "egl_cups";
$g_egltb_cup_encounts			= "egl_cup_encounts";
$g_egltb_cup_participants		= "egl_cup_participants";

	
$g_egltb_gameaccounts			= "egl_gameaccounts";
$g_egltb_gameaccount_types		= "egl_gameaccount_types";
$g_egltb_gameaccount_reports	= "egl_gameaccount_reports";
	

$g_egltb_news					= "egl_news";
$g_egltb_news_comments			= "egl_news_comments";



DBTB::RegisterTB( 'GLOBAL', 'EGL_ADMINS', 				'egl_admins' );
DBTB::RegisterTB( 'GLOBAL', 'EGL_ADMIN_PERMISSIONS', 	'egl_admin_permissions' );

DBTB::RegisterTB( 'GLOBAL', 'EGL_MEMBERS', 				'egl_members' );
DBTB::RegisterTB( 'GLOBAL', 'EGL_MEMBER_HISTORY', 		'egl_member_history' );

DBTB::RegisterTB( 'GLOBAL', 'EGL_ONLINELIST', 			'egl_onlinelist' );
DBTB::RegisterTB( 'GLOBAL', 'EGL_CATEGORIES', 			'egl_categories' );
DBTB::RegisterTB( 'GLOBAL', 'EGL_PM', 					'egl_pm_messahes' );

DBTB::RegisterTB( 'GLOBAL', 'EGL_CLANS', 				'egl_clan_accounts' );
DBTB::RegisterTB( 'GLOBAL', 'EGL_CLAN_MEMBERS', 		'egl_clan_members' );
DBTB::RegisterTB( 'GLOBAL', 'EGL_CLAN_INVITES', 		'egl_clan_invites' );

DBTB::RegisterTB( 'GLOBAL', 'EGL_TEAMS', 				'egl_teams' );
DBTB::RegisterTB( 'GLOBAL', 'EGL_TEAM_JOINS', 			'egl_team_joins' );


DBTB::RegisterTB( 'GLOBAL', 'EGL_GAMES', 				'egl_game_pool' );


DBTB::RegisterTB( 'GLOBAL', 'EGL_CLAN_COMMENTS',		'egl_clan_comments' );
DBTB::RegisterTB( 'GLOBAL', 'EGL_TEAM_COMMENTS',		'egl_team_comments' );
DBTB::RegisterTB( 'GLOBAL', 'EGL_MEMBER_COMMENTS',		'egl_member_comments' );
DBTB::RegisterTB( 'GLOBAL', 'EGL_MATCH_COMMENTS',		'egl_match_comments' );


DBTB::RegisterTB( 'GLOBAL', 'EGL_MATCHES',				'egl_matches' );
DBTB::RegisterTB( 'GLOBAL', 'EGL_MATCH_STRUCTURES',		'egl_match_structures' );
DBTB::RegisterTB( 'GLOBAL', 'EGL_MATCH_REPORTS',		'egl_match_reports' );


DBTB::RegisterTB( 'GLOBAL', 'EGL_MEDIA_FILES',			'egl_media_files' );


DBTB::RegisterTB( 'GLOBAL', 'EGL_GAMEACCOUNTS',			'egl_gameaccounts' );
DBTB::RegisterTB( 'GLOBAL', 'EGL_GAMEACCOUNT_TYPES',	'egl_gameaccount_types' );
DBTB::RegisterTB( 'GLOBAL', 'EGL_GAMEACCOUNT_REPORTS',	'egl_gameaccount_reports' );


DBTB::RegisterTB( 'GLOBAL', 'EGL_CONFIGS',				'egl_configs' );

DBTB::RegisterTB( 'GLOBAL', 'EGL_PROTESTS',				'egl_protests' );
DBTB::RegisterTB( 'GLOBAL', 'EGL_PROTEST_COMMENTS',		'egl_protest_comments' );


DBTB::RegisterTB( 'GLOBAL', 'EGL_MAPCOLLECTIONS',		'egl_map_collections' );
DBTB::RegisterTB( 'GLOBAL', 'EGL_MAPS',					'egl_maps' );



?>