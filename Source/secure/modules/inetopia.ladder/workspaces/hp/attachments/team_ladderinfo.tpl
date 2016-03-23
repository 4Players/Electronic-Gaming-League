{if sizeof($attached_teamladders)}
{literal}
<style type="text/css"">
A.league_entry:link.league_entry, A:visited.league_entry, A.league_entry:active
{ COLOR: #000;  text-decoration: none;font-size: 11px; FONT-FAMILY: arial,helvetica,sans-serif; FONT-WEIGHT:bold;}
A.league_entry:hover 
{ COLOR: #000;  text-decoration: underline;font-size: 11px;FONT-FAMILY: arial,helvetica,sans-serif; FONT-WEIGHT:bold;}
</style>
{/literal}
<br/>
<table border="0" width="100%" cellpadding="0" cellspacing="0">

 <tr><td><h2>{$LNG_MODULE.c1004}</h2></td></tr>
 <tr><td>{include file="devs/hr_black.tpl" width="100%"}</td></tr>
</table>

<table border="0" cellpadding="0" cellspacing="0" width="100%">

  {section name=ladder loop=$attached_teamladders}
 	<tr>
 		<td valign="center">
 			<A class="league_entry" href="{$url_file}page=gameview.summary&game_id={$attached_teamladders[ladder]->game_id}">{if strlen($attached_teamladders[ladder]->game_token) > 0}{$attached_teamladders[ladder]->game_token|strip_tags|stripslashes}{else}{$attached_teamladders[ladder]->game_name|strip_tags|stripslashes}{/if}</a> : <A class="league_entry" href="{$url_file}page={$ATTACHED_MODULE_ID}:overview&ladder_id={$attached_teamladders[ladder]->id}">{$attached_teamladders[ladder]->name|strip_tags|stripslashes}</a>
			( {$attached_teamladders[ladder]->points|tointeger}  {$LNG_MODULE.c1002})
 			<br/>
 			
		{if sizeof($attached_teamladder_matches[ladder]) > 0}
			<table width="100%" cellpadding="5" cellspacing="1">
			<tr bgcolor="{#clr_content_border#}"><td colspan="3"><b>Letzte Matches:</b></td></tr>
			{section name=match loop=$attached_teamladder_matches[ladder]}
			<tr bgcolor="{#clr_content#}">
				<td width="50" align="center">
				{if $attached_teamladder_matches[ladder][match]->status == $smarty.const.MATCH_RUNNING}
					<font color="#0000A8"><b>{$LNG_MODULE.c1013}</b></font>
				{else}
					{if $attached_teamladders[ladder]->team_id == $attached_teamladder_matches[ladder][match]->winner_id}
						<font color="#00A800"><b>{$LNG_MODULE.c1010}</b></font>
					{elseif $attached_teamladder_matches[ladder][match]->winner_id != $smarty.const.EGL_NO_ID}
						<font color="#A80000"><b>{$LNG_MODULE.c1011}</b></font>
					{else}
						<font color="#C0C0C0"><b>{$LNG_MODULE.c1012}</b></font>
					{/if}
				{/if}
				</td>
				<td>
				<a href="{$url_file}page=match.info&match_id={$attached_teamladder_matches[ladder][match]->id}">{$attached_teamladder_matches[ladder][match]->challenger_name|strip_tags|stripslashes} vs.{$attached_teamladder_matches[ladder][match]->opponent_name|strip_tags|stripslashes}</a>
	
				<!--## SHOW GIVEN POINTS ##-->
				{if $attached_teamladder_matches[ladder][match]->status == $smarty.const.MATCH_CLOSED}
					{if $attached_teamladders[ladder]->team_id == $attached_teamladder_matches[ladder][match]->challenger_id}
						( {marknumber number=$attached_teamladder_matches[ladder][match]->challenger_points color1="#00A800" color2="#A80000" color3="#A8A8A8"}	)
					{/if}
					{if $attached_teamladders[ladder]->team_id == $attached_teamladder_matches[ladder][match]->opponent_id}
						( {marknumber number=$attached_teamladder_matches[ladder][match]->opponent_points color1="#00A800" color2="#A80000" color3="#A8A8A8"}	)
					{/if}
				{/if}
				
				</td>
				<td width="150">{date timestamp=$attached_teamladder_matches[ladder][match]->challenge_time}</td>
			</tr>
			{/section}
			</table>
		{else}
			<table width="100%" cellpadding="5" cellspacing="1">
			<tr bgcolor="{#clr_content#}"><td>{$LNG_MODULE.c1003}</td></tr>
			</table>
		{/if}

		
 		</td>
 		<td width="100" valign="bottom">
 			<table width="100%" cellpadding="2" cellspacing="0">
 			 <tr>
 			 	<td>{include file="buttons/bt_universal.tpl" caption=$LNG_MODULE.c1001 link="javascript:document.location.href='`$url_file`page=team.teamselect&page_forward=`$ATTACHED_MODULE_ID`:team.challenge&params=ladderpart_id=`$attached_teamladders[ladder]->part_id`';" color=$GLOBAL_COLOR}
 			 </tr>
 			</table>
 		</td>
 	</tr>
 	<tr><td colspan="2"><img src="images/spacer.gif" width="1" height="10"/></td></tr>
 {/section}
 </table>
{/if}