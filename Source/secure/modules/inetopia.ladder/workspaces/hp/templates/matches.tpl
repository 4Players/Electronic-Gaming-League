{if $ladder->participant_type == $smarty.const.PARTTYPE_TEAM}
	<h2>{lng_parser content=$LNG_MODULE.c9600 name=$participant->name|strip_tags|stripslashes }</h2>
{elseif $ladder->participant_type == $smarty.const.PARTTYPE_MEMBER}
	<h2>{lng_parser content=$LNG_MODULE.c9600 name=$participant->nick_name|strip_tags|stripslashes }</h2>
{/if}
<A href="{$url_file}page={$CURRENT_MODULE_ID}:overview&ladder_id={$ladder->id}"><b>{$ladder->name|strip_tags|stripslashes}</b></a>
<br/><br/>

<table width="100%" cellpadding="5" cellspacing="1">
 <tr bgcolor="{#clr_content_border#}">
	<td width="200"><b>Termin</b></td>
 	<td colspan="3"><b>Match</b></td>
 </tr>
 {section name=m loop=$matches}
 <tr bgcolor="{#clr_content#}">
 	<td>{date timestamp=$matches[m]->challenge_time}</td>

 	{if $matches[m]->winner_id == $participant_id}
 		<!--# PARTICIPANT WINS #-->
 		<td width="1%" bgcolor="#00A800"><img src="images/spacer.gif" width="2" height="1"/></td>
 		{if $matches[m]->challenger_id == $participant_id} <td width="50" align="right"><font color="#00A800">{$matches[m]->challenger_points|add_match_sign}</font></td> {/if}
 		{if $matches[m]->opponent_id == $participant_id} <td width="50" align="right"><font color="#00A800">{$matches[m]->opponent_points|add_match_sign}</font></td> {/if}
 	{elseif $matches[m]->winner_id == $smarty.const.EGL_NO_ID}
 		<!--# NO ONE WINS #-->
 		<td width="1%" bgcolor="#C0C0C0"><img src="images/spacer.gif" width="2" height="1"/></td>
 		{if $matches[m]->challenger_id == $participant_id} <td width="50" align="right"><font color="#C0C0C0">{$matches[m]->challenger_points|add_match_sign}</font></td> {/if}
 		{if $matches[m]->opponent_id == $participant_id} <td width="50" align="right"><font color="#C0C0C0">{$matches[m]->opponent_points|add_match_sign}</font></td> {/if}
 	{else}
 		<!--# OTHER WINS #-->
 		<td width="1%" bgcolor="#A80000"><img src="images/spacer.gif" width="2" height="1"/></td>
 		{if $matches[m]->challenger_id == $participant_id} <td width="50" align="right"><font color="#A80000">{$matches[m]->challenger_points|add_match_sign}</font></td> {/if}
 		{if $matches[m]->opponent_id == $participant_id} <td width="50" align="right"><font color="#A80000">{$matches[m]->opponent_points|add_match_sign}</font></td> {/if}
 	{/if}
 	<td>
 	
 	<A href="{$url_file}page=match.info&match_id={$matches[m]->id}">{$matches[m]->challenger_participant_name|strip_tags|stripslashes} vs. {$matches[m]->opponent_participant_name|strip_tags|stripslashes}</a>
 	
 	
 	</td>
 </tr>
 {/section}
</table>