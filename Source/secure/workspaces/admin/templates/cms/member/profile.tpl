<h2>Profil `{$member_data->nick_name|strip_tags|stripslashes}`</h2>
<table>
<tr>
	<td>{include file="buttons/bt_universal.tpl" caption="Zentrale" link="`$url_file`page=cms.member.central&member_id=`$member_data->id`"}</td>
	<td>{include file="buttons/bt_universal.tpl" caption="Profil" link="`$url_file`page=cms.member.profile&member_id=`$member_data->id`"}</td>
	<td>{include file="buttons/bt_universal.tpl" caption="GameAccounts" link="`$url_file`page=cms.member.gameaccounts&member_id=`$member_data->id`"}</td>
	<td>{include file="buttons/bt_universal.tpl" caption="History" link="`$url_file`page=cms.member.history&member_id=`$member_data->id`"}</td>
	<td>{include file="buttons/bt_universal.tpl" caption="Adminrechte" link="`$url_file`page=cms.admin.central&member_id=`$member_data->id`"}</td>
</tr>
<tr>
	<td>{include file="buttons/bt_universal.tpl" caption="Löschen" link="`$url_file`page=cms.member.delete&member_id=`$member_data->id`"}</td>
</tr>
</table>
<hr size="1"/>


{include file="etc/message.tpl"}
{if $success}
{else}

{*DARF NICHT ENTFERNT WERDEN !!*}
 <form name="f" action="{$url_file}page={$url_page}&member_id={$member_data->id}&a=change_profile" method="POST"> 
	<table border="0" width="800" cellpadding="5" cellspacing="1" bgcolor="{#clr_content_rel_border#}">
	 <tr>
	 	<td bgcolor="{#clr_content_rel#}" colspan="2"><b>Account</b></td>
	 	<td bgcolor="{#clr_content_rel#}"><b>Öffentlich</b></td>
	 </tr>
	 <tr bgcolor="{#clr_content#}">
 		<td><b>Registriert seit:</b></td>
 		<td> {date timestamp=$member_data->created format="%d.%m.%Y %H:%M"}  </td>
 		<td> <input class='egl_checkbox' type=checkbox name='pubkey_created' value=1 {$check_pubkey_created} /></td>
	 </tr>
	 <tr bgcolor="{#clr_content#}">
 		<td><b>Letzer Login:</td>
 		<td> {date timestamp=$member_data->last_login format="%d.%m.%Y %H:%M"}  </td>
 		<td> <input class='egl_checkbox' type=checkbox name='pubkey_last_login' value=1 {$check_pubkey_last_login}/></td>
	 </tr>
	 <tr bgcolor="{#clr_content#}">
 		<td><b>Freigeschaltet am:</td>
 		<td>
 			{if $member_data->activation_time != 0}
 				{date timestamp=$member_data->activation_time format="%d.%m.%Y %H:%M"}
 				(<A href="{$url_file}page={$url_page}&member_id={$member_data->id}&a=deactivate"><font color="red"><b>zurücksetzen</b></font></a>)
 			{else}
				(<A href="{$url_file}page={$url_page}&member_id={$member_data->id}&a=activate"><font color="green"><b>freischalten</b></font></a>)
 			{/if}
 		</td>
	 </tr>
	 <tr bgcolor="{#clr_content#}">
 		<td><b>ID:</b></td>
 		<td> {$member_data->id} </td>
	 </tr>
	 <tr bgcolor="{#clr_content#}">
 		<td><b>Passwort:</b></td>
 		<td> <input class="egl_text" type="text"size="40" value="" name="password"/><br><i>(Bei Eingabe ändert sich das Passwort!)</i></td>
	 </tr>	 	 
	 <tr bgcolor="{#clr_content#}">
 		<td><b>Vorname:</b></td>
 		<td> <input class='egl_text' type="text"size="40" name='first_name' value='{$member_data->first_name|strip_tags|stripslashes}'/> </td>
 		<td> <input class='egl_checkbox' type=checkbox name='pubkey_first_name' value=1 {$check_pubkey_first_name} /></td>
	 </tr>
	 <tr bgcolor="{#clr_content#}">
 		<td><b>Nachname:</b></td>
 		<td> <input class='egl_text' type="text"size="40" name='next_name' value='{$member_data->next_name|strip_tags|stripslashes}'/> </td>
 		<td> <input class='egl_checkbox' type=checkbox name='pubkey_next_name' value=1 {$check_pubkey_next_name} /></td>
	 </tr>
	 <tr bgcolor="{#clr_content#}">
 		<td><b>Nick Name:</b></td>
 		<td bgcolor="{$clr_no_doubleitem_nick_name}"> 
 			<input type=hidden name="no_doubleitem_nick_name" value="1"/>
 			<input class='egl_text' type="text"size="40" name='nick_name' value='{$member_data->nick_name|strip_tags|stripslashes}'/> </td>
	 </tr>
	 <tr bgcolor="{#clr_content#}">
 		<td><b>Geschlecht:</b></td>
 		<td> <select style="width:50;" class="egl_select" name="sex">
 		
	 			{*male/männlich selektiert ?*}
	 			{if $member_data->sex == "M" }
	 				{assign var="male_select" value="selected"} 		
	 			{/if}
	 			{*female/weilich selektiert ?*}
	 			{if $member_data->sex == "F" }
	 				{assign var="female_select" value="selected"} 		
	 			{/if}
 		
 				<option value="M" {$male_select}>M</option>
 				<option value="F" {$female_select}>F</option>
 			</select>
 			 </td>
	 </tr>
	 <tr bgcolor="{#clr_content#}">
 		<td ><b>Invisible Mode:</b></td>
 		<td> <select class='egl_select' name='invisible' style="width:200;">
 		
		
 				<option value='0'>Deaktiviert</option>
 				{if $member_data->invisible == 1}
 					<option value='1' selected>Aktiviert</option>
 				{else}
 					<option value='1'>Aktiviert</option>
 				{/if}
 				
 			</select>
 			 </td>
	 </tr>
	 
	 <!-- KONTAKT  -->
	 <tr bgcolor="{#clr_content_rel#}">
	 	<td colspan=2><b>Kontakt</b></td>
	 </tr>
	 <tr bgcolor="{#clr_content#}">
 		<td><b>E-Mail:</b></td>
 		<td bgcolor="{$clr_no_doubleitem_email}"> 
 			<input type=hidden name="no_doubleitem_email" value="1"/>
 			 <input type="text" size="40" class="egl_text" name="email" value="{$member_data->email|strip_tags|stripslashes}"/>
 		 </td>
 		<td> <input class='egl_checkbox' type=checkbox name='pubkey_email' value=1 {$check_pubkey_email} /></td>
	 </tr>
	 <tr bgcolor="{#clr_content#}">
 		<td><b>ICQ:</b></td>
 		<td> <input class='egl_text' type="text"size="40" name='icq' value='{$member_data->icq|strip_tags|stripslashes}' /> </td>
 		<td> <input class='egl_checkbox' type=checkbox name='pubkey_icq' value=1 {$check_pubkey_icq} /></td>
	 </tr>
	 <tr bgcolor="{#clr_content#}">
 		<td><b>MSN:</b></td>
 		<td> <input class='egl_text' type="text"size="40" name='msn' value='{$member_data->msn|strip_tags|stripslashes}' /> </td>
 		<td> <input class='egl_checkbox' type=checkbox name='pubkey_msn' value=1 {$check_pubkey_msn} /></td>
	 </tr>
	 <tr bgcolor="{#clr_content#}">
 		<td><b>AM:</b></td>
 		<td> <input class='egl_text' type="text"size="40" name='am' value='{$member_data->am|strip_tags|stripslashes}' /> </td>
 		<td> <input class='egl_checkbox' type=checkbox name='pubkey_am' value=1 {$check_pubkey_am} /></td>
	 </tr>
	 <tr bgcolor="{#clr_content#}">
 		<td><b>IRC-Nick:</b></td>
 		<td> <input class='egl_text' type="text"size="40" name='irc_nick' value='{$member_data->irc_nick|strip_tags|stripslashes}' /> </td>
 		<td> <input class='egl_checkbox' type=checkbox name='pubkey_irc_nick' value=1 {$check_pubkey_irc_nick} /></td>
	 </tr>
	 
	 <!-- CLAN -->
	 <tr bgcolor="{#clr_content_rel#}">
	 	<td colspan=2><b>Clan</b></td>
	 </tr>	
	 <tr bgcolor="{#clr_content#}">
 		<td><b>Clan-Name:</b></td>
 		<td> <input class='egl_text' type="text"size="40" name='clan_name' value='{$member_data->clan_name|strip_tags|stripslashes}' /> </td>
 		<td> <input class='egl_checkbox' type=checkbox name='pubkey_clan_name' value=1 {$check_pubkey_clan_name} /></td>
	 </tr>
	 <tr bgcolor="{#clr_content#}">
 		<td><b>Clan-Kï¿½rzel:</b></td>
 		<td> <input class='egl_text' type="text"size="40" name='clan_tag' value='{$member_data->clan_tag|strip_tags|stripslashes}' /> </td>
 		<td> <input class='egl_checkbox' type=checkbox name='pubkey_clan_tag' value=1 {$check_pubkey_clan_tag} /></td>
	 </tr>
	 <tr bgcolor="{#clr_content#}">
 		<td><b>Clan-Homepage:</b></td>
 		<td> <input class='egl_text' type="text"size="40" name='clan_hp' value='{$member_data->clan_hp|strip_tags|stripslashes}' /> </td>
 		<td> <input class='egl_checkbox' type=checkbox name='pubkey_clan_hp' value=1 {$check_pubkey_clan_hp} /></td>
	 </tr>
	 <tr bgcolor="{#clr_content#}">
 		<td><b>Clan-IRC:</b></td>
 		<td><input class='egl_text' type="text"size="40" name='clan_irc' value='{$member_data->clan_irc|strip_tags|stripslashes}' /> </td>
 		<td> <input class='egl_checkbox' type=checkbox name='pubkey_clan_irc' value=1 {$check_pubkey_clan_irc} /></td>
	 </tr>
	 
	 
	 <!-- COMPUTER -->
	 <tr bgcolor="{#clr_content_rel#}">
	 	<td colspan=2><b>Computer</b></td>
	 </tr>	
	 <tr bgcolor="{#clr_content#}">
 		<td><b>CPU:</b></td>
 		<td><input class='egl_text' type="text"size="40" name='cd_cpu' value='{$member_data->cd_cpu|strip_tags|stripslashes}' /> </td>
	 </tr>
	 <tr bgcolor="{#clr_content#}">
 		<td><b>Mainboard:</b></td>
 		<td><input class='egl_text' type="text"size="40" name='cd_mainboard' value='{$member_data->cd_mainboard|strip_tags|stripslashes}' /> </td>
	 </tr>
	 <tr bgcolor="{#clr_content#}">
 		<td><b>Grafikkarte:</b></td>
 		<td><input class='egl_text' type="text"size="40" name='cd_graphiccard' value='{$member_data->cd_graphiccard|strip_tags|stripslashes}' /> </td>
	 </tr>
	 <tr bgcolor="{#clr_content#}">
 		<td><b>Soundkarte:</b></td>
 		<td><input class='egl_text' type="text"size="40" name='cd_soundcard' value='{$member_data->cd_soundcard|strip_tags|stripslashes}' /> </td>
	 </tr>
	 <tr bgcolor="{#clr_content#}">
 		<td><b>Maus:</b></td>
 		<td><input class='egl_text' type="text"size="40" name='cd_mouse' value='{$member_data->cd_mouse|strip_tags|stripslashes}' /> </td>
	 </tr>
	 <tr bgcolor="{#clr_content#}">
 		<td><b>Mauspad:</b></td>
 		<td><input class='egl_text' type="text"size="40" name='cd_mousepad' value='{$member_data->cd_mousepad|strip_tags|stripslashes}' /> </td>
	 </tr>
	 <tr bgcolor="{#clr_content#}">
 		<td><b>Tastatur:</b></td>
 		<td><input class='egl_text' type="text"size="40" name='cd_keyboard' value='{$member_data->cd_keyboard|strip_tags|stripslashes}' /> </td>
	 </tr>
	 <tr bgcolor="{#clr_content#}">
 		<td><b>Speicher:</b></td>
 		<td><input class='egl_text' type="text"size="40" name='cd_memory' value='{$member_data->cd_memory|strip_tags|stripslashes}' /> </td>
	 </tr>
	 <tr bgcolor="{#clr_content#}">
 		<td><b>Festplatte:</b></td>
 		<td><input class='egl_text' type="text"size="40" name='cd_harddisk' value='{$member_data->cd_harddisk|strip_tags|stripslashes}' /> </td>
	 </tr>
	 <tr bgcolor="{#clr_content#}">
 		<td><b>Bildschirm:</b></td>
 		<td><input class='egl_text' type="text"size="40" name='cd_monitor' value='{$member_data->cd_monitor|strip_tags|stripslashes}' /> </td>
	 </tr>
	 <tr bgcolor="{#clr_content#}">
 		<td><b>Anbindung:</b></td>
 		<td><input class='egl_text' type="text"size="40" name='cd_connection' value='{$member_data->cd_connection|strip_tags|stripslashes}' /> </td>
	 </tr>
	 <tr bgcolor="{#clr_content#}">
 		<td><b>Konsole:</b></td>
 		<td><input class='egl_text' type="text"size="40" name='cd_console' value='{$member_data->cd_console|strip_tags|stripslashes}' /> </td>
	 </tr>
	 
	 <!-- Personality -->
	 <tr bgcolor="{#clr_content_rel#}">
	 	<td colspan=2><b>Persönliches:</b></td>
	 </tr>		 
	 <tr bgcolor="{#clr_content#}">
 		<td><b>Land:</b></td>
 		<td><select class="egl_select" name="country_id">
 			{section name=country loop=$countries}
 				{if $member_data->country_id == $countries[country]->id }
 					<option selected value="{$countries[country]->id}">{$countries[country]->name|strip_tags|stripslashes}</option>
 				{else}
 					<option value="{$countries[country]->id}">{$countries[country]->name|strip_tags|stripslashes}</option>
 				{/if}
 			{/section}
 			</select>
 		 </td>
 		<td> <input class='egl_checkbox' type=checkbox  name='pubkey_country' value='{$member_data->country}' {$check_pubkey_country} /></td>
	 </tr> 	 
	 
	 <tr bgcolor="{#clr_content#}">
 		<td><b>Stadt:</b></td>
 		<td><input class='egl_text' type="text"size="40"   name='city' value='{$member_data->city|strip_tags|stripslashes}' /> </td>
 		<td> <input class='egl_checkbox' type=checkbox name='pubkey_city' value='{$member_data->city|strip_tags|stripslashes}' {$check_pubkey_city}/></td>
	 </tr>
	 <tr bgcolor="{#clr_content#}">
 		<td><b>PLZ:</b></td>
 		<td><input class='egl_text' type="text"size="40" name='zip_code' value='{$member_data->zip_code|strip_tags|stripslashes}' />	 </td>
 		<td> <input class='egl_checkbox' type=checkbox name='pubkey_zip_code' value='{$member_data->zip_code|strip_tags|stripslashes}' {$check_pubkey_zip_code} /></td>
	 </tr>
	 <tr bgcolor="{#clr_content#}">
 		<td><b>Strasse:</b></td>
 		<td><input class='egl_text' type="text"size="40" name='street' value='{$member_data->street|strip_tags|stripslashes}' /> </td>
 		<td> <input class='egl_checkbox' type=checkbox name='pubkey_street' value='{$member_data->street|strip_tags|stripslashes}' {$check_pubkey_street} /></td>
	 </tr>
	 <tr bgcolor="{#clr_content#}">
 		<td><b>Geburtstag:</b></td>
 		<td><input class='egl_text' type="text"size="40" name='birthday' value="{$member_data->birthday}" /> <i>(DD.MM.YYYY)</i> </td>
 		<td> <input class='egl_checkbox' type=checkbox name='pubkey_birthday' value='{$member_data->birthday}' {$check_pubkey_birthday} /></td>
	 </tr>
	 <tr bgcolor="{#clr_content#}">
 		<td><b>HandyNr:</b></td>
 		<td><input class='egl_text' type="text"size="40" name='mobilefone' value='{$member_data->mobilefone|strip_tags|stripslashes}' /> </td>
 		<td> <input class='egl_checkbox' type=checkbox name='pubkey_mobilefone' value='{$member_data->mobilefone|strip_tags|stripslashes}' {$check_pubkey_mobilefone} /></td>
	 </tr>
	 <tr bgcolor="{#clr_content#}">
 		<td><b>Beruf:</b></td>
 		<td><input class='egl_text' type="text"size="40" name='job' value='{$member_data->job|strip_tags|stripslashes}' /> </td>
 		<td> <input class='egl_checkbox' type=checkbox name='pubkey_job' value='{$member_data->job|strip_tags|stripslashes}' {$check_pubkey_job} /></td>
	 </tr>
	 <tr bgcolor="{#clr_content#}">
 		<td><b>Hobbies:</b></td>
 		<td><input class='egl_text' type="text"size="40" name='hobbies' value='{$member_data->hobbies|strip_tags|stripslashes}' /> </td>
 		<td> <input class='egl_checkbox' type=checkbox name='pubkey_hobbies' value='{$member_data->hobbies|strip_tags|stripslashes}' {$check_pubkey_hobbies} /></td>
	 </tr>
	 <tr bgcolor="{#clr_content#}">
 		<td valign=top><b>Beschreibung:</b></td>
 		<td><textarea cols="60" class="egl_textbox" rows="15" style="width:100%" name='description'>{$member_data->description|strip_tags|stripslashes}</textarea> </td>
	 </tr>	 
	 <tr bgcolor="{#clr_content_rel#}">
 		<td> </td>
 		<td>{include file="buttons/bt_universal.tpl" link="javascript:document.f.submit();" caption="abschicken"}</td>
	 </tr>	 	 	 	 	 	 	  
	 </table>
</form>


{/if}

{include file="tb/page.close.tpl"}
