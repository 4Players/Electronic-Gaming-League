<h2>Zentrale `{$member_data->nick_name|strip_tags|stripslashes}`</h2>
{include file="cms/member/headermenu.tpl"}
<hr size="1"/>
{include file="etc/message.tpl"}

{if $success}
{else}


<table width="100%" border="0" cellpadding="5" cellspacing="10">
 <tr>
 	<td width="50%" valign="top">
 	
 	
 			<table border="0" cellpadding="5" cellspacing="1" width="100%">
 			 <tr bgcolor="{#clr_content_border#}">
 			 	<td colspan="2"><b>Mitgliedschaften</b></td>
 			 </tr>
 			 <tr bgcolor="{#clr_content#}">
 			 	<td valign="top" align="right"><b>Clans:</b></td>
 			 	<td valign="top">
 			 	{section name=clan loop=$member_clans}
 			 		<a href="{$url_file}page=cms.clan.central&clan_id={$member_clans[clan]->id}">{$member_clans[clan]->name}</a>,
 			 		{section name=p loop=$cpl}
 			 			{if $cpl[p]->const == $member_clans[clan]->permissions}
 			 				{$cpl[p]->name}
 			 			{/if}
 			 		{/section}
 			 		<br/>
 			 	{/section}
 			 	</td>
 			 </tr>
 			 <tr bgcolor="{#clr_content#}">
 			 	<td valign="top" align="right"><b>Teams:</b></td>
 			 	<td valign="top">
 			 	{section name=team loop=$member_teams}
 			 		<a href="{$url_file}page=cms.team.central&team_id={$member_teams[team]->id}">{$member_teams[team]->name|strip_tags|stripslashes}</a>,
 			 		{section name=p loop=$tpl}
 			 			{if $tpl[p]->const == $member_teams[team]->permissions}
 			 				{$tpl[p]->name}
 			 			{/if}
 			 		{/section}
 			 		<br/>
 			 	{/section}
 			 	</td>
 			 </tr>
 			</table>
 			
 		<br/>	 	
 		
 		{if $MEMBER_BANNED}
 			<table border="0" cellpadding="5" cellspacing="1" width="100%">
 			 <tr bgcolor="{#clr_content_border#}">
 			 	<td colspan="2"><b><font color="#A80000">Sperre aktiviert</font></b>
 			 	&nbsp;
 			 	[ <A title="Soll die Sperre jetzt aufgehoben werden?" href="{$url_file}page={$url_page}&member_id={$member_data->id}&a=ban:deactivate"><b>Sperre aufheben</b></a> ]
 			 	</td>
 			 </tr>
 			 <tr bgcolor="{#clr_content#}">
 			 	<td><b>Sperrzeitpunkt:</b></td>
 			 	<td>{date timestamp=$member_data->ban_start} </td>
 			 </tr>
 			 <tr bgcolor="{#clr_content#}">
 			 	<td><b>Ablaufzeitpunkt:</b></td>
 			 	<td>{date timestamp=$member_data->ban_end} </td>
 			 </tr>
 			 <tr bgcolor="{#clr_content#}">
 			 	<td><b>Sperrzeit:</b></td>
 			 	<td>{$ban_time.days} Tage {$ban_time.hours} Stunden {$ban_time.mins} Minuten {$ban_time.seconds} Sekunden</td>
 			 </tr>
 			 <tr bgcolor="#FFF2E0">
 			 	<td><b>Verbleibend:</b></td>
 			 	<td>{$expire_time.days} Tage {$expire_time.hours} Stunden {$expire_time.mins} Minuten {$expire_time.seconds} Sekunden</td>
 			 </tr>
 			</table>

 		
 		{else}

 		
		<form action="{$url_file}page={$url_page}&member_id={$member_data->id}&a=ban:activate" method="POST">
 			<table border="0" cellpadding="5" cellspacing="1" width="100%">
 			 <tr bgcolor="{#clr_content_border#}">
 			 	<td colspan="2"><b>Sperre deaktiviert</b></td>
 			 </tr>
			 <tr bgcolor="#FFF2E0">
			 	<td> <b>Startzeitpunkt:</b> </td>
			 	<td> 
			 		<table width="100%" cellpadding="3" cellspacing="0" border="0">
			 		 <tr>
			 		 	<td width="1%"><input type="radio" checked name="starttime_type" value="directly"/></td>
			 		 	<td><b>Sofort </b></td>
			 		 </tr>
			 		 <tr>
			 		 	<td><input type="radio" name="starttime_type" value="point"/></td>
			 		 	<td><b>Zeitpunkt</b></td>
			 		 </tr>
			 		 	<td colspan="2">&nbsp;<input type="text" class="egl_text" name="ban_start_date" value="{date format='%d.%m.%Y' timestamp=$smarty.const.EGL_TIME}"> <input type="text" class="egl_text" name="ban_start_time" value="{date format='%H:%M' timestamp=$smarty.const.EGL_TIME}" size=10></td>
			 		 </tr>
			 		</table>
			 		
			 	</td 
			 </tr>
			 <tr bgcolor="#F3FFE0">
			 	<td> <b>Ablaufzeitpunkt:</b> </td>
			 	<td> 
			 	
			 	
			 		<table width="100%" cellpadding="3" cellspacing="0" border="0">
			 		 <tr>
			 		 	<td width="1%"><input type="radio" checked name="endtime_type" value="period"/></td>
			 		 	<td><b>Zeitspanne</b></td>
			 		 </tr>
			 		 <tr>
			 		 	<td colspan="2">
			 		 		<table>
			 		 		 <tr>
						 		<td><select name="ban_days" class="egl_select">{section name=day loop=31}<option value="{$smarty.section.day.index}">{$smarty.section.day.index} Tage</option>{/section}</select></td>
						 		<td><select name="ban_hours" class="egl_select">{section name=mins loop=25}<option value="{$smarty.section.mins.index}">{$smarty.section.mins.index} Stunden</option>{/section}</select></td>
						 		<td><select name="ban_minutes" class="egl_select">{section name=sec loop=61}<option value="{$smarty.section.sec.index}">{$smarty.section.sec.index} Minuten</option>{/section}</select></td>
			 		 		 </tr>
			 		 		</table>
			 		 	</td>
			 		 </tr>
			 		 <tr>
			 		 	<td><input type="radio" name="endtime_type" value="point"/></td>
			 		 	<td><b>Zeitpunkt</b></td>
			 		 </tr>
			 		 	<td colspan="2">&nbsp;<input type="text" class="egl_text" name="ban_end_date" value="{date format='%d.%m.%Y'}"> <input type="text" class="egl_text" name="ban_end_time" value="{date format='%H:%M'}" size=10> </td>
			 		 </tr>
			 		</table>
			 		
			 	
			 	</td 
			 </tr>
			 <tr bgcolor="{#clr_content#}">
			 	<td align="right"><input type="checkbox" name="send_email" value="yes"/></td>
			 	<td>Ja, Benachrichtigung per E-Mail an Mitglied schicken</td>
			 </tr>
			 <tr bgcolor="{#clr_content#}">
			 	<td align="right"><input type="checkbox" name="add_history" checked value="yes"/></td>
			 	<td>Ja, in History vermerken</td>
			 </tr>
 			 <tr bgcolor="{#clr_content#}">
 			 	<td colspan="2" align="right"><input title="Sperre aktivieren" type="image" src="images/buttons/new/bt_send.gif"/></td>
 			 </tr>
 			</table>
		</form>
 			
		
 		{/if}	
 	
 		<br/>
 		<form action="{$url_file}page={$url_page}&member_id={$member_data->id}&a=mail:send" method="POST">
 			<table border="0" cellpadding="5" cellspacing="1" width="100%">
 			 <tr bgcolor="{#clr_content_border#}">
 			 	<td colspan="2"><b>Nachricht schreiben</b></td>
 			 </tr>
 			 <tr bgcolor="{#clr_content#}">
 			 	<td><input type="radio" class="egl_radio" checked name="mail_type" value="pm"/> via. Personal Message (PM)</td>
 			 </tr>
 			 <tr bgcolor="{#clr_content#}">
 			 	<td><input type="radio" class="egl_radio" name="mail_type" value="email"/> via. E-Mail</td>
 			 </tr>
 			 <tr bgcolor="{#clr_content#}">
 			 	<td><b>Nachricht</b>:<br/><textarea name="mail_message" class="egl_textbox" rows="10" style="width:100%;"></textarea></td> 			 
 			 </tr>
 			 <tr bgcolor="{#clr_content#}">
 			 	<td colspan="2" align="right"><input title="Sperre aktivieren" type="image" src="images/buttons/new/bt_send.gif"/></td>
 			 </tr>
 			</table> 
 		</form>	
 	
 	
 	</td>
 	<td valign="top">
		
 	
 			{if $online_state}
 			<table border="0" cellpadding="5" cellspacing="1" width="100%">
 			 <tr bgcolor="{#clr_content_border#}">
 			 	<td colspan="2"><b>Mitglied ist gerade Online!</b></td>
 			 </tr>
 			 <tr bgcolor="#F3FFE0">
 			 	<td width="100"><b>Letzte Seite:</b></td>
 			 	<td>{$online_state->last_page}</td>
 			 </tr>
 			 <tr bgcolor="#F3FFE0">
 			 	<td width="150"><b>Zuletzt aktualisiert:</b></td>
 			 	<td>{date timestamp=$online_state->last_action}</td>
 			 </tr>
 			</table> 
 			{else}
 			<table border="0" cellpadding="5" cellspacing="1" width="100%">
 			 <tr bgcolor="{#clr_content_border#}">
 			 	<td colspan="2"><b>Mitglied ist gerade Offline!</b></td>
 			 </tr>
 			 <tr bgcolor="#FFF2E0">
 			 	<td width="150"><b>Letzter Login:</b></td>
 			 	<td>{date timestamp=$online_state->last_login}</td>
 			 </tr>
 			</table> 
 			{/if}
 			
 			<br/>
 			<table border="0" cellpadding="5" cellspacing="1" width="100%">
 			 <tr bgcolor="{#clr_content_border#}">
 			 	<td><b>History</b> <i>letzten 15 einträge</i></td>
 			 </tr>
 			 {section name=history loop=$historylist}
 			 <tr bgcolor="{#clr_content#}">
 			 	<td> {$historylist[history]->message} &nbsp;&nbsp;&nbsp;<i>created {date timestamp=$historylist[history]->created} </i> </td>
 			 </tr>
 			 {/section}
 			 <tr>
 			 	<td align="right">&nbsp;&nbsp;[ <A title="History einsehen und bearbeiten?" href="{$url_file}page=cms.member.history&member_id={$member_data->id}">History verwalten</a> ]</td>
 			 </tr>
 			</table> 	
 	
 	
 	</td>
 </tr>
</table>


{/if}