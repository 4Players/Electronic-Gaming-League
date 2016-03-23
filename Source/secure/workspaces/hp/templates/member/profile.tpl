<h2>{$LNG_BASIC.c4310}</h2>

{* SHOW MESSAGE => nur wenn eine vorhanden ist*}
{include file="devs/message.tpl"}


{*DARF NICHT VERÄNDERT WERDEN !!*}
{if !$success }
 <form name=f action='{$url_file}page={$url_page}&a=change_profile' method=POST> 
	<table border="0" width="100%" cellpadding="4" cellspacing="1" >
	 <tr>
	 	<td bgcolor="{#clr_content_border#}" colspan="2"></td>
	 	<td bgcolor="{#clr_content_rel_border#}"><b>{$LNG_BASIC.c4311}</b></td>
	 </tr>
	 <tr bgcolor="{#clr_content#}">
 		<td bgcolor="{#clr_content_rel#}"><b>{$LNG_BASIC.c4262}:</b></td>
 		<td> <b>{date timestamp=$member_details->created format="%d.%m.%Y / %H:%M"}</b>  </td>
 		<td class="egl_live_td"> <input class='egl_checkbox' type=checkbox name='pubkey_created' value=1 {$check_pubkey_created} ></td>
	 </tr>
	 <tr bgcolor="{#clr_content#}">
 		<td  bgcolor="{#clr_content_rel#}"><b>{$LNG_BASIC.c4273}:</td>
 		<td> <b>{date timestamp=$member_details->last_login format="%d.%m.%Y / %H:%M"}</b>  </td>
 		<td class="egl_live_td"> <input class='egl_checkbox' type=checkbox name='pubkey_last_login' value=1 {$check_pubkey_last_login} ></td>
	 </tr>
	 <tr bgcolor="{#clr_content#}">
 		<td bgcolor="{#clr_content_rel#}"><b>{$LNG_BASIC.c1022}:</b></td>
 		<td> <b>{$member_details->id}</b> </td>
	 </tr>
	 <tr bgcolor="{#clr_content#}">
 		<td bgcolor="{#clr_content_rel#}"><b>{$LNG_BASIC.c1003}:</b></td>
 		<td> ***** <i>(<A href='{$url_file}page=member.change_psd'><b>{$LNG_BASIC.c1209}</b></a>)</i> </td>
	 </tr>	 	 
	 <tr bgcolor="{#clr_content#}">
 		<td bgcolor="{#clr_content_rel#}"><b>{$LNG_BASIC.c4253}:</b></td>
 		<td class="egl_live_td"> <input onBlur="textbox_set_style(this, '{#clr_content#}', '{#clr_content#}', '#FFFFFF');" onFocus="textbox_set_style(this, '{#clr_textbox_border#}', '{#clr_textbox_bgcolor#}', '{#clr_textbox_color#}');" class='egl_live_text' type=text name='first_name' value='{$member_details->first_name|stripslashes}'> </td>
 		<td class="egl_live_td"> <input class='egl_checkbox' type=checkbox name='pubkey_first_name' value=1 {$check_pubkey_first_name} ></td>
	 </tr>
	 <tr bgcolor="{#clr_content#}">
 		<td  bgcolor="{#clr_content_rel#}"><b>{$LNG_BASIC.c4254}:</b></td>
 		<td class="egl_live_td"> <input onBlur="textbox_set_style(this, '{#clr_content#}', '{#clr_content#}', '#FFFFFF');" onFocus="textbox_set_style(this, '{#clr_textbox_border#}', '{#clr_textbox_bgcolor#}', '{#clr_textbox_color#}');" class='egl_live_text' type=text name='next_name' value='{$member_details->next_name|stripslashes}'> </td>
 		<td class="egl_live_td"> <input class='egl_checkbox' type=checkbox name='pubkey_next_name' value=1 {$check_pubkey_next_name} ></td>
	 </tr>
	 <tr bgcolor="{#clr_content#}">
 		<td  bgcolor="{#clr_content_rel#}"><b>{$LNG_BASIC.c4252}:</b></td>
 		<td class="egl_live_td"> <input onBlur="textbox_set_style(this, '{#clr_content#}', '{#clr_content#}', '#FFFFFF');" onFocus="textbox_set_style(this, '{#clr_textbox_border#}', '{#clr_textbox_bgcolor#}', '{#clr_textbox_color#}');" class='egl_live_text' type=text name='nick_name' value='{$member_details->nick_name|stripslashes}'> </td>
	 </tr>
	 <tr bgcolor="{#clr_content#}">
 		<td  bgcolor="{#clr_content_rel#}"><b>{$LNG_BASIC.c4261}:</b></td>
 		<td> <select class='egl_select' name='sex'>
 		
	 			{*male/männlich selektiert ?*}
	 			{if $member_details->sex == "M" }
	 				{assign var="male_select" value="selected"} 		
	 			{/if}
	 			{*female/weilich selektiert ?*}
	 			{if $member_details->sex == "F" }
	 				{assign var="female_select" value="selected"} 		
	 			{/if}
 		
 				<option value='M' {$male_select}>{$LNG_BASIC.c4264}</option>
 				<option value='F' {$female_select}>{$LNG_BASIC.c4265}</option>
 			</select>
 			 </td>
	 </tr>
	 <tr bgcolor="{#clr_content#}">
 		<td  bgcolor="{#clr_content_rel#}"><b>{$LNG_BASIC.c4301}:</b></td>
 		<td> <select class='egl_select' name='invisible'>
 		
		
 				<option value='0'>{$LNG_BASIC.c1401}</option>
 				{if $member_details->invisible == 1}
 					<option value='1' selected>{$LNG_BASIC.c1400}</option>
 				{else}
 					<option value='1'>{$LNG_BASIC.c1400}</option>
 				{/if}
 				
 			</select>
 			 </td>
	 </tr>
	 
	 {** CONTACT  **}
	 <tr bgcolor="{#clr_content_border#}">
	 	<td colspan=2><b>{$LNG_BASIC.c4266}</b></td>
	 </tr>
	 <tr bgcolor="{#clr_content#}">
 		<td  bgcolor="{#clr_content_rel#}"><b>{$LNG_BASIC.c4267}:</b></td>
 		<td> {$member_details->email} <i>(<A href='{$url_file}page=member.change_email'><b>{$LNG_BASIC.c1209}</B></a>)</i> </td>
 		<td class="egl_live_td"> <input onBlur="textbox_set_style(this, '{#clr_content#}', '{#clr_content#}', '#FFFFFF');" onFocus="textbox_set_style(this, '{#clr_textbox_border#}', '{#clr_textbox_bgcolor#}', '{#clr_textbox_color#}');" class='egl_checkbox' type=checkbox name='pubkey_email' value=1 {$check_pubkey_email}></td>
	 </tr>
	 <tr bgcolor="{#clr_content#}">
 		<td  bgcolor="{#clr_content_rel#}"><b>{$LNG_BASIC.c4282}:</b></td>
 		<td class="egl_live_td"> <input onBlur="textbox_set_style(this, '{#clr_content#}', '{#clr_content#}', '#FFFFFF');" onFocus="textbox_set_style(this, '{#clr_textbox_border#}', '{#clr_textbox_bgcolor#}', '{#clr_textbox_color#}');" class='egl_live_text' type=text name='icq' value='{$member_details->icq|stripslashes}'> </td>
 		<td class="egl_live_td"> <input class='egl_checkbox' type=checkbox name='pubkey_icq' value=1 {$check_pubkey_icq} ></td>
	 </tr>
	 <tr bgcolor="{#clr_content#}">
 		<td  bgcolor="{#clr_content_rel#}"><b>{$LNG_BASIC.c4281}:</b></td>
 		<td class="egl_live_td"> <input onBlur="textbox_set_style(this, '{#clr_content#}', '{#clr_content#}', '#FFFFFF');" onFocus="textbox_set_style(this, '{#clr_textbox_border#}', '{#clr_textbox_bgcolor#}', '{#clr_textbox_color#}');" class='egl_live_text' type=text name='msn' value='{$member_details->msn|stripslashes}'> </td>
 		<td class="egl_live_td"> <input class='egl_checkbox' type=checkbox name='pubkey_msn' value=1 {$check_pubkey_msn}></td>
	 </tr>
	 <tr bgcolor="{#clr_content#}">
 		<td  bgcolor="{#clr_content_rel#}"><b>{$LNG_BASIC.c4302}:</b></td>
 		<td class="egl_live_td"> <input onBlur="textbox_set_style(this, '{#clr_content#}', '{#clr_content#}', '#FFFFFF');" onFocus="textbox_set_style(this, '{#clr_textbox_border#}', '{#clr_textbox_bgcolor#}', '{#clr_textbox_color#}');" class='egl_live_text' type=text name='am' value='{$member_details->am|stripslashes}'> </td>
 		<td class="egl_live_td"> <input class='egl_checkbox' type=checkbox name='pubkey_am' value=1 {$check_pubkey_am}></td>
	 </tr>
	 <tr bgcolor="{#clr_content#}">
 		<td  bgcolor="{#clr_content_rel#}"><b>{$LNG_BASIC.c4283}:</b></td>
 		<td class="egl_live_td"> <input onBlur="textbox_set_style(this, '{#clr_content#}', '{#clr_content#}', '#FFFFFF');" onFocus="textbox_set_style(this, '{#clr_textbox_border#}', '{#clr_textbox_bgcolor#}', '{#clr_textbox_color#}');" class='egl_live_text' type=text name='irc_nick' value='{$member_details->irc_nick|stripslashes}'> </td>
 		<td class="egl_live_td"> <input class='egl_checkbox' type=checkbox name='pubkey_irc_nick' value=1 {$check_pubkey_irc_nick}></td>
	 </tr>
	 
	 {** CLAN **}
	 <tr bgcolor="{#clr_content_border#}">
	 	<td colspan=2><b>{$LNG_BASIC.c1012}</b></td>
	 </tr>	
	 <tr bgcolor="{#clr_content#}">
 		<td  bgcolor="{#clr_content_rel#}"><b>{$LNG_BASIC.c4312}:</b></td>
 		<td class="egl_live_td"> <input onBlur="textbox_set_style(this, '{#clr_content#}', '{#clr_content#}', '#FFFFFF');" onFocus="textbox_set_style(this, '{#clr_textbox_border#}', '{#clr_textbox_bgcolor#}', '{#clr_textbox_color#}');" class='egl_live_text' type=text name='clan_name' value='{$member_details->clan_name|stripslashes}'> </td>
 		<td class="egl_live_td"> <input class='egl_checkbox' type=checkbox name='pubkey_clan_name' value=1 {$check_pubkey_clan_name}></td>
	 </tr>
	 <tr bgcolor="{#clr_content#}">
 		<td  bgcolor="{#clr_content_rel#}"><b>{$LNG_BASIC.c4313}:</b></td>
 		<td class="egl_live_td"> <input onBlur="textbox_set_style(this, '{#clr_content#}', '{#clr_content#}', '#FFFFFF');" onFocus="textbox_set_style(this, '{#clr_textbox_border#}', '{#clr_textbox_bgcolor#}', '{#clr_textbox_color#}');" class='egl_live_text' type=text name='clan_tag' value='{$member_details->clan_tag|stripslashes}' > </td>
 		<td class="egl_live_td"> <input class='egl_checkbox' type=checkbox name='pubkey_clan_tag' value=1 {$check_pubkey_clan_tag}></td>
	 </tr>
	 <tr bgcolor="{#clr_content#}">
 		<td  bgcolor="{#clr_content_rel#}"><b>{$LNG_BASIC.c4314}:</b></td>
 		<td class="egl_live_td"> <input onBlur="textbox_set_style(this, '{#clr_content#}', '{#clr_content#}', '#FFFFFF');" onFocus="textbox_set_style(this, '{#clr_textbox_border#}', '{#clr_textbox_bgcolor#}', '{#clr_textbox_color#}');" class='egl_live_text' type=text name='clan_hp' value='{$member_details->clan_hp|stripslashes}' > </td>
 		<td class="egl_live_td"> <input class='egl_checkbox' type=checkbox name='pubkey_clan_hp' value=1 {$check_pubkey_clan_hp}></td>
	 </tr>
	 <tr bgcolor="{#clr_content#}">
 		<td  bgcolor="{#clr_content_rel#}"><b>{$LNG_BASIC.c4315}:</b></td>
 		<td class="egl_live_td"> <input onBlur="textbox_set_style(this, '{#clr_content#}', '{#clr_content#}', '#FFFFFF');" onFocus="textbox_set_style(this, '{#clr_textbox_border#}', '{#clr_textbox_bgcolor#}', '{#clr_textbox_color#}');" class='egl_live_text' type=text name='clan_irc' value='{$member_details->clan_irc|stripslashes}' > </td>
 		<td class="egl_live_td"> <input class='egl_checkbox' type=checkbox name='pubkey_clan_irc' value=1 {$check_pubkey_clan_irc}></td>
	 </tr>
	 
	 
	 {** COMPUTER **}
	 <tr bgcolor="{#clr_content_border#}">
	 	<td colspan=2><b>{$LNG_BASIC.c4288}</b></td>
	 </tr>	
	 <tr bgcolor="{#clr_content#}">
 		<td  bgcolor="{#clr_content_rel#}"><b>{$LNG_BASIC.c4289}:</b></td>
 		<td class="egl_live_td"> <input onBlur="textbox_set_style(this, '{#clr_content#}', '{#clr_content#}', '#FFFFFF');" onFocus="textbox_set_style(this, '{#clr_textbox_border#}', '{#clr_textbox_bgcolor#}', '{#clr_textbox_color#}');" class='egl_live_text' type=text name='cd_cpu' value='{$member_details->cd_cpu|stripslashes}'> </td>
	 </tr>
	 <tr bgcolor="{#clr_content#}">
 		<td  bgcolor="{#clr_content_rel#}"><b>{$LNG_BASIC.c4290}:</b></td>
 		<td class="egl_live_td"> <input onBlur="textbox_set_style(this, '{#clr_content#}', '{#clr_content#}', '#FFFFFF');" onFocus="textbox_set_style(this, '{#clr_textbox_border#}', '{#clr_textbox_bgcolor#}', '{#clr_textbox_color#}');" class='egl_live_text' type=text name='cd_mainboard' value='{$member_details->cd_mainboard|stripslashes}'> </td>
	 </tr>
	 <tr bgcolor="{#clr_content#}">
 		<td  bgcolor="{#clr_content_rel#}"><b>{$LNG_BASIC.c4291}:</b></td>
 		<td class="egl_live_td"> <input onBlur="textbox_set_style(this, '{#clr_content#}', '{#clr_content#}', '#FFFFFF');" onFocus="textbox_set_style(this, '{#clr_textbox_border#}', '{#clr_textbox_bgcolor#}', '{#clr_textbox_color#}');" class='egl_live_text' type=text name='cd_graphiccard' value='{$member_details->cd_graphiccard|stripslashes}'> </td>
	 </tr>
	 <tr bgcolor="{#clr_content#}">
 		<td  bgcolor="{#clr_content_rel#}"><b>{$LNG_BASIC.c4292}:</b></td>
 		<td class="egl_live_td"> <input onBlur="textbox_set_style(this, '{#clr_content#}', '{#clr_content#}', '#FFFFFF');" onFocus="textbox_set_style(this, '{#clr_textbox_border#}', '{#clr_textbox_bgcolor#}', '{#clr_textbox_color#}');" class='egl_live_text' type=text name='cd_soundcard' value='{$member_details->cd_soundcard|stripslashes}'> </td>
	 </tr>
	 <tr bgcolor="{#clr_content#}">
 		<td  bgcolor="{#clr_content_rel#}"><b>{$LNG_BASIC.c4293}:</b></td>
 		<td class="egl_live_td"> <input onBlur="textbox_set_style(this, '{#clr_content#}', '{#clr_content#}', '#FFFFFF');" onFocus="textbox_set_style(this, '{#clr_textbox_border#}', '{#clr_textbox_bgcolor#}', '{#clr_textbox_color#}');" class='egl_live_text' type=text name='cd_mouse' value='{$member_details->cd_mouse|stripslashes}'> </td>
	 </tr>
	 <tr bgcolor="{#clr_content#}">
 		<td  bgcolor="{#clr_content_rel#}"><b>{$LNG_BASIC.c4294}:</b></td>
 		<td class="egl_live_td"> <input onBlur="textbox_set_style(this, '{#clr_content#}', '{#clr_content#}', '#FFFFFF');" onFocus="textbox_set_style(this, '{#clr_textbox_border#}', '{#clr_textbox_bgcolor#}', '{#clr_textbox_color#}');" class='egl_live_text' type=text name='cd_mousepad' value='{$member_details->cd_mousepad|stripslashes}'> </td>
	 </tr>
	 <tr bgcolor="{#clr_content#}">
 		<td  bgcolor="{#clr_content_rel#}"><b>{$LNG_BASIC.c4295}:</b></td>
 		<td class="egl_live_td"> <input onBlur="textbox_set_style(this, '{#clr_content#}', '{#clr_content#}', '#FFFFFF');" onFocus="textbox_set_style(this, '{#clr_textbox_border#}', '{#clr_textbox_bgcolor#}', '{#clr_textbox_color#}');" class='egl_live_text' type=text name='cd_keyboard' value='{$member_details->cd_keyboard|stripslashes}'> </td>
	 </tr>
	 <tr bgcolor="{#clr_content#}">
 		<td bgcolor="{#clr_content_rel#}"><b>{$LNG_BASIC.c4296}:</b></td>
 		<td class="egl_live_td"> <input onBlur="textbox_set_style(this, '{#clr_content#}', '{#clr_content#}', '#FFFFFF');" onFocus="textbox_set_style(this, '{#clr_textbox_border#}', '{#clr_textbox_bgcolor#}', '{#clr_textbox_color#}');" class='egl_live_text' type=text name='cd_memory' value='{$member_details->cd_memory|stripslashes}'> </td>
	 </tr>
	 <tr bgcolor="{#clr_content#}">
 		<td bgcolor="{#clr_content_rel#}"><b>{$LNG_BASIC.c4297}:</b></td>
 		<td class="egl_live_td"> <input onBlur="textbox_set_style(this, '{#clr_content#}', '{#clr_content#}', '#FFFFFF');" onFocus="textbox_set_style(this, '{#clr_textbox_border#}', '{#clr_textbox_bgcolor#}', '{#clr_textbox_color#}');" class='egl_live_text' type=text name='cd_harddisk' value='{$member_details->cd_harddisk|stripslashes}'> </td>
	 </tr>
	 <tr bgcolor="{#clr_content#}">
 		<td bgcolor="{#clr_content_rel#}"><b>{$LNG_BASIC.c4298}:</b></td>
 		<td class="egl_live_td"> <input onBlur="textbox_set_style(this, '{#clr_content#}', '{#clr_content#}', '#FFFFFF');" onFocus="textbox_set_style(this, '{#clr_textbox_border#}', '{#clr_textbox_bgcolor#}', '{#clr_textbox_color#}');" class='egl_live_text' type=text name='cd_monitor' value='{$member_details->cd_monitor|stripslashes}'> </td>
	 </tr>
	 <tr bgcolor="{#clr_content#}">
 		<td bgcolor="{#clr_content_rel#}"><b>{$LNG_BASIC.c4299}:</b></td>
 		<td class="egl_live_td"> <input onBlur="textbox_set_style(this, '{#clr_content#}', '{#clr_content#}', '#FFFFFF');" onFocus="textbox_set_style(this, '{#clr_textbox_border#}', '{#clr_textbox_bgcolor#}', '{#clr_textbox_color#}');" class='egl_live_text' type=text name='cd_connection' value='{$member_details->cd_connection|stripslashes}'> </td>
	 </tr>
	 <tr bgcolor="{#clr_content#}">
 		<td bgcolor="{#clr_content_rel#}"><b>{$LNG_BASIC.c4300}:</b></td>
 		<td class="egl_live_td"> <input onBlur="textbox_set_style(this, '{#clr_content#}', '{#clr_content#}', '#FFFFFF');" onFocus="textbox_set_style(this, '{#clr_textbox_border#}', '{#clr_textbox_bgcolor#}', '{#clr_textbox_color#}');" class='egl_live_text' type=text name='cd_console' value='{$member_details->cd_console|stripslashes}'> </td>
	 </tr>
	 
	 {** Personality **}
	 <tr bgcolor="{#clr_content_border#}">
	 	<td colspan=2><b>{$LNG_BASIC.c4316}:</b></td>
	 </tr>		 
	 <tr bgcolor="{#clr_content#}">
 		<td  bgcolor="{#clr_content_rel#}"><b>{$LNG_BASIC.c4320}:</b></td>
 		<td><select class="egl_select" name="country_id">
 			{section name=country loop=$countries}
 				{if $member_details->country_id == $countries[country]->id }
 					<option selected value="{$countries[country]->id}">{$countries[country]->name}</option>
 				{else}
 					<option value="{$countries[country]->id}">{$countries[country]->name}</option>
 				{/if}
 			{/section}
 			</select>
 		 </td>
 		<td class="egl_live_td"> <input class='egl_checkbox' type=checkbox  name='pubkey_country_id' value='{$member_details->country_id}' {$check_pubkey_country_id}></td>
	 </tr> 	 
	 
	 <tr bgcolor="{#clr_content#}">
 		<td  bgcolor="{#clr_content_rel#}"><b>{$LNG_BASIC.c4321}:</b></td>
 		<td class="egl_live_td"> <input onBlur="textbox_set_style(this, '{#clr_content#}', '{#clr_content#}', '#FFFFFF');" onFocus="textbox_set_style(this, '{#clr_textbox_border#}', '{#clr_textbox_bgcolor#}', '{#clr_textbox_color#}');" class='egl_live_text' type=text   name='city' value='{$member_details->city|stripslashes}' > </td>
 		<td class="egl_live_td"> <input class='egl_checkbox' type=checkbox name='pubkey_city' value='{$member_details->city}' {$check_pubkey_city}></td>
	 </tr>
	 <tr bgcolor="{#clr_content#}">
 		<td  bgcolor="{#clr_content_rel#}"><b>{$LNG_BASIC.c4322}:</b></td>
 		<td class="egl_live_td"> <input onBlur="textbox_set_style(this, '{#clr_content#}', '{#clr_content#}', '#FFFFFF');" onFocus="textbox_set_style(this, '{#clr_textbox_border#}', '{#clr_textbox_bgcolor#}', '{#clr_textbox_color#}');" class='egl_live_text' type=text name='zip_code' value='{$member_details->zip_code|stripslashes}' >	 </td>
 		<td class="egl_live_td"> <input class='egl_checkbox' type=checkbox name='pubkey_zip_code' value='{$member_details->zip_code}' {$check_pubkey_zip_code}></td>
	 </tr>
	 <tr bgcolor="{#clr_content#}">
 		<td bgcolor="{#clr_content_rel#}"><b>{$LNG_BASIC.c4323}:</b></td>
 		<td class="egl_live_td"> <input onBlur="textbox_set_style(this, '{#clr_content#}', '{#clr_content#}', '#FFFFFF');" onFocus="textbox_set_style(this, '{#clr_textbox_border#}', '{#clr_textbox_bgcolor#}', '{#clr_textbox_color#}');" class='egl_live_text' type=text name='street' value='{$member_details->street|stripslashes}' > </td>
 		<td class="egl_live_td"> <input class='egl_checkbox' type=checkbox name='pubkey_street' value='{$member_details->street}' {$check_pubkey_street}></td>
	 </tr>
	 <tr bgcolor="{#clr_content#}">
 		<td bgcolor="{#clr_content_rel#}"><b>{$LNG_BASIC.c4258}:</b></td>
 		<td class="egl_live_td"> <input onBlur="textbox_set_style(this, '{#clr_content#}', '{#clr_content#}', '#FFFFFF');" onFocus="textbox_set_style(this, '{#clr_textbox_border#}', '{#clr_textbox_bgcolor#}', '{#clr_textbox_color#}');" class='egl_live_text' type=text name='birthday' value="{$member_details->birthday|stripslashes}" > <i>(DD.MM.YYYY)</i> </td>
 		<td class="egl_live_td"> <input class='egl_checkbox' type=checkbox name='pubkey_birthday' value='{$member_details->birthday}' {$check_pubkey_birthday}></td>
	 </tr>
	 <tr bgcolor="{#clr_content#}">
 		<td bgcolor="{#clr_content_rel#}"><b>{$LNG_BASIC.c4284}:</b></td>
 		<td class="egl_live_td"> <input onBlur="textbox_set_style(this, '{#clr_content#}', '{#clr_content#}', '#FFFFFF');" onFocus="textbox_set_style(this, '{#clr_textbox_border#}', '{#clr_textbox_bgcolor#}', '{#clr_textbox_color#}');" class='egl_live_text' type=text name='mobilefone' value='{$member_details->mobilefone|stripslashes}' > </td>
 		<td class="egl_live_td"> <input class='egl_checkbox' type=checkbox name='pubkey_mobilefone' value='{$member_details->mobilefone}' {$check_pubkey_mobilefone}></td>
	 </tr>
	 <tr bgcolor="{#clr_content#}">
 		<td bgcolor="{#clr_content_rel#}"><b>{$LNG_BASIC.c4259}:</b></td>
 		<td class="egl_live_td"> <input onBlur="textbox_set_style(this, '{#clr_content#}', '{#clr_content#}', '#FFFFFF');" onFocus="textbox_set_style(this, '{#clr_textbox_border#}', '{#clr_textbox_bgcolor#}', '{#clr_textbox_color#}');" class='egl_live_text' type=text name='job' value='{$member_details->job|stripslashes}' > </td>
 		<td class="egl_live_td"> <input class='egl_checkbox' type=checkbox name='pubkey_job' value='{$member_details->job}' {$check_pubkey_job}></td>
	 </tr>
	 <tr bgcolor="{#clr_content#}">
 		<td bgcolor="{#clr_content_rel#}"><b>{$LNG_BASIC.c4324}:</b></td>
 		<td class="egl_live_td"> <input onBlur="textbox_set_style(this, '{#clr_content#}', '{#clr_content#}', '#FFFFFF');" onFocus="textbox_set_style(this, '{#clr_textbox_border#}', '{#clr_textbox_bgcolor#}', '{#clr_textbox_color#}');" class='egl_live_text' type=text name='hobbies' value='{$member_details->hobbies|stripslashes}' > </td>
 		<td class="egl_live_td"> <input class='egl_checkbox' type=checkbox name='pubkey_hobbies' value='{$member_details->hobbies}' {$check_pubkey_hobbies}></td>
	 </tr>
	 <tr bgcolor="{#clr_content#}">
 		<td valign=top  bgcolor="{#clr_content_rel#}"><b>{$LNG_BASIC.c4285}:</b></td>
 		<td class="egl_live_td"><textarea class="egl_live_textbox" onBlur="textbox_set_style(this, '{#clr_content#}', '{#clr_content#}', '#FFFFFF');" onFocus="textbox_set_style(this, '{#clr_textbox_border#}', '{#clr_textbox_bgcolor#}', '{#clr_textbox_color#}');" cols="60" rows="15" name='description'>{$member_details->description|stripslashes}</textarea> </td>
	 </tr>	 
	 <tr>
	 	<td colspan="3">{include file="devs/hr2.tpl" width="100%"}</td>
	 </tr>
	 <tr>
 		<td  colspan="3" align="center">{include file="buttons/bt_universal.tpl" color=$GLOBAL_COLOR caption=$LNG_BASIC.c1018 link="javascript:document.f.submit();"}</td>
	 </tr>	 	 	 	 	 	 	  
	 </table>
</form>

{/if}