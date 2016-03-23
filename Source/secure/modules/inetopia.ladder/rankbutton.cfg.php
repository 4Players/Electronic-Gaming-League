<?php
/*
$name_text['member_text']
	-> {MEMBER_NAME}
	-> {MEMBER_ID}
	
$name_text['team_text']
	-> {CLAN_TAG}
	-> {CLAN_NAME}
	-> {CLAN_ID}
	-> {TEAM_TAG}
	-> {TEAM_NAME}
	-> {TEAM_ID}

$ladder_text['ladder_text']
	-> {LADDER_NAME}
	-> {LADDER_ID}
	-> {GAME_TAG}
	-> {GAME_NAME}
	-> {GAME_ID}
	
*/
		$rank_text = array( 	'size'			=> 3,
								'color'			=> 0x000000,
								'x'				=> 305,
								'y'				=> 12,
								'hide'			=> 0,
								'rank_text'		=> '{RANK}.',
								'max_length'	=> 0,
						  );
						  
		// define rank-text
		$name_text = array( 	'size'			=> 1,
								'color'			=> 0xFFFFFF,
								'x'				=> 10,
								'y'				=> 3,
								'hide'			=> 0,
								'member_text'	=> '{MEMBER_NAME}: `{MEMBER_ID}`',
								'team_text'		=> '{CLAN_TAG}>{TEAM_NAME}: `{TEAM_ID}`',
								'max_length'	=> 55,
						  );
		
		// define ladder-text
		$ladder_text = array( 	'size'			=> 3,
								'color'			=> 0xFFFFFF,
								'x'				=> 10,	
								'y'				=> 12,
								'hide'			=> 0,
								'ladder_text'	=> '{GAME_TAG} {LADDER_NAME}',
								'max_length'	=> 40,
							);
							
	$image_source	= array( 'button_image'	=> 'rankbutton.png' );
?>