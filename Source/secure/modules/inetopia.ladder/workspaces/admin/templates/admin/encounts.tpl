<h2>Ladder `{$ladder->name|strip_tags|stripslashes}` Begegnungen</h2>
{include file="`$page_dir`/admin/laddermenu.tpl"}
<hr size="1"/>
{include file="etc/message.tpl"}

{if $success}
{else}
{literal}
<script language="javascript" src="javascript/browser_handling.js"></script>
<script language="javascript">
	function bookmark_page(question){
		if( confirm( question ) ){
			add_current_to_pagestore();
		}//if
	}
</script>
{/literal}
<table width="100%" background="images/modules/inetopia_ladder/ladder_encounts.gif" style="background-repeat:no-repeat;" cellpadding="20">
 <tr><td>
 	<br/>
 	 <table cellpadding="0" cellspacing="2" width="100%" bgcolor="#C0C0C0">
 	  <tr><td bgcolor="#FFFFFF">
 	  
			<table border="0" cellpadding="10" cellspacing="1" width="100%">
			 <tr bgcolor="{#clr_content_border#}">
				<td colspan="7"><b>Begegnungen</b>, Insgesamt {$num_ladder_encounts} Begegnungen, davon werden gerade {$encounts|@count} angezeigt 
				</td>
			 </tr>
			 <tr bgcolor="{#clr_content#}">
				<td width="10"><b>EVAL</b></td>
				<td><b>Challenger</b></td>
				<td width="30"></td>
				<td><b>Opponent</b></td>
				<td width="150"><b>Termin</b></td>
				<td width="50"></td>
				<td width="50"></td>
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
					<td><A href="{$url_file}page=cms.member.central&member_id={$encounts[enc]->challenger_participant_id}">{$encounts[enc]->challenger_participant_name|strip_tags|stripslashes}</a></td>
	 			{/if}
	 			<td align="center" width="30"><b>VS.</b></td>
				{if $ladder->participant_type == $smarty.const.PARTTYPE_TEAM}
					<td> {if $encounts[enc]->opponent_participant_clan_id}<A href="{$url_file}page=cms.clan.central&clan_id={$encounts[enc]->opponent_participant_id}">{$encounts[enc]->opponent_participant_clan_tag}</a>&nbsp;&raquo;&nbsp;{/if}<A href="{$url_file}page=cms.team.central&team_id={$encounts[enc]->opponent_participant_id}">{$encounts[enc]->opponent_participant_name|strip_tags|stripslashes}</a></td>
				{elseif $ladder->participant_type == $smarty.const.PARTTYPE_MEMBER}
					<td><a href="{$url_file}page=cms.member.central&member_id={$encounts[enc]->opponent_participant_id}">{$encounts[enc]->opponent_participant_name|strip_tags|stripslashes}</a></td>
	 			{/if}
					<td>{date timestamp=$encounts[enc]->challenge_time}</td>
					<td><a href="javascript: bookmark_page('{$LNG_BASIC.c1000}'); document.location.href='{$url_file}page=cms.match.admin&match_id={$encounts[enc]->match_id}';"><img title="Zum Match" border="0"src="images/small_match_icon.gif"/></a></td>
					<td><a href="javascript:MessageCheckAction( 'Möchten Sie diese Begegnung unwiderruflich löschen?', '{$url_file}page={$url_page}&ladder_id={$ladder->id}&encount_id={$encounts[enc]->encount_id}&a=del');"><img src="images/admin/button_cancel_small.gif" border="0"/></a></td>
				</tr>
			{/section}
			</table>
			
	   </td></tr>
	  </table>
		
  </td></tr>
</table>

{/if}