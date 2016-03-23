{include file="devs/message.tpl"}

{**********************}
{*TEAM FOUND ? *}
{**********************}
{if $team}

	{if $team->clan_id }
		<h2><A href="{$url_file}page=clan.info&clan_id={$team->clan_id}"> {$team->clan_name|strip_tags|stripslashes} </a> {#arrow_db_right#} <i>{$team->name}</i></h2>
	{else}
		<h2> {$team->name|strip_tags|stripslashes} </h2>
	
	{/if}
	{include file="devs/hr_black.tpl" width="100%"}
	
	<table border="0" width="100%" >
	 <tr>
	 	<td width="1%" valign="top">
	
		 		<table border=0 bgcolor="{#clr_content#}" cellpadding="0" cellspacing="1">
		 		 <tr><td>
	 			{if $team->logo_file != 'non'}
	 				<img border="1" style="border-color:#000000;" src="{$path_logos}teams/{$team->logo_file}" width="100" height="100"> 
	 			{else}
	 				<img border="1" style="border-color:#000000;" src="images/logo.na.jpg" width="100" height="100">
	 			{/if}
		 		</td></tr>
		 		</table>
	 			
		 		 	
	 	</td>
	 	<td valign="top">
		
	 		{* Team-ID *}
	 		<table border="0" width="100%">
	 		 <tr>
	 		 	<td><font size="1"><i>{$LNG_BASIC.c4250}, {$LNG_BASIC.c4251}</i></font></td>
	 		 </tr>
	 		 <tr>
	 		 	<td background="images/eglbeta/desc_bg.gif" style="background-repeat: repeat-x; background-position:bottom;"> <b>{$team->id}</b></td>
	 		 </tr>
	 		</table>	
	
	 	
	 		{* Name *}
	 		<table border="0" width="100%">
	 		 <tr>
	 		 	<td><font size="1"><i>{$LNG_BASIC.c4831}</i></font></td>
	 		 </tr>
	 		 <tr>
	 		 	<td background="images/eglbeta/desc_bg.gif" style="background-repeat: repeat-x; background-position:bottom;"> <b> {$team->name|strip_tags|stripslashes}</b></td>
	 		 </tr>
	 		</table>	
	 	
	 		{* Tag *}
	 		<table border="0" width="100%">
	 		 <tr>
	 		 	<td><font size="1"><i>{$LNG_BASIC.c4832}</i></font></td>
	 		 </tr>
	 		 <tr>
	 		 	<td background="images/eglbeta/desc_bg.gif" style="background-repeat: repeat-x; background-position:bottom;"> <b> {$team->tag|strip_tags|stripslashes}</b></td>
	 		 </tr>
	 		</table>	
	
	 		
	 		{* created *}
	 		<table border="0" width="100%">
	 		 <tr>
	 		 	<td><font size="1"><i>{$LNG_BASIC.c4262}</i></font></td>
	 		 </tr>
	 		 <tr>
	 		 	<td background="images/eglbeta/desc_bg.gif" style="background-repeat: repeat-x; background-position:bottom;"> <b>{date timestamp=$team->created format="%d.%m.%Y"}	</b></td>
	 		 </tr>
	 		</table>		
	 		 		
	
			 		 		
	 	</td>
	 	<td width="40%" valign="top">
		 				
	 		{*** Nationality/Country ***}
	 		<table border="0" width="100%">
	 		 <tr>
	 		 	<td><font size="1"><i>{$LNG_BASIC.c4784}</i></font></td>
	 		 </tr>
	 		 <tr>
	 		 	<td background="images/eglbeta/desc_bg.gif" style="background-repeat: repeat-x; background-position:bottom;"> 
		 		{if $team->country_id}
	 			 	{section name=country loop=$countries}
			 		{if $team->country_id == $countries[country]->id}
			 			<b>{$countries[country]->name}</b> <img src="{$path_country}{$countries[country]->image_file}">
			 		{/if}
			 		{/section} 			 	
			 	{else}
			 		<b>{$LNG_BASIC.c1021}</b>
			 	{/if}		
	 		 	</td>
	 		 </tr>
	 		</table>	 	
			 		
	 		
	 		 	
	 	{if $team->clan_id }
	 		{* created *}
	 		<table border="0" width="100%">
	 		 <tr>
	 		 	<td><font size="1"><i>{$LNG_BASIC.c5200}</i></font></td>
	 		 </tr>
	 		 <tr>
	 		 	<td background="images/eglbeta/desc_bg.gif" style="background-repeat: repeat-x; background-position:bottom;"> <A href="{$url_file}page=clan.info&clan_id={$team->clan_id}"><b>{$team->clan_name|strip_tags|stripslashes}</b></a></td>
	 		 </tr>
	 		</table> 	
	 		
	 		{* created *}
	 		<table border="0" width="100%">
	 		 <tr>
	 		 	<td><font size="1"><i>{$LNG_BASIC.c5201}</i></font></td>
	 		 </tr>
	 		 <tr>
	 		 	<td background="images/eglbeta/desc_bg.gif" style="background-repeat: repeat-x; background-position:bottom;"><b>{hp url=$team->clan_hp|strip_tags}</b></td>
	 		 </tr>
	 		</table> 	
	 	{/if}
	 	
	 		
	 	</td>
	 </tr>
	</table>
		
		<br/>
		
		{if sizeof($team_games) > 0}
			<table border="0" width="100%" cellpadding="0" cellspacing="0">
			 <tr><td><h2>{$LNG_BASIC.c5202}</h2></td></tr>
			 <tr><td>{include file="devs/hr_black.tpl" width="100%"}</td></tr>
			</table>	
			<table border="0" cellpadding="2" cellspacing="0" width="100%">
	 		 <tr><td>
	
				{section name=game loop=$team_games}
					{if $team_games[game]->logo_small_file != 'non'}
						<A title="{$team_games[game]->name}" href="{$url_file}page=game.info&game_id={$team_games[game]->id}"><img border="1" style="border-color:#000000;" alt="{$team_games[game]->name}" src="{$path_games}small/{$team_games[game]->logo_small_file}" width="60" height="80"></a>
					{else}
						<A title="{$team_games[game]->name}" href="{$url_file}page=game.info&game_id={$team_games[game]->id}"><img border="1" style="border-color:#000000;" alt="{$team_games[game]->name}" src="images/logo.na.jpg" width="60" height="80"></a>
					{/if}
				{/section}
						
	 		  </td></tr>
	 		 </table>
 		 {/if}

	
 		{if strlen($team->server) > 0}
		<br/><br/>
		<table border="0" width="100%" cellpadding="0" cellspacing="0">
		 <tr><td><h2>{$LNG_BASIC.c5203}</h2></td></tr>
		 <tr><td>{include file="devs/hr_black.tpl" width="100%"}</td></tr>
		</table>	
		<table border="0" cellpadding="3" cellspacing="0" width="100%">
 		 <tr><td bgcolor="{#clr_content#}">{$team->server|strip_tags|stripslashes|nl2br}</td></tr>
 		 </table>
 		{/if}

		<br/>
			
		{* STRUCTURE-DESCRIPTION:
		-----------------
		$clan_members has been sorted to $clan_members[0...cpl][0..clan_member] (cpl=clan permission-list)
		*}
		<table border="0" width="100%" cellpadding="0" cellspacing="0">
		 <tr><td><h2>{$LNG_BASIC.c5205}</h2></td></tr>
		 <tr><td>{include file="devs/hr_black.tpl" width="100%"}</td></tr>
		</table>	
		
		<table border="0" width="100%" cellpadding="5" cellspacing="1" >
		{section name=cp loop=$team_members}
		{if sizeof($team_members[cp]) > 0}
			{assign var="curr_member_list" value=$team_members[cp] }
 			 <tr>
 				<td bgcolor="{#clr_content#}" width="20%" valign="top">{$tpl[cp]->name}({$team_members[cp]|@count})</td>	
 				<td bgcolor="{#clr_content#}" > {include file="etc/team.list_detailed_permissions.tpl"}	</td>	
 			 </tr>
 		{/if}
 		{/section}
 		<tr>
 			<td colspan="2" align="right"><a href="{$url_file}page=team.memberlist&team_id={$team->id}">Mitglieder Übersicht</a></td>
 		</tr>
		</table>
 			
 		
		{if strlen($team->description) > 0}
	 		<br/><br/>
	 		
			<table border="0" width="100%" cellpadding="0" cellspacing="0">
			 <tr><td><h2>{$LNG_BASIC.c5204}</h2></td></tr>
			 <tr><td>{include file="devs/hr_black.tpl" width="100%"}</td></tr>
			</table>	
			<table border="0" width="100%" cellpadding="5" cellspacing="0">
			 <tr>
				<td bgcolor="{#clr_content#}"> {$team->description|strip_tags|stripslashes|bbcode2html|nl2br} </td>	
			 </tr>
			</table> 	
		{/if}
	
		
	 	<br/><br/>
	 	
		<table border="0" width="100%" bgcolor="{#clr_content#}" cellpadding="3" cellspacing="0">
		 <tr>
		 	<td align="right"> <A href="{$url_file}page={$url_page}&team_id={$team->id}&comment=write#comment_show"><b>{$LNG_BASIC.c4203} {#clip_start#}{$comment_count}{#clip_end#}</b> </a> </td> 
		 </tr>
		</table>
		
		{include file="etc/comment.show.tpl"}
		<br/>
		{* WRITE ? !! *}
		{include file="etc/comment.write.tpl"}
	 		
 	
 {/if}