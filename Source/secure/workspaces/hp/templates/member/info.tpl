{include file="devs/message.tpl"}


{**********************}
{**MEMBER FOUND ?    **}
{**********************}
{if $member_details}

	<table border="0" cellpadding="0" cellspacing="0" width="100%">
	 <tr>
	 	<td><h2>{$member_details->nick_name|strip_tags|stripslashes}</h2></td>
	 	<td width="200">
	 		<!--### START ###-->
	 		<table border="0" cellpadding="0" cellspacing="0">
	 		 <tr>
	 		 	<td>{include file="buttons/bt_universal.tpl" color=$GLOBAL_COLOR caption=$LNG_BASIC.c4270 link="`$url_file`page=member.info&member_id=`$member_details->id`" }</td>
	 		 	<td>{include file="buttons/bt_universal.tpl" color=$GLOBAL_COLOR caption=$LNG_BASIC.c4271 link="`$url_file`page=member.about_me&member_id=`$member_details->id`"}</td>
	 		 </tr>
	 		</table>
	 	</td>
	 </tr>
	</table>
	<br/>
	{*include file="devs/hr_black.tpl" width="100%"*}
	<table border="0" width="100%" >
	 <tr>
	 	<td width="1%" valign="top">
	
		 		<table border=0 bgcolor="{#clr_content_border#}" cellpadding="0" cellspacing="1">
		 		 <tr><td>
		 		{if $member_details->photo_file != 'non'}
			 		<A href='{$url_file}page=member.info&member_id={$member_details->id}'><img  border="1" style="border-color:#000000;" src="{$path_photos}{$member_details->photo_file}" width="100" height="133"/></a>
			 	{else}
			 		<img src="images/photo.na.jpg" width="100" height="133">
		 		{/if}
		 		</td></tr>
		 		</table>
		 		 	
	 	</td>
	 	<td valign="top">
		
	 		{* Member-id *}
	 		<table border="0" width="100%">
	 		 <tr>
	 		 	<td><font size=1><i>{$LNG_BASIC.c4250}, {$LNG_BASIC.c4251}</font></i> </td>
	 		 </tr>
	 		 <tr>
	 		 	<td background="images/eglbeta/desc_bg.gif" style="background-repeat: repeat-x; background-position:bottom right;"> <b>{$member_details->id}</b></td>
	 		 </tr>
	 		</table>	
	
	 	
	 		{* Nickname *}
	 		<table border="0" width="100%">
	 		 <tr>
	 		 	<td><font size=1><i>{$LNG_BASIC.c4252}</font></i> </td>
	 		 </tr>
	 		 <tr>
	 		 	<td  background="images/eglbeta/desc_bg.gif" style="background-repeat: repeat-x; background-position:bottom right;"> <b> {$member_details->nick_name|strip_tags|stripslashes}</b></td>
	 		 </tr>
	 		</table>	
	 	
	 		
	 		{* names *}
	 		<table border="0" width="100%">
	 		 <tr>
	 		 	<td><font size=1><i>{$LNG_BASIC.c4255}</font></i> </td>
	 		 </tr>
	 		 <tr>
	 		 	<td background="images/eglbeta/desc_bg.gif" style="background-repeat: repeat-x; background-position:bottom right;"> <b>
				 {if $is_pubkey_first_name OR $is_pubkey_next_name }
					{if $is_pubkey_first_name}{$member_details->first_name|strip_tags|stripslashes}{/if} 
					{if $is_pubkey_next_name}{$member_details->next_name|strip_tags|stripslashes}{/if} 
				{else}
					<b>{$LNG_BASIC.c1021}</b>
	 			 {/if}
	 		 	</b>
	 		 	</td>
	 		 </tr>
	 		</table>
	 		
	 		{* nationality *}
	 		<table border="0" width="100%">
	 		 <tr>
	 		 	<td><font size=1><i>{$LNG_BASIC.c4257}</font></i> </td>
	 		 </tr>
	 		 <tr>
	 		 	<td background="images/eglbeta/desc_bg.gif" style="background-repeat: repeat-x; background-position:bottom right;"> 
	 		 	{if $is_pubkey_country_id}
			 		{section name=country loop=$countries}
			 			{if $member_details->country_id == $countries[country]->id}
			 				<b>{$countries[country]->name}</b> <img src="{$path_country}{$countries[country]->image_file}">
			 				
			 			{/if}
			 		{/section}
			 	{else}
					<b>{$LNG_BASIC.c1021}</b>
			 	{/if}		
	 		 	
	 		 	</td>
	 		 </tr>
	 		</table> 		
	 		
	 		
	
	 		{* Birthday *}
	 		<table border="0" width="100%">
	 		 <tr>
	 		 	<td><font size=1><i>{$LNG_BASIC.c4258}</font></i> </td>
	 		 </tr>
	 		 <tr>
	 		 	<td background="images/eglbeta/desc_bg.gif" style="background-repeat: repeat-x; background-position:bottom right;"> 
	 		 	{if $member_details->birthday && $is_pubkey_birthday}
	 		 		<b>{$member_details->birthday|strip_tags|stripslashes}, {age date=$member_details->birthday} {$LNG_BASIC.c1213} </b> 
	 		 	{else}
	 		 		<b>{$LNG_BASIC.c1021}</b>
	 		 	{/if}
	 		 	</td>
	 		 </tr>
	 		</table>	
	 		
	 		
	 		{* Location *}
	 		
	 		<table border="0" width="100%">
	 		 <tr>
	 		 	<td><font size=1><i>{$LNG_BASIC.c4263}</font></i> </td>
	 		 </tr>
	 		 <tr>
	 		 	<td background="images/eglbeta/desc_bg.gif" style="background-repeat: repeat-x; background-position:bottom right;"><b> 
	 		 	{if $is_pubkey_street}{$member_details->street|strip_tags|stripslashes}{/if} 
	 		 	{if $is_pubkey_zip_code}{$member_details->zip_code|strip_tags|stripslashes} {/if}
	 		 	{if $is_pubkey_city}{$member_details->city|strip_tags|stripslashes} {/if}
 		 		</b>
	 		 		
	 		 	{if !$is_pubkey_city && !$is_pubkey_street && !$is_pubkey_zip_code} <b>{$LNG_BASIC.c1021}</b> {/if}
	 		 	</td>
	 		 </tr>
	 		</table> 		 		
		 		 		
	 	 	
	 	</td>
	 	<td width="50%" valign="top">
	 	
	 	
	 		{* Job *}
	 		<table border="0" width="100%">
	 		 <tr>
	 		 	<td><font size=1><i>{$LNG_BASIC.c4259}</font></i> </td>
	 		 </tr>
	 		 <tr>
	 		 	<td background="images/eglbeta/desc_bg.gif" style="background-repeat: repeat-x; background-position:bottom right;"> <b>
	 		 	{if $is_pubkey_job} {$member_details->job|strip_tags|stripslashes} {else}  	{$LNG_BASIC.c1021} {/if}
	 		 	</b>
	 		 	</td>
	 		 </tr>
	 		</table>
	 		
	 		{* HOBBYS *}
	 		<table border="0" width="100%">
	 		 <tr>
	 		 	<td><font size=1><i>{$LNG_BASIC.c4324}</font></i> </td>
	 		 </tr>
	 		 <tr>
	 		 	<td background="images/eglbeta/desc_bg.gif" style="background-repeat: repeat-x; background-position:bottom right;"> <b>
	 		 	{if $is_pubkey_hobbies} {$member_details->hobbies|strip_tags|stripslashes} {else}  	{$LNG_BASIC.c1021} {/if}
	 		 	</b>
	 		 	</td>
	 		 </tr>
	 		</table>
	 			 		 	
	 	
	 		{* Clan *}
	 		<table border="0" width="100%">
	 		 <tr>
	 		 	<td><font size=1><i>{$LNG_BASIC.c4260}</font></i> </td>
	 		 </tr>
	 		 <tr>
	 		 	<td background="images/eglbeta/desc_bg.gif" style="background-repeat: repeat-x; background-position:bottom right;"> 
	 		 	{if $is_pubkey_clan_name}
		 		 	{if strlen($member_details->clan_name) > 0 }
		 		 		<b>{$member_details->clan_name|strip_tags|stripslashes} </b> 
		 		 		{if strlen($member_details->clan_tag) > 0}
		 		 			<b>, {$member_details->clan_tag|strip_tags|stripslashes}
		 		 		{/if}
	 		 		{/if}
	 		 		{if $is_pubkey_clan_hp && strlen($member_details->clan_hp) > 0}, <a target="_blank" href="{$member_details->clan_hp|strip_tags|stripslashes}">{$LNG_BASIC.c4723}</a>{/if}
	 		 	{else}
	 		 		<b>{$LNG_BASIC.c1021}</b>
	 		 	{/if}
	 		 	</td>
	 		 </tr>
	 		</table>
	 	
	 		{* Sex *}
	 		<table border="0" width="100%">
	 		 <tr>
	 		 	<td><font size=1><i>{$LNG_BASIC.c4261}</font></i> </td>
	 		 </tr>
	 		 <tr>
	 		 	<td background="images/eglbeta/desc_bg.gif" style="background-repeat: repeat-x; background-position:bottom right;"> 
	 		 	{if $member_details->sex == 'M' } <b>{$LNG_BASIC.c4264}</b> 
	 		 	{elseif $member_details->sex == 'F' } <b>{$LNG_BASIC.c4265}</b> 
	 		 	{else}
	 		 	<b>{$LNG_BASIC.c1021}</b>
	 		 	{/if}
	 		 	
	 		 	
	 		 	</td>
	 		 </tr>
	 		</table>
	 		
	 		
	 		{* registered *}
	 		<table border="0" width="100%">
	 		 <tr>
	 		 	<td><font size=1><i>{$LNG_BASIC.c4262}</font></i> </td>
	 		 </tr>
	 		 <tr>
	 		 	<td background="images/eglbeta/desc_bg.gif" style="background-repeat: repeat-x; background-position:bottom right;"> 
	 		 	<b>{date timestamp=$member_details->created format="%d.%m.%Y"}</b>
	 		 	</td>
	 		 </tr>
	 		</table>
	 		
	 		
	 		{* last login *}
	 		{if $is_pubkey_last_login}
	 		<table border="0" width="100%">
	 		 <tr>
	 		 	<td><font size=1><i>{$LNG_BASIC.c4273}</font></i> </td>
	 		 </tr>
	 		 <tr>
	 		 	<td background="images/eglbeta/desc_bg.gif" style="background-repeat: repeat-x; background-position:bottom right;"> 
	 		 	<b>{date timestamp=$member_details->last_login format="%d.%m.%Y"}</b>
	 		 	</td>
	 		 </tr>
	 		</table>
	 		{/if}
	 		
	 	</td>

	 </tr>
	</table>
	<br/>
 		{if $MEMBER_BANNED}
 			<table width="100%" cellpadding="5" cellspacing="2" bgcolor="#A80000">
 			 <tr>
 				<td bgcolor="#FFFFFF"><b>{lng_parser content=$LNG_BASIC.c4274 ban_end=$member_details->ban_end}</b></td>
 			 </tr>
 			</table>
 		
 			<br/><div align="right"><A href="#" onclick="if (baninfo.style.display == 'none') baninfo.style.display = 'block'; else baninfo.style.display = 'none';"><b>{$LNG_BASIC.c4275}</b></a></div>
 			
 			<div id="baninfo" style="display:none;">
 			<table width="100%" cellpadding="0" cellspacing="1" bgcolor="#A80000">
 			 <tr><td bgcolor="#FFFFFF">
	 			<table border="0" cellpadding="5" cellspacing="1" width="100%">
	 			 <tr bgcolor="{#clr_content#}">
	 			 	<td><b>{$LNG_BASIC.c4276}:</b></td>
	 			 	<td>{date timestamp=$member_details->ban_start} </td>
	 			 </tr>
	 			 <tr bgcolor="{#clr_content#}">
	 			 	<td><b>{$LNG_BASIC.c4277}:</b></td>
	 			 	<td>{date timestamp=$member_details->ban_end} </td>
	 			 </tr>
	 			 <tr bgcolor="{#clr_content#}">
	 			 	<td><b>{$LNG_BASIC.c4278}:</b></td>
	 			 	<td>{lng_parser content=$LNG_BASIC.c4280 days=$ban_time.days hours=$ban_time.hours minutes=$ban_time.mins seconds=$ban_time.seconds}</td>
	 			 </tr>
	 			 <tr bgcolor="{#clr_content#}">
	 			 	<td><b>{$LNG_BASIC.c4279}:</b></td>
	 			 	<td>{lng_parser content=$LNG_BASIC.c4280 days=$expire_time.days hours=$expire_time.hours minutes=$expire_time.mins seconds=$expire_time.seconds}</td>
	 			 </tr>
	 			</table>
	 		 </td></tr>
	 		</table>
	 		
 			</div>
 		{/if}
 	

	<br/><br/>
	<table border="0" width="100%" cellpadding="0" cellspacing="0">
	 <tr><td><h2>{$LNG_BASIC.c4266}</h2></td></tr>
	 <tr><td>{include file="devs/hr_black.tpl" width="100%"}</td></tr>
	</table>	
	
	<table border="0" cellpadding="3" cellspacing="1" width="100%">
	 <tr>
	 	<td width="30%" bgcolor="{#clr_content#}"><b>{$LNG_BASIC.c4267}:</b></td>
	 	<td bgcolor="{#clr_content#}"> [ <a href="{$url_file}page=email_send&member_id={$member_details->id}">{$LNG_BASIC.c2106}</a> ] 
	 	{if $is_pubkey_email }	{#arrow_db_right#} {scrambler string=$member_details->email|strip_tags|stripslashes} {/if}
	 	</td>
	 </tr>
	  <tr>
	 	<td bgcolor="{#clr_content#}"><b>{$LNG_BASIC.c4268}:</b></td>
	 	{if $is_loggedin}
	 		<td bgcolor="{#clr_content#}">[ <a href="{$url_file}page=pm.write&member_id={$member_details->id}">{$LNG_BASIC.c2106}</a> ]</td>
	 	{else}
	 		<td bgcolor="{#clr_content#}">[ <font color="{#clr_disabled#}">{$LNG_BASIC.c2106}</font> ]</td>
	 	{/if}
	 </tr>
	 {if $is_pubkey_msn} 
	 <tr>
	 	<td bgcolor="{#clr_content#}"><b>{$LNG_BASIC.c4281}:</b></td>
	 	<td bgcolor="{#clr_content#}">{scrambler string=$member_details->msn|strip_tags|stripslashes}</td>
	 </tr>
	 {/if}
	 {if $is_pubkey_icq}
	 <tr>
	 	<td bgcolor="{#clr_content#}" ><b>{$LNG_BASIC.c4282}:</b></td>
	 	<td bgcolor="{#clr_content#}">
	 		{if $member_details->icq }
	 		<table border="0" cellpadding="0" cellspacing="0"><tr>
	 			<td><img width="18" height="18" src="http://web.icq.com/whitepages/online?icq={$member_details->icq|strip_tags|icq}&amp;img=5"></td>
	 			<td>{scrambler string=$member_details->icq|strip_tags|stripslashes|icq}</td>
	 		</tr></table>
	 		{else}{$LNG_BASIC.c1021}{/if}
	 	</td>
	 </tr>
	 {/if}
	 {if $is_pubkey_irc_nick && strlen($member_details->irc_nick) > 0 }
	 <tr>
	 	<td bgcolor="{#clr_content#}"><b>{$LNG_BASIC.c4283}:</b></td>
	 	<td bgcolor="{#clr_content#}">{$member_details->irc_nick|strip_tags|stripslashes}</td>
	 </tr>
	 {/if}
	 {if $is_pubkey_mobilefone && strlen($member_details->mobilefone) > 0}
	 <tr>
	 	<td bgcolor="{#clr_content#}"><b>{$LNG_BASIC.c4284}:</b></td>
	 	<td bgcolor="{#clr_content#}">{scrambler string=$member_details->mobilefone|strip_tags|stripslashes}</td>
	 </tr>
	 {/if}
	 {if $is_pubkey_clan_irc && strlen($member_details->clan_irc) > 0}
	 <tr>
	 	<td bgcolor="{#clr_content#}"><b>{$LNG_BASIC.c4315}:</b></td>
		<td bgcolor="{#clr_content#}">{scrambler string=$member_details->clan_irc|strip_tags|stripslashes}</td>	 
	 </tr>
	 {/if}
	</table>


	
	{if sizeof($gameaccounts) }
	<br/><br/>
	<table border="0" width="100%" cellpadding="0" cellspacing="0">
	 <tr><td><h2>{$LNG_BASIC.c4269}</h2></td></tr>
	 <tr><td>{include file="devs/hr_black.tpl" width="100%"}</td></tr>
	</table>	
	<table border="0" cellpadding="3" cellspacing="1" width="100%">
	 {section name=gameacc loop=$gameaccounts}
	 <tr>
	 	<td bgcolor="{#clr_content#}" width="30%"><b>{$gameaccounts[gameacc]->name|strip_tags|stripslashes}</b></td>
	 	<td bgcolor="{#clr_content#}">{$gameaccounts[gameacc]->value|strip_tags|stripslashes}
	 	&nbsp;&nbsp; <font color="#B4B4B4">(<i>{lng_parser content=$LNG_BASIC.c4286 time=$gameaccounts[gameacc]->gameacc_change_time}</i>)</font>
	 	</td>
	 </tr>
	 {/section}
	 </table>
	 {/if}
	 
	 {if sizeof($member_clans) || sizeof($member_teams) }
		<br/><br/>
		<table border="0" width="100%" cellpadding="0" cellspacing="0">
		 <tr><td><h2>{$LNG_BASIC.c4272}</h2></td></tr>
		 <tr><td>{include file="devs/hr_black.tpl" width="100%"}</td></tr>
		</table>	
		
		<table border="0" cellpadding="3" cellspacing="1" width="100%">
		 {if sizeof($member_clans) }
		 <tr>
		 	<td bgcolor="{#clr_content#}" width="30%"> <b>{$LNG_BASIC.c1013}:</b></td>
		 	<td bgcolor="{#clr_content#}"> 
				{section name=clan loop=$member_clans}
			 		<a href="{$url_file}page=clan.info&clan_id={$member_clans[clan]->id}">{$member_clans[clan]->name|strip_tags|stripslashes}</a> 
			 		{if !$smarty.section.clan.last}	, {/if}
			 	{/section}
		 	</td>
		 </tr>
		 {/if}
		 {if sizeof($member_teams) }
		 <tr>
		 	<td bgcolor="{#clr_content#}" width="30%"><b>{$LNG_BASIC.c1011}:</b></td>
		 	<td bgcolor="{#clr_content#}">
				{section name=team loop=$member_teams}
					<a href='{$url_file}page=team.info&team_id={$member_teams[team]->id}#comment_write'>{$member_teams[team]->name|strip_tags|stripslashes}</a>
					{if !$smarty.section.team.last}	, {/if}
				{/section}
				
		 	</td>
		 </tr>
		{/if}
		</table>
		
	{/if}		

	{if strlen($member_details->description)}
	<br/><br/>
	<table border="0" width="100%" cellpadding="0" cellspacing="0">
	 <tr><td><h2>{$LNG_BASIC.c4285}</h2></td></tr>
	 <tr><td>{include file="devs/hr_black.tpl" width="100%"}</td></tr>
	</table>	
	<table border="0" cellpadding="3" cellspacing="1" width="100%" >
	 <tr>
		<td bgcolor="{#clr_content#}"><table border="0"><tr><td>{$member_details->description|strip_tags|stripslashes|bbcode2html|nl2br}</td></tr></table></td>
	 </tr>
	</table> 
	{/if}

{/if}