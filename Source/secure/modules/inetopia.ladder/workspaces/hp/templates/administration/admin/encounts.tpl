<h2>Ladder `{$ladder->name|strip_tags|stripslashes}` Begegnungen</h2>
{include file="`$page_dir`/laddermenu.tpl"}
<hr size="1"/>
{include file="devs/message.tpl"}

{if $success}
{else}
{literal}
<script language="javascript" src="javascript/browser_handling.js"></script>
{/literal}
<form name="f" action="javascript:document.location='{$url_file}page=cms.match.admin&match_id='+f.match_id.value;" method="post">
<table width="100%" background="images/modules/inetopia_ladder/ladder_encounts.gif" style="background-repeat:no-repeat;" cellpadding="20">
 <tr><td>
 	<br/>
 	 <table cellpadding="0" cellspacing="2" width="100%" bgcolor="#C0C0C0">
 	  <tr><td bgcolor="#FFFFFF">
			<table border="0" cellpadding="10" cellspacing="1" width="100%">
			 <tr bgcolor="{#clr_content_border#}">
				<td colspan="7"><b>Begegnungen</b>, Insgesamt {$num_ladder_encounts} Begegnungen, davon werden gerade {$encounts|@count} angezeigt 
				
					<div align="right">
					<select style="width:120;" class="egl_select" onchange="javascript:document.location='{$url_file}page={$url_page}&game_id={$game->id}&ladder_id={$ladder->id}&pos='+this.options[this.selectedIndex].value;">
					{section name=p loop=$num_pages}
						{assign var="_start" value=$smarty.section.p.index*$encounts_per_page+1}
						{assign var="_tmp" value=$smarty.section.p.index+1}
						{assign var="_end" value=$_tmp*$encounts_per_page}
						<option {if $_get.pos == $_start-1}selected{/if} value="{$_start-1}">{$_start}-{$_end}</option>
					{/section}
					</select>
					</div>				
				</td>
			 </tr>
			 <tr bgcolor="{#clr_content#}">
				<td width="10"><b>EVAL</b></td>
				<td><b>Challenger</b></td>
				<td w1abbr="30"></td>
				<td><b>Opponent</b></td>
				<td width="150"><b>Termin</b></td>
				<td width="1%"></td>
				<td width="1%"></td>
			</tr>
			{section name=enc loop=$encounts}
			<tr bgcolor="{#clr_content#}"
				onmouseover="this.style.backgroundColor='#FFFFFF';"
				onmouseout="this.style.backgroundColor='';"
				>
			{if $encounts[enc]->evaluated}<td width="10"><img src="images/calced.gif" title="ausgewertet"/></td>{/if}
			{if !$encounts[enc]->evaluated}<td width="10"><img src="images/no_calced.gif" title="nicht ausgewertet"/></td>{/if}
			{if $ladder->participant_type == $smarty.const.PARTTYPE_TEAM}
				<td>{if $encounts[enc]->challenger_participant_clan_id}<A href="{$url_file}page=cms.clan.central&clan_id={$encounts[enc]->challenger_participant_id}">{$encounts[enc]->challenger_participant_clan_tag}</a>&nbsp;&raquo;&nbsp;{/if}<A href="{$url_file}page=cms.TEAM.central&team_id={$encounts[enc]->challenger_participant_id}">{$encounts[enc]->challenger_participant_name|strip_tags|stripslashes}</a></td>
			{elseif $ladder->participant_type == $smarty.const.PARTTYPE_MEMBER}
				<td><A href="{$url_file}page=administration.member.central&member_id={$encounts[enc]->challenger_participant_id}">{$encounts[enc]->challenger_participant_name|strip_tags|stripslashes}</a></td>
 			{/if}
 			<td align="center" width="30"><b>VS.</b></td>
			{if $ladder->participant_type == $smarty.const.PARTTYPE_TEAM}
				<td> {if $encounts[enc]->opponent_participant_clan_id}<A href="{$url_file}page=cms.clan.central&clan_id={$encounts[enc]->opponent_participant_id}">{$encounts[enc]->opponent_participant_clan_tag}</a>&nbsp;&raquo;&nbsp;{/if}<A href="{$url_file}page=cms.team.central&team_id={$encounts[enc]->opponent_participant_id}">{$encounts[enc]->opponent_participant_name|strip_tags|stripslashes}</a></td>
			{elseif $ladder->participant_type == $smarty.const.PARTTYPE_MEMBER}
				<td><a href="{$url_file}page=administration.member.central&member_id={$encounts[enc]->opponent_participant_id}">{$encounts[enc]->opponent_participant_name|strip_tags|stripslashes}</a></td>
 			{/if}
				<td>{date timestamp=$encounts[enc]->challenge_time}</td>
				<td><a href="javascript:document.location.href='{$url_file}page=administration.match.admin&match_id={$encounts[enc]->match_id}';"><img title="Zum Match" border="0"src="images/small_match_icon.gif"/></a></td>
				<td><a href="javascript:MessageCheckAction( 'Möchten Sie diese Begegnung unwiderruflich löschen?', '{$url_file}page={$url_page}&ladder_id={$ladder->id}&encount_id={$encounts[enc]->encount_id}&a=del');"><img src="images/admin/button_cancel_small.gif" border="0"/></a>
			</tr>		
			{/section}
			</table>
			
	   </td></tr>
	  </table>
		
  </td></tr>
</table>
</form>

{/if}