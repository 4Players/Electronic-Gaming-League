<h2>{$LNG_BASIC.c8071} `{$member_data->nick_name|strip_tags|stripslashes}`</h2>
{include file="administration/member/header_menu.tpl"}
{include file="devs/hr2.tpl" width="100%"}
{include file="devs/message.tpl"}

{if !$success }
 <form name="f" action='{$url_file}page={$url_page}&member_id={$member_data->id}&a=change_profile' method=POST> 
	<table border="0" width="100%" cellpadding="4" cellspacing="1" bgcolor="{#clr_content_rel_border#}">
	 <tr>
	 	<td bgcolor="{#clr_content_border#}" colspan="2"></td>
	 	<td bgcolor="{#clr_content_rel_border#}"><b>{$LNG_BASIC.c4311}</b></td>
	 </tr>
	 <tr bgcolor="{#clr_content#}">
 		<td bgcolor="{#clr_content_rel#}"><b>{$LNG_BASIC.c4262}:</b></td>
 		<td> <b>{date timestamp=$member_data_data->created format="%d.%m.%Y / %H:%M"}</b>  </td>
 		<td class="egl_live_td"> <input class='egl_checkbox' type=checkbox name='pubkey_created' value=1 {$check_pubkey_created} ></td>
	 </tr>
	 <tr bgcolor="{#clr_content#}">
 		<td  bgcolor="{#clr_content_rel#}"><b>{$LNG_BASIC.c4273}:</b></td>
 		<td> <b>{date timestamp=$member_data->last_login format="%d.%m.%Y / %H:%M"}</b>  </td>
 		<td class="egl_live_td"> <input class='egl_checkbox' type=checkbox name='pubkey_last_login' value=1 {$check_pubkey_last_login} ></td>
	 </tr>
	 <tr bgcolor="{#clr_content#}">
 		<td bgcolor="{#clr_content_rel#}"><b>{$LNG_BASIC.c1226}:</b></td>
 		<td>
 			{if $member_data->activation_time != 0}
 				{date timestamp=$member_data->activation_time format="%d.%m.%Y %H:%M"}
 				(<A href="{$url_file}page={$url_page}&member_id={$member_data->id}&a=deactivate"><font color="red"><b>{$LNG_BASIC.c1224}</b></font></a>)
 			{else}
				(<A href="{$url_file}page={$url_page}&member_id={$member_data->id}&a=activate"><font color="green"><b>{$LNG_BASIC.c1225}</b></font></a>)
 			{/if}
 		</td>
	 </tr>
	 <tr bgcolor="{#clr_content#}">
 		<td bgcolor="{#clr_content_rel#}"><b>{$LNG_BASIC.c4250}:</b></td>
 		<td> <b>{$member_data->id}</b> </td>
	 </tr>
	 <tr bgcolor="{#clr_content#}">
 		<td bgcolor="{#clr_content_rel#}"><b>{$LNG_BASIC.c1003}:</b></td>
 		<td class="egl_live_td"> <input onBlur="textbox_set_style(this, '{#clr_content#}', '{#clr_content#}', '#FFFFFF'); if(this.value=='') this.value='{literal}{NO CHANGES}{/literal}'; " onFocus="textbox_set_style(this, '{#clr_textbox_border#}', '{#clr_textbox_bgcolor#}', '{#clr_textbox_color#}');" class='egl_live_text' type=text name='password' value='{literal}{NO CHANGES}{/literal}' onclick="if( this.value == '{literal}{NO CHANGES}{/literal}')this.value=''"/> </td>
	 </tr>	 	 
	 <tr bgcolor="{#clr_content#}">
 		<td bgcolor="{#clr_content_rel#}"><b>{$LNG_BASIC.c4253}:</b></td>
 		<td class="egl_live_td"> <input onBlur="textbox_set_style(this, '{#clr_content#}', '{#clr_content#}', '#FFFFFF');" onFocus="textbox_set_style(this, '{#clr_textbox_border#}', '{#clr_textbox_bgcolor#}', '{#clr_textbox_color#}');" class='egl_live_text' type=text name='first_name' value='{$member_data->first_name|stripslashes}'> </td>
 		<td class="egl_live_td"> <input class='egl_checkbox' type=checkbox name='pubkey_first_name' value=1 {$check_pubkey_first_name} ></td>
	 </tr>
	 <tr bgcolor="{#clr_content#}">
 		<td  bgcolor="{#clr_content_rel#}"><b>{$LNG_BASIC.c4254}:</b></td>
 		<td class="egl_live_td"> <input onBlur="textbox_set_style(this, '{#clr_content#}', '{#clr_content#}', '#FFFFFF');" onFocus="textbox_set_style(this, '{#clr_textbox_border#}', '{#clr_textbox_bgcolor#}', '{#clr_textbox_color#}');" class='egl_live_text' type=text name='next_name' value='{$member_data->next_name|stripslashes}'> </td>
 		<td class="egl_live_td"> <input class='egl_checkbox' type=checkbox name='pubkey_next_name' value=1 {$check_pubkey_next_name} ></td>
	 </tr>
	 <tr bgcolor="{#clr_content#}">
 		<td  bgcolor="{#clr_content_rel#}"><b>{$LNG_BASIC.c1020}:</b></td>
 		<td class="egl_live_td"> <input onBlur="textbox_set_style(this, '{#clr_content#}', '{#clr_content#}', '#FFFFFF');" onFocus="textbox_set_style(this, '{#clr_textbox_border#}', '{#clr_textbox_bgcolor#}', '{#clr_textbox_color#}');" class='egl_live_text' type=text name='nick_name' value='{$member_data->nick_name|stripslashes}'> </td>
	 </tr>
	 <tr bgcolor="{#clr_content#}">
 		<td bgcolor="{#clr_content_rel#}"><b>{$LNG_BASIC.c4261}:</b></td>
 		<td> <select class="egl_select" name="sex">
 		
	 			{*male/männlich selektiert ?*}
	 			{if $member_data->sex == "M" }
	 				{assign var="male_select" value="selected"} 		
	 			{/if}
	 			{*female/weilich selektiert ?*}
	 			{if $member_data->sex == "F" }
	 				{assign var="female_select" value="selected"} 		
	 			{/if}
 		
 				<option value="M" {$male_select}>{$LNG_BASIC.c4264}</option>
 				<option value="F" {$female_select}>{$LNG_BASIC.c4265}</option>
 			</select>
 			 </td>
	 </tr>
	 <tr bgcolor="{#clr_content#}">
 		<td bgcolor="{#clr_content_rel#}"><b>{$LNG_BASIC.c4301}:</b></td>
 		<td> <select class="egl_select" name="invisible" style="width:200;">
 		
 				<option value="0">{$LNG_BASIC.c1401}</option>
 				{if $member_data->invisible == 1}
 					<option value="1" selected>{$LNG_BASIC.c1400}</option>
 				{else}
 					<option value="1">{$LNG_BASIC.c1400}</option>
 				{/if}
 				
 			</select>
 			 </td>
	 </tr>
	 {** KONTAKT  **}
	 <tr bgcolor="{#clr_content_border#}">
	 	<td colspan=2><b>{$LNG_BASIC.c4266}</b></td>
	 </tr>
	 <tr bgcolor="{#clr_content#}">
 		<td  bgcolor="{#clr_content_rel#}"><b>{$LNG_BASIC.c4267}:</b></td>
 		<td> {$member_data->email} </td>
 		<td class="egl_live_td"> <input onBlur="textbox_set_style(this, '{#clr_content#}', '{#clr_content#}', '#FFFFFF');" onFocus="textbox_set_style(this, '{#clr_textbox_border#}', '{#clr_textbox_bgcolor#}', '{#clr_textbox_color#}');" class='egl_checkbox' type=checkbox name='pubkey_email' value=1 {$check_pubkey_email}></td>
	 </tr>
	 <tr bgcolor="{#clr_content#}">
 		<td  bgcolor="{#clr_content_rel#}"><b>{$LNG_BASIC.c4282}:</b></td>
 		<td class="egl_live_td"> <input onBlur="textbox_set_style(this, '{#clr_content#}', '{#clr_content#}', '#FFFFFF');" onFocus="textbox_set_style(this, '{#clr_textbox_border#}', '{#clr_textbox_bgcolor#}', '{#clr_textbox_color#}');" class='egl_live_text' type=text name='icq' value='{$member_data->icq|stripslashes}'> </td>
 		<td class="egl_live_td"> <input class='egl_checkbox' type=checkbox name='pubkey_icq' value=1 {$check_pubkey_icq} ></td>
	 </tr>
	 <tr bgcolor="{#clr_content#}">
 		<td  bgcolor="{#clr_content_rel#}"><b>{$LNG_BASIC.c4281}:</b></td>
 		<td class="egl_live_td"> <input onBlur="textbox_set_style(this, '{#clr_content#}', '{#clr_content#}', '#FFFFFF');" onFocus="textbox_set_style(this, '{#clr_textbox_border#}', '{#clr_textbox_bgcolor#}', '{#clr_textbox_color#}');" class='egl_live_text' type=text name='msn' value='{$member_data->msn|stripslashes}'> </td>
 		<td class="egl_live_td"> <input class='egl_checkbox' type=checkbox name='pubkey_msn' value=1 {$check_pubkey_msn}></td>
	 </tr>
	 <tr bgcolor="{#clr_content#}">
 		<td  bgcolor="{#clr_content_rel#}"><b>{$LNG_BASIC.c4302}:</b></td>
 		<td class="egl_live_td"> <input onBlur="textbox_set_style(this, '{#clr_content#}', '{#clr_content#}', '#FFFFFF');" onFocus="textbox_set_style(this, '{#clr_textbox_border#}', '{#clr_textbox_bgcolor#}', '{#clr_textbox_color#}');" class='egl_live_text' type=text name='am' value='{$member_data->am|stripslashes}'> </td>
 		<td class="egl_live_td"> <input class='egl_checkbox' type=checkbox name='pubkey_am' value=1 {$check_pubkey_am}></td>
	 </tr>
	 <tr bgcolor="{#clr_content#}">
 		<td  bgcolor="{#clr_content_rel#}"><b>{$LNG_BASIC.c4283}:</b></td>
 		<td class="egl_live_td"> <input onBlur="textbox_set_style(this, '{#clr_content#}', '{#clr_content#}', '#FFFFFF');" onFocus="textbox_set_style(this, '{#clr_textbox_border#}', '{#clr_textbox_bgcolor#}', '{#clr_textbox_color#}');" class='egl_live_text' type=text name='irc_nick' value='{$member_data->irc_nick|stripslashes}'> </td>
 		<td class="egl_live_td"> <input class='egl_checkbox' type=checkbox name='pubkey_irc_nick' value=1 {$check_pubkey_irc_nick}></td>
	 </tr>
	 
	 {** CLAN **}
	 <tr bgcolor="{#clr_content_border#}">
	 	<td colspan=2><b>Clan</b></td>
	 </tr>	
	 <tr bgcolor="{#clr_content#}">
 		<td  bgcolor="{#clr_content_rel#}"><b>{$LNG_BASIC.c4721}:</b></td>
 		<td class="egl_live_td"> <input onBlur="textbox_set_style(this, '{#clr_content#}', '{#clr_content#}', '#FFFFFF');" onFocus="textbox_set_style(this, '{#clr_textbox_border#}', '{#clr_textbox_bgcolor#}', '{#clr_textbox_color#}');" class='egl_live_text' type=text name='clan_name' value='{$member_data->clan_name|stripslashes}'> </td>
 		<td class="egl_live_td"> <input class='egl_checkbox' type=checkbox name='pubkey_clan_name' value=1 {$check_pubkey_clan_name}></td>
	 </tr>
	 <tr bgcolor="{#clr_content#}">
 		<td  bgcolor="{#clr_content_rel#}"><b>{$LNG_BASIC.c4722}:</b></td>
 		<td class="egl_live_td"> <input onBlur="textbox_set_style(this, '{#clr_content#}', '{#clr_content#}', '#FFFFFF');" onFocus="textbox_set_style(this, '{#clr_textbox_border#}', '{#clr_textbox_bgcolor#}', '{#clr_textbox_color#}');" class='egl_live_text' type=text name='clan_tag' value='{$member_data->clan_tag|stripslashes}' > </td>
 		<td class="egl_live_td"> <input class='egl_checkbox' type=checkbox name='pubkey_clan_tag' value=1 {$check_pubkey_clan_tag}></td>
	 </tr>
	 <tr bgcolor="{#clr_content#}">
 		<td  bgcolor="{#clr_content_rel#}"><b>{LNG_BASIC.c5201}:</b></td>
 		<td class="egl_live_td"> <input onBlur="textbox_set_style(this, '{#clr_content#}', '{#clr_content#}', '#FFFFFF');" onFocus="textbox_set_style(this, '{#clr_textbox_border#}', '{#clr_textbox_bgcolor#}', '{#clr_textbox_color#}');" class='egl_live_text' type=text name='clan_hp' value='{$member_data->clan_hp|stripslashes}' > </td>
 		<td class="egl_live_td"> <input class='egl_checkbox' type=checkbox name='pubkey_clan_hp' value=1 {$check_pubkey_clan_hp}></td>
	 </tr>
	 <tr bgcolor="{#clr_content#}">
 		<td  bgcolor="{#clr_content_rel#}"><b>{$LNG_BASIC.c4315}:</b></td>
 		<td class="egl_live_td"> <input onBlur="textbox_set_style(this, '{#clr_content#}', '{#clr_content#}', '#FFFFFF');" onFocus="textbox_set_style(this, '{#clr_textbox_border#}', '{#clr_textbox_bgcolor#}', '{#clr_textbox_color#}');" class='egl_live_text' type=text name='clan_irc' value='{$member_data->clan_irc|stripslashes}' > </td>
 		<td class="egl_live_td"> <input class='egl_checkbox' type=checkbox name='pubkey_clan_irc' value=1 {$check_pubkey_clan_irc}></td>
	 </tr>
	 
	 
	 {** COMPUTER **}
	 <tr bgcolor="{#clr_content_border#}">
	 	<td colspan=2><b>Computer</b></td>
	 </tr>	
	 <tr bgcolor="{#clr_content#}">
 		<td  bgcolor="{#clr_content_rel#}"><b>{$LNG_BASIC.c4289}:</b></td>
 		<td class="egl_live_td"> <input onBlur="textbox_set_style(this, '{#clr_content#}', '{#clr_content#}', '#FFFFFF');" onFocus="textbox_set_style(this, '{#clr_textbox_border#}', '{#clr_textbox_bgcolor#}', '{#clr_textbox_color#}');" class='egl_live_text' type=text name='cd_cpu' value='{$member_data->cd_cpu|stripslashes}'> </td>
	 </tr>
	 <tr bgcolor="{#clr_content#}">
 		<td  bgcolor="{#clr_content_rel#}"><b>{$LNG_BASIC.c4290}:</b></td>
 		<td class="egl_live_td"> <input onBlur="textbox_set_style(this, '{#clr_content#}', '{#clr_content#}', '#FFFFFF');" onFocus="textbox_set_style(this, '{#clr_textbox_border#}', '{#clr_textbox_bgcolor#}', '{#clr_textbox_color#}');" class='egl_live_text' type=text name='cd_mainboard' value='{$member_data->cd_mainboard|stripslashes}'> </td>
	 </tr>
	 <tr bgcolor="{#clr_content#}">
 		<td  bgcolor="{#clr_content_rel#}"><b>{$LNG_BASIC.c4291}:</b></td>
 		<td class="egl_live_td"> <input onBlur="textbox_set_style(this, '{#clr_content#}', '{#clr_content#}', '#FFFFFF');" onFocus="textbox_set_style(this, '{#clr_textbox_border#}', '{#clr_textbox_bgcolor#}', '{#clr_textbox_color#}');" class='egl_live_text' type=text name='cd_graphiccard' value='{$member_data->cd_graphiccard|stripslashes}'> </td>
	 </tr>
	 <tr bgcolor="{#clr_content#}">
 		<td  bgcolor="{#clr_content_rel#}"><b>{$LNG_BASIC.c4292}:</b></td>
 		<td class="egl_live_td"> <input onBlur="textbox_set_style(this, '{#clr_content#}', '{#clr_content#}', '#FFFFFF');" onFocus="textbox_set_style(this, '{#clr_textbox_border#}', '{#clr_textbox_bgcolor#}', '{#clr_textbox_color#}');" class='egl_live_text' type=text name='cd_soundcard' value='{$member_data->cd_soundcard|stripslashes}'> </td>
	 </tr>
	 <tr bgcolor="{#clr_content#}">
 		<td  bgcolor="{#clr_content_rel#}"><b>{$LNG_BASIC.c4293}:</b></td>
 		<td class="egl_live_td"> <input onBlur="textbox_set_style(this, '{#clr_content#}', '{#clr_content#}', '#FFFFFF');" onFocus="textbox_set_style(this, '{#clr_textbox_border#}', '{#clr_textbox_bgcolor#}', '{#clr_textbox_color#}');" class='egl_live_text' type=text name='cd_mouse' value='{$member_data->cd_mouse|stripslashes}'> </td>
	 </tr>
	 <tr bgcolor="{#clr_content#}">
 		<td  bgcolor="{#clr_content_rel#}"><b>{$LNG_BASIC.c4294}:</b></td>
 		<td class="egl_live_td"> <input onBlur="textbox_set_style(this, '{#clr_content#}', '{#clr_content#}', '#FFFFFF');" onFocus="textbox_set_style(this, '{#clr_textbox_border#}', '{#clr_textbox_bgcolor#}', '{#clr_textbox_color#}');" class='egl_live_text' type=text name='cd_mousepad' value='{$member_data->cd_mousepad|stripslashes}'> </td>
	 </tr>
	 <tr bgcolor="{#clr_content#}">
 		<td  bgcolor="{#clr_content_rel#}"><b>{$LNG_BASIC.c4295}:</b></td>
 		<td class="egl_live_td"> <input onBlur="textbox_set_style(this, '{#clr_content#}', '{#clr_content#}', '#FFFFFF');" onFocus="textbox_set_style(this, '{#clr_textbox_border#}', '{#clr_textbox_bgcolor#}', '{#clr_textbox_color#}');" class='egl_live_text' type=text name='cd_keyboard' value='{$member_data->cd_keyboard|stripslashes}'> </td>
	 </tr>
	 <tr bgcolor="{#clr_content#}">
 		<td bgcolor="{#clr_content_rel#}"><b>{$LNG_BASIC.c4296}:</b></td>
 		<td class="egl_live_td"> <input onBlur="textbox_set_style(this, '{#clr_content#}', '{#clr_content#}', '#FFFFFF');" onFocus="textbox_set_style(this, '{#clr_textbox_border#}', '{#clr_textbox_bgcolor#}', '{#clr_textbox_color#}');" class='egl_live_text' type=text name='cd_memory' value='{$member_data->cd_memory|stripslashes}'> </td>
	 </tr>
	 <tr bgcolor="{#clr_content#}">
 		<td bgcolor="{#clr_content_rel#}"><b>{$LNG_BASIC.c4297}:</b></td>
 		<td class="egl_live_td"> <input onBlur="textbox_set_style(this, '{#clr_content#}', '{#clr_content#}', '#FFFFFF');" onFocus="textbox_set_style(this, '{#clr_textbox_border#}', '{#clr_textbox_bgcolor#}', '{#clr_textbox_color#}');" class='egl_live_text' type=text name='cd_harddisk' value='{$member_data->cd_harddisk|stripslashes}'> </td>
	 </tr>
	 <tr bgcolor="{#clr_content#}">
 		<td bgcolor="{#clr_content_rel#}"><b>{$LNG_BASIC.c4298}:</b></td>
 		<td class="egl_live_td"> <input onBlur="textbox_set_style(this, '{#clr_content#}', '{#clr_content#}', '#FFFFFF');" onFocus="textbox_set_style(this, '{#clr_textbox_border#}', '{#clr_textbox_bgcolor#}', '{#clr_textbox_color#}');" class='egl_live_text' type=text name='cd_monitor' value='{$member_data->cd_monitor|stripslashes}'> </td>
	 </tr>
	 <tr bgcolor="{#clr_content#}">
 		<td bgcolor="{#clr_content_rel#}"><b>{$LNG_BASIC.c4299}:</b></td>
 		<td class="egl_live_td"> <input onBlur="textbox_set_style(this, '{#clr_content#}', '{#clr_content#}', '#FFFFFF');" onFocus="textbox_set_style(this, '{#clr_textbox_border#}', '{#clr_textbox_bgcolor#}', '{#clr_textbox_color#}');" class='egl_live_text' type=text name='cd_connection' value='{$member_data->cd_connection|stripslashes}'> </td>
	 </tr>
	 <tr bgcolor="{#clr_content#}">
 		<td bgcolor="{#clr_content_rel#}"><b>{$LNG_BASIC.c4300}:</b></td>
 		<td class="egl_live_td"> <input onBlur="textbox_set_style(this, '{#clr_content#}', '{#clr_content#}', '#FFFFFF');" onFocus="textbox_set_style(this, '{#clr_textbox_border#}', '{#clr_textbox_bgcolor#}', '{#clr_textbox_color#}');" class='egl_live_text' type=text name='cd_console' value='{$member_data->cd_console|stripslashes}'> </td>
	 </tr>
	 
	 {** Personality **}
	 <tr bgcolor="{#clr_content_border#}">
	 	<td colspan=2><b>{$LNG_BASIC.c4316}:</b></td>
	 </tr>		 
	 <tr bgcolor="{#clr_content#}">
 		<td  bgcolor="{#clr_content_rel#}"><b>{$LNG_BASIC.c4320}:</b></td>
 		<td><select class="egl_select" name="country_id">
 			{section name=country loop=$countries}
 				{if $member_data->country_id == $countries[country]->id }
 					<option selected value="{$countries[country]->id}">{$countries[country]->name}</option>
 				{else}
 					<option value="{$countries[country]->id}">{$countries[country]->name}</option>
 				{/if}
 			{/section}
 			</select>
 		 </td>
 		<td class="egl_live_td"> <input class='egl_checkbox' type=checkbox  name='pubkey_country' value='{$member_data->country}' {$check_pubkey_country}></td>
	 </tr> 	 
	 
	 <tr bgcolor="{#clr_content#}">
 		<td  bgcolor="{#clr_content_rel#}"><b>{$LNG_BASIC.c4321}:</b></td>
 		<td class="egl_live_td"> <input onBlur="textbox_set_style(this, '{#clr_content#}', '{#clr_content#}', '#FFFFFF');" onFocus="textbox_set_style(this, '{#clr_textbox_border#}', '{#clr_textbox_bgcolor#}', '{#clr_textbox_color#}');" class='egl_live_text' type=text   name='city' value='{$member_data->city|stripslashes}' > </td>
 		<td class="egl_live_td"> <input class='egl_checkbox' type=checkbox name='pubkey_city' value='{$member_data->city}' {$check_pubkey_city}></td>
	 </tr>
	 <tr bgcolor="{#clr_content#}">
 		<td  bgcolor="{#clr_content_rel#}"><b>{$LNG_BASIC.c4322}:</b></td>
 		<td class="egl_live_td"> <input onBlur="textbox_set_style(this, '{#clr_content#}', '{#clr_content#}', '#FFFFFF');" onFocus="textbox_set_style(this, '{#clr_textbox_border#}', '{#clr_textbox_bgcolor#}', '{#clr_textbox_color#}');" class='egl_live_text' type=text name='zip_code' value='{$member_data->zip_code|stripslashes}' >	 </td>
 		<td class="egl_live_td"> <input class='egl_checkbox' type=checkbox name='pubkey_zip_code' value='{$member_data->zip_code}' {$check_pubkey_zip_code}></td>
	 </tr>
	 <tr bgcolor="{#clr_content#}">
 		<td bgcolor="{#clr_content_rel#}"><b>{$LNG_BASIC.c4323}:</b></td>
 		<td class="egl_live_td"> <input onBlur="textbox_set_style(this, '{#clr_content#}', '{#clr_content#}', '#FFFFFF');" onFocus="textbox_set_style(this, '{#clr_textbox_border#}', '{#clr_textbox_bgcolor#}', '{#clr_textbox_color#}');" class='egl_live_text' type=text name='street' value='{$member_data->street|stripslashes}' > </td>
 		<td class="egl_live_td"> <input class='egl_checkbox' type=checkbox name='pubkey_street' value='{$member_data->street}' {$check_pubkey_street}></td>
	 </tr>
	 <tr bgcolor="{#clr_content#}">
 		<td bgcolor="{#clr_content_rel#}"><b>{$LNG_BASIC.c4258}:</b></td>
 		<td class="egl_live_td"> <input onBlur="textbox_set_style(this, '{#clr_content#}', '{#clr_content#}', '#FFFFFF');" onFocus="textbox_set_style(this, '{#clr_textbox_border#}', '{#clr_textbox_bgcolor#}', '{#clr_textbox_color#}');" class='egl_live_text' type=text name='birthday' value="{$member_data->birthday|stripslashes}" > <i>(DD.MM.YYYY)</i> </td>
 		<td class="egl_live_td"> <input class='egl_checkbox' type=checkbox name='pubkey_birthday' value='{$member_data->birthday}' {$check_pubkey_birthday}></td>
	 </tr>
	 <tr bgcolor="{#clr_content#}">
 		<td bgcolor="{#clr_content_rel#}"><b>{$LNG_BASIC.c4284}:</b></td>
 		<td class="egl_live_td"> <input onBlur="textbox_set_style(this, '{#clr_content#}', '{#clr_content#}', '#FFFFFF');" onFocus="textbox_set_style(this, '{#clr_textbox_border#}', '{#clr_textbox_bgcolor#}', '{#clr_textbox_color#}');" class='egl_live_text' type=text name='mobilefone' value='{$member_data->mobilefone|stripslashes}' > </td>
 		<td class="egl_live_td"> <input class='egl_checkbox' type=checkbox name='pubkey_mobilefone' value='{$member_data->mobilefone}' {$check_pubkey_mobilefone}></td>
	 </tr>
	 <tr bgcolor="{#clr_content#}">
 		<td bgcolor="{#clr_content_rel#}"><b>{$LNG_BASIC.c4259}:</b></td>
 		<td class="egl_live_td"> <input onBlur="textbox_set_style(this, '{#clr_content#}', '{#clr_content#}', '#FFFFFF');" onFocus="textbox_set_style(this, '{#clr_textbox_border#}', '{#clr_textbox_bgcolor#}', '{#clr_textbox_color#}');" class='egl_live_text' type=text name='job' value='{$member_data->job|stripslashes}' > </td>
 		<td class="egl_live_td"> <input class='egl_checkbox' type=checkbox name='pubkey_job' value='{$member_data->job}' {$check_pubkey_job}></td>
	 </tr>
	 <tr bgcolor="{#clr_content#}">
 		<td bgcolor="{#clr_content_rel#}"><b>{$LNG_BASIC.c4324}:</b></td>
 		<td class="egl_live_td"> <input onBlur="textbox_set_style(this, '{#clr_content#}', '{#clr_content#}', '#FFFFFF');" onFocus="textbox_set_style(this, '{#clr_textbox_border#}', '{#clr_textbox_bgcolor#}', '{#clr_textbox_color#}');" class='egl_live_text' type=text name='hobbies' value='{$member_data->hobbies|stripslashes}' > </td>
 		<td class="egl_live_td"> <input class='egl_checkbox' type=checkbox name='pubkey_hobbies' value='{$member_data->hobbies}' {$check_pubkey_hobbies}></td>
	 </tr>
	 <tr bgcolor="{#clr_content#}">
 		<td valign=top  bgcolor="{#clr_content_rel#}"><b>{$LNG_BASIC.c4285}:</b></td>
 		<td class="egl_live_td"><textarea class="egl_live_textbox" onBlur="textbox_set_style(this, '{#clr_content#}', '{#clr_content#}', '#FFFFFF');" onFocus="textbox_set_style(this, '{#clr_textbox_border#}', '{#clr_textbox_bgcolor#}', '{#clr_textbox_color#}');" cols="60" rows="15" name='description'>{$member_data->description|stripslashes}</textarea> </td>
	 </tr>
	 <tr bgcolor="{#clr_content_rel#}">
 		<td> </td>
 		<td>{include file="buttons/bt_universal.tpl" color=$GLOBAL_COLOR caption=$LNG_BASIC.c1018 link="javascript:document.f.submit();" } </td>
	 </tr>	 	 	 	 	 	 	  
	 </table>
</form>

{/if}