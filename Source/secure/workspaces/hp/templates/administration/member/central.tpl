<h2>{$LNG_BASIC.c8014} `{$member_data->nick_name|strip_tags|stripslashes}`</h2>
{include file="administration/member/header_menu.tpl"}
{include file="devs/hr2.tpl" width="100%"}
{include file="devs/message.tpl"}

{if $success}
{else}

<table width="100%" border="0" cellpadding="5" cellspacing="10">
 <tr>
 	<td width="50%" valign="top">
 	
 			<table border="0" cellpadding="5" cellspacing="1" width="100%">
 			 <tr bgcolor="{#clr_content_border#}">
 			 	<td colspan="2"><b>{$LNG_BASIC.c8050}</b></td>
 			 </tr>
 			 <tr bgcolor="{#clr_content#}">
 			 	<td valign="top" align="right"><b>{$LNG_BASIC.c8051}:</b></td>
 			 	<td valign="top" width="50%">
 			 	{section name=clan loop=$member_clans}
 			 		<a href="{$url_file}page=administration.clan.central&clan_id={$member_clans[clan]->id}">{$member_clans[clan]->name}</a>,
 			 		{section name=p loop=$cpl}
 			 			{if $cpl[p]->const == $member_clans[clan]->permissions}
 			 				{$cpl[p]->name}
 			 			{/if}
 			 		{/section}
 			 		<br/>
 			 	{sectionelse}
 			 	{$LNG_BASIC.c1212}
 			 	{/section}
 			 	</td>
 			 </tr>
 			 <tr bgcolor="{#clr_content#}">
 			 	<td valign="top" align="right"><b>{$LNG_BASIC.c8052}:</b></td>
 			 	<td valign="top">
 			 	{section name=team loop=$member_teams}
 			 		<a href="{$url_file}page=administration.team.central&team_id={$member_teams[team]->id}">{$member_teams[team]->name|strip_tags|stripslashes}</a>,
 			 		{section name=p loop=$tpl}
 			 			{if $tpl[p]->const == $member_teams[team]->permissions}
 			 				{$tpl[p]->name}
 			 			{/if}
 			 		{/section}
 			 		<br/>
 			 	{sectionelse}
 			 	{$LNG_BASIC.c1212}
 			 	{/section}
 			 	</td>
 			 </tr>
 			</table>
 		<br/>	 
 		 	
 		{if $MEMBER_BANNED}
 		
 			<table border="0" cellpadding="5" cellspacing="1" width="100%">
 			 <tr bgcolor="{#clr_content_border#}">
 			 	<td colspan="2"><b><font color="#A80000">{$LNG_BASIC.c8054}</font></b>
 			 	&nbsp;
 			 	[ <A title="{$LNG_BASIC.c8063}" href="{$url_file}page={$url_page}&member_id={$member_data->id}&a=ban:deactivate"><b>{$LNG_BASIC.c8055}</b></a> ]
 			 	</td>
 			 </tr>
 			 <tr bgcolor="{#clr_content#}">
 			 	<td><b>{$LNG_BASIC.c8064}:</b></td>
 			 	<td>{date timestamp=$member_data->ban_start} </td>
 			 </tr>
 			 <tr bgcolor="{#clr_content#}">
 			 	<td><b>{$LNG_BASIC.c8065}:</b></td>
 			 	<td>{date timestamp=$member_data->ban_end} </td>
 			 </tr>
 			 <tr bgcolor="{#clr_content#}">
 			 	<td><b>{$LNG_BASIC.c8066}:</b></td>
 			 	<td>{lng_parser content=$LNG_BASIC.c4280 days=$ban_time.days hours=$ban_time.hours minutes=$ban_time.mins seconds=$ban_time.seconds}</td>
 			 </tr>
 			 <tr bgcolor="#FFF2E0">
 			 	<td><b>{$LNG_BASIC.c8067}:</b></td>
 			 	<td>{lng_parser content=$LNG_BASIC.c4280 days=$expire_time.days hours=$expire_time.hours minutes=$expire_time.mins seconds=$expire_time.seconds}</td>
 			 </tr>
 			</table>

 		
 		{else}

 		
		<form action="{$url_file}page={$url_page}&member_id={$member_data->id}&a=ban:activate" method="POST">
 			<table border="0" cellpadding="5" cellspacing="1" width="100%">
 			 <tr bgcolor="{#clr_content_border#}">
 			 	<td colspan="2"><b>{$LNG_BASIC.c8053}</b></td>
 			 </tr>
			 <tr bgcolor="#FFF2E0">
			 	<td><b>{$LNG_BASIC.c8056}:</b></td>
			 	<td> 
			 		<table width="100%" cellpadding="3" cellspacing="0" border="0">
			 		 <tr>
			 		 	<td width="1%"><input type="radio" checked name="starttime_type" value="directly"/></td>
			 		 	<td><b>{$LNG_BASIC.c8057}</b></td>
			 		 </tr>
			 		 <tr>
			 		 	<td><input type="radio" name="starttime_type" value="point"/></td>
			 		 	<td><b>{$LNG_BASIC.c8058}</b></td>
			 		 </tr>
			 		 	<td colspan="2">&nbsp;<input type="text" class="egl_text" name="ban_start_date" value="{date format='%d.%m.%Y' timestamp=$smarty.const.EGL_TIME}"> <input type="text" class="egl_text" name="ban_start_time" value="{date format='%H:%M' timestamp=$smarty.const.EGL_TIME}" size=10></td>
			 		 </tr>
			 		</table>
			 		
			 	</td 
			 </tr>
			 <tr bgcolor="#F3FFE0">
			 	<td><b>{$LNG_BASIC.c8065}:</b></td>
			 	<td> 
			 	
			 		<table width="100%" cellpadding="3" cellspacing="0" border="0">
			 		 <tr>
			 		 	<td width="1%"><input type="radio" checked name="endtime_type" value="period"/></td>
			 		 	<td><b>{$LNG_BASIC.c8059}</b></td>
			 		 </tr>
			 		 <tr>
			 		 	<td colspan="2">
			 		 		<table>
			 		 		 <tr>
						 		<td><select name="ban_days" class="egl_select">{section name=day loop=31}<option value="{$smarty.section.day.index}">{$smarty.section.day.index} {$LNG_BASIC.c1220}</option>{/section}</select></td>
						 		<td><select name="ban_hours" class="egl_select">{section name=mins loop=25}<option value="{$smarty.section.mins.index}">{$smarty.section.mins.index} {$LNG_BASIC.c1221}</option>{/section}</select></td>
						 		<td><select name="ban_minutes" class="egl_select">{section name=sec loop=61}<option value="{$smarty.section.sec.index}">{$smarty.section.sec.index} {$LNG_BASIC.c1222}</option>{/section}</select></td>
			 		 		 </tr>
			 		 		</table>
			 		 	</td>
			 		 </tr>
			 		 <tr>
			 		 	<td><input type="radio" name="endtime_type" value="point"/></td>
			 		 	<td><b>{$LNG_BASIC.c8058}</b></td>
			 		 </tr>
			 		 	<td colspan="2">&nbsp;<input type="text" class="egl_text" name="ban_end_date" value="{date format='%d.%m.%Y'}"> <input type="text" class="egl_text" name="ban_end_time" value="{date format='%H:%M'}" size=10> </td>
			 		 </tr>
			 		</table>
			 		
			 	
			 	</td 
			 </tr>
			 <tr bgcolor="{#clr_content#}">
			 	<td align="right"><input type="checkbox" name="send_email" value="yes"/></td>
			 	<td>{$LNG_BASIC.c8061}</td>
			 </tr>
			 <tr bgcolor="{#clr_content#}">
			 	<td align="right"><input type="checkbox" name="add_history" checked value="yes"/></td>
			 	<td>{$LNG_BASIC.c8062}</td>
			 </tr>
 			 <tr bgcolor="{#clr_content#}">
 			 	<td colspan="2" align="right"><input title="{$LNG_BASIC.c8054}" type="submit"  value=" {$LNG_BASIC.c1018} "/></td>
 			 </tr>
 			</table>
		</form>
 			
		
 		{/if}	
 	
 		<br/>
 		<form action="{$url_file}page={$url_page}&member_id={$member_data->id}&a=mail:send" method="POST">
 			<table border="0" cellpadding="5" cellspacing="1" width="100%">
 			 <tr bgcolor="{#clr_content_border#}">
 			 	<td colspan="2"><b>{$LNG_BASIC.c8068}</b></td>
 			 </tr>
 			 <tr bgcolor="{#clr_content#}">
 			 	<td><input type="radio" class="egl_radio" checked name="mail_type" value="pm"/>{$LNG_BASIC.c8069}</td>
 			 </tr>
 			 <tr bgcolor="{#clr_content#}">
 			 	<td><input type="radio" class="egl_radio" name="mail_type" value="email"/>{$LNG_BASIC.c1007}</td>
 			 </tr>
 			 <tr bgcolor="{#clr_content#}">
 			 	<td><b>{$LNG_BASIC.c4400}</b>:<br/><textarea name="mail_message" class="egl_textbox" rows="10" style="width:100%;"></textarea></td> 			 
 			 </tr>
 			 <tr bgcolor="{#clr_content#}">
 			 	<td colspan="2" align="right"><input title="Sperre aktivieren" type="submit" value=" {$LNG_BASIC.c1018} "/></td>
 			 </tr>
 			</table> 
 		</form>	
 	
 	
 	</td>
 	<td valign="top">

 	 	{if $online_state}
 			<table border="0" cellpadding="5" cellspacing="1" width="100%">
 			 <tr bgcolor="{#clr_content_border#}">
 			 	<td colspan="2"><b>{$LNG_BASIC.c8091}</b></td>
 			 </tr>
 			 <tr bgcolor="#F3FFE0">
 			 	<td width="100"><b>{$LNG_BASIC.c8093}:</b></td>
 			 	<td><A title="Zur Seite springen" href="{$url_file}page={$online_state->last_page}">{cutstr text=$online_state->last_page num=20}</a></td>
 			 </tr>
 			 <tr bgcolor="#F3FFE0">
 			 	<td width="150"><b>{$LNG_BASIC.c8094}:</b></td>
 			 	<td>{date timestamp=$online_state->last_action}</td>
 			 </tr>
 			</table> 
 		{else}
 			<table border="0" cellpadding="5" cellspacing="1" width="100%">
 			 <tr bgcolor="{#clr_content_border#}">
 			 	<td colspan="2"><b>{$LNG_BASIC.c8090}</b></td>
 			 </tr>
 			 <tr bgcolor="#FFF2E0">
 			 	<td width="150"><b>{$LNG_BASIC.c8092}:</b></td>
 			 	<td>{date timestamp=$online_state->last_login}</td>
 			 </tr>
 			</table> 
 			{/if}
 			
 			<br/>
 			<table border="0" cellpadding="5" cellspacing="1" width="100%">
 			 <tr bgcolor="{#clr_content_border#}">
 			 	<td><b>{$LNG_BASIC.c8095}</b> <i>{$LNG_BASIC.c8096}</i></td>
 			 </tr>
 			 {section name=history loop=$historylist}
 			 <tr bgcolor="{#clr_content#}">
 			 	<td> {$historylist[history]->message} &nbsp;&nbsp;&nbsp;<i>created {date timestamp=$historylist[history]->created} </i> </td>
 			 </tr>
 			 {/section}
 			 <tr>
 			 	<td align="right">&nbsp;&nbsp;[ <a href="{$url_file}page=administration.member.history&member_id={$member_data->id}">{$LNG_BASIC.c8097}</a> ]</td>
 			 </tr>
 			</table> 	
 	
 	
 	</td>
 </tr>
</table>


{/if}