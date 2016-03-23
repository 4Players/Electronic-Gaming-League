<h2>Ladder `{$ladder->name|strip_tags|stripslashes}` Teilnehmer</h2>
{include file="`$page_dir`/admin/laddermenu.tpl"}
<hr size="1"/>
{include file="etc/message.tpl"}

{if $success}
{else}


<script language="javascript" src="javascript/browser_handling"></script>
<form name="f" action="javascript:document.location='{$url_file}page=cms.match.admin&match_id='+f.match_id.value;" method="post">
<table width="100%" background="images/modules/inetopia_ladder/ladder_participants.gif" style="background-repeat:no-repeat;" cellpadding="20">
 <tr><td>
 	<br/>
 	 <table cellpadding="0" cellspacing="2" width="100%" bgcolor="#C0C0C0">
 	  <tr><td bgcolor="#FFFFFF">
			<table border="0" cellpadding="10" cellspacing="1" width="100%">
			 <tr bgcolor="{#clr_content_border#}">
				<td colspan="8"> <b>Teilnehmer</b>, Insgesamt {$num_ladder_participants} Teilnehmer, davon werden gerade {$ladder_participants|@count} angezeigt 
				
				<div align="right">
				<select style="width:120;" class="egl_select" onchange="javascript:document.location='{$url_file}page={$url_page}&game_id={$game->id}&ladder_id={$ladder->id}&pos='+this.options[this.selectedIndex].value;">
				{section name=p loop=$num_pages}
					{assign var="_start" value=$smarty.section.p.index*$participants_per_page+1}
					{assign var="_tmp" value=$smarty.section.p.index+1}
					{assign var="_end" value=$_tmp*$participants_per_page}
					<option {if $_get.pos == $_start-1}selected{/if} value="{$_start-1}">{$_start}-{$_end}</option>
				{/section}
				</select>
				</div>
				</td>
			 </tr>
			 <tr bgcolor="{#clr_content#}">
			 	<td width="1%"></td>
			 	<td width="1%"><b>Rank</b></td>
			 	{if $ladder->participant_type == $smarty.const.PARTTYPE_MEMBER}<td><b>M-ID</b></td>{/if}
			 	{if $ladder->participant_type == $smarty.const.PARTTYPE_TEAM}<td><b>T-ID</b></td>{/if}
			 	<td><b>Name</b></td>
				<td width="100"><b>Punkte</b> (Letzte Punkt)</td>
				<td width="100"><b>Matches/W/D/L</b></td>
				<td width="100"><b>Eingetragen seit</b></td>
				<td width="1%"></td>
			</tr>
			{section name=part loop=$ladder_participants}
			<tr bgcolor="{#clr_content#}"
				onmouseover="this.style.backgroundColor='#FFFFFF';"
				onmouseout="this.style.backgroundColor='';">
				<td><img src="images/unlocked.gif"/>
				<td align="center" width="1%">{$_get.pos+$smarty.section.part.index+1}</td>
				<td align="center" width="1%">{$ladder_participants[part]->participant_id}</td>
				{if $ladder->participant_type == $smarty.const.PARTTYPE_MEMBER}
					<td><A href="{$url_file}page=cms.member.central&member_id={$ladder_participants[part]->participant_id}">{$ladder_participants[part]->participant_name|strip_tags|stripslashes}</a></td>
				{elseif $ladder->participant_type == $smarty.const.PARTTYPE_TEAM}
					<td>{if $ladder_participants[part]->participant_clan_id}<A href="{$url_file}page=cms.clan.central&clan_id={$ladder_participants[part]->participant_clan_id}">{$ladder_participants[part]->participant_clan_tag}</a>&nbsp;&raquo;&nbsp;{/if}<A href="{$url_file}page=cms.team.central&team_id={$ladder_participants[part]->participant_id}">{$ladder_participants[part]->participant_name|strip_tags|stripslashes}</a></td>
				{/if}
			 	<td>{$ladder_participants[part]->points} ({$ladder_participants[part]->last_points})</td>
			 	<td>
			 		<font color="#000000"><b>{$ladder_participants[part]->matches_all|tointeger}</b></font> /
			 		<font color="#00A800"><b>{$ladder_participants[part]->matches_won|tointeger}</b></font> /
			 		<font color="#0000A8"><b>{$ladder_participants[part]->matches_draw|tointeger}</b></font> /
			 		<font color="#A80000"><b>{$ladder_participants[part]->matches_lost|tointeger}</b></font>
			 	</td>
			 	<td>{date timestamp=$ladder_participants[part]->created}</td>
			 	<td><A href="javascript:MessageCheckAction('Soll der Teilnehmer wirklich unwiderruflich gelöscht werden?', '{$url_file}page={$url_page}&game_id={$game->id}&ladder_id={$ladder->id}&part_id={$ladder_participants[part]->id}&a=del_part');"><img border="0" title="Teilnehmer löschen" src="images/admin/button_cancel_small.gif"/></a></td>
			</tr>
			{/section}
			</table>
			
	   </td></tr>
	  </table>
		
  </td></tr>
</table>
</form>


<form name="fpartadd" action="{$url_file}page={$url_page}&game_id={$game->id}&ladder_id={$ladder->id}&a=add_part" method="POST">
<table width="100%" background="images/modules/inetopia_ladder/ladder_participant_add.gif" style="background-repeat:no-repeat;" cellpadding="20">
 <tr><td>
 	<br/><br/>
	<table border="0" cellpadding="0" cellspacing="1" bgcolor="{#clr_content_border#}">
	 <tr><td>
	 
		<table border="0" cellpadding="10" cellspacing="1" bgcolor="{#clr_content#}">
		 <tr bgcolor="{#clr_content_header#}">
		 	<td colspan="3"> <b>Teilnehmer hinzufügen:</b></td>
		 </tr>
		 <tr>
		 	{if $ladder->participant_type == $smarty.const.PARTTYPE_MEMBER }
		  	<td><b>Member-ID:</b></td>
		  	{elseif $ladder->participant_type == $smarty.const.PARTTYPE_TEAM }
		  	<td><b>Team-ID:</b></td>
		  	{/if}
		 	<td><input name="add_participant_id" type="text" class="egl_text"></td>
		 	<td>{include file="buttons/bt_universal.tpl" color=$GLOBAL_COLOR caption="abschicken" link="javascript:document.fpartadd.submit();"}</td>
		 </tr>
	 	</table>
	 	
	 </td></tr>
	</table>
	
 </td></tr>
</table>
</form>


{/if}