<h2>{$LNG_BASIC.c4780} `{$clan->name|strip_tags|stripslashes}`</h2>
{include file="devs/message.tpl"}


{*DARF NICHT ENTFERNT WERDEN !!*}
{if !$success && $clan }
 <form name="f" action="{$url_file}page={$url_page}&clan_id={$clan->id}&a=change_profil" method="POST"> 
	<table border="0" width="100%" cellpadding="3" cellspacing="1" bgcolor="{#clr_content_border#}">
	 <tr bgcolor="{#clr_content#}">
 		<td bgcolor="{#clr_content_rel#}"><b>{$LNG_BASIC.c1022}:</b></td>
 		<td> <b>{$clan->id}</b> </td>
	 </tr>
	 <tr bgcolor="{#clr_content#}">
 		<td  bgcolor="{#clr_content_rel#}"><b>{$LNG_BASIC.c4721}:</b></td>
 		<td class="egl_live_td"> <input onBlur="textbox_set_style(this, '{#clr_content#}', '{#clr_content#}', '#FFFFFF');" onFocus="textbox_set_style(this, '{#clr_textbox_border#}', '{#clr_textbox_bgcolor#}', '{#clr_textbox_color#}');" class='egl_live_text' type=text name='name' value='{$clan->name|strip_tags}'> </td>
	 </tr>
	 <tr bgcolor="{#clr_content#}">
 		<td bgcolor="{#clr_content_rel#}"><b>{$LNG_BASIC.c4722}:</b></td>
 		<td class="egl_live_td"> <input onBlur="textbox_set_style(this, '{#clr_content#}', '{#clr_content#}', '#FFFFFF');" onFocus="textbox_set_style(this, '{#clr_textbox_border#}', '{#clr_textbox_bgcolor#}', '{#clr_textbox_color#}');" class='egl_live_text' type=text name='tag' value='{$clan->tag|strip_tags}'> </td>
	 </tr>
	 <tr bgcolor="{#clr_content#}">
 		<td bgcolor="{#clr_content_rel#}"><b>{$LNG_BASIC.c4781}:</b></td>
 		<td class="egl_live_td"> <input onBlur="textbox_set_style(this, '{#clr_content#}', '{#clr_content#}', '#FFFFFF');" onFocus="textbox_set_style(this, '{#clr_textbox_border#}', '{#clr_textbox_bgcolor#}', '{#clr_textbox_color#}');" class='egl_live_text' type=text name='join_password' value=''> </td>
	 </tr>
	 <tr bgcolor="{#clr_content#}">
 		<td bgcolor="{#clr_content_rel#}"><b>{$LNG_BASIC.c4723}:</b></td>
 		<td class="egl_live_td"> <input onBlur="textbox_set_style(this, '{#clr_content#}', '{#clr_content#}', '#FFFFFF');" onFocus="textbox_set_style(this, '{#clr_textbox_border#}', '{#clr_textbox_bgcolor#}', '{#clr_textbox_color#}');" class='egl_live_text' type=text name='hp' value='{$clan->hp|strip_tags}'> </td>
	 </tr>
	 <tr bgcolor="{#clr_content#}">
 		<td bgcolor="{#clr_content_rel#}"><b>{$LNG_BASIC.c4782}:</b> ({$LNG_BASIC.c4783})</td>
 		<td class="egl_live_td"> <input onBlur="textbox_set_style(this, '{#clr_content#}', '{#clr_content#}', '#FFFFFF');" onFocus="textbox_set_style(this, '{#clr_textbox_border#}', '{#clr_textbox_bgcolor#}', '{#clr_textbox_color#}');" class='egl_live_text' type=text name='irc' value='{$clan->irc|strip_tags}'> </td>
	 </tr>	 
	 <tr bgcolor="{#clr_content#}">
 		<td bgcolor="{#clr_content_rel#}"><b>{$LNG_BASIC.c4784}:</b></td>
 		<td> <select class="egl_select" name="country_id">
 			{section name=country loop=$countries}
 				{if $clan->country_id == $countries[country]->id }
 					<option selected value="{$countries[country]->id}">{$countries[country]->name}</option>
 				{else}
 					<option value="{$countries[country]->id}">{$countries[country]->name}</option>
 				{/if}
 			{/section}
 			</select>
 		 </td>
	 </tr>	 
	 <tr bgcolor="{#clr_content#}">
 		<td valign="top" bgcolor="{#clr_content_rel#}"><b>{$LNG_BASIC.c4785}:</td>
 		<td class="egl_live_td"> <textarea onBlur="textbox_set_style(this, '{#clr_content#}', '{#clr_content#}', '#FFFFFF');" onFocus="textbox_set_style(this, '{#clr_textbox_border#}', '{#clr_textbox_bgcolor#}', '{#clr_textbox_color#}');" class='egl_live_textbox' name="description" class="egl_textarea" cols="60" rows="10">{$clan->description}</textarea> </td>
	 </tr>	 
	 <tr bgcolor="{#clr_content#}">
 		<td bgcolor="{#clr_content_rel#}"><b>{$LNG_BASIC.c4786}:</b></td>
 		<td> <select class="egl_select" name="display_player_logo">
 			{if $clan->display_player_logo}	
 				<option value="1">{$LNG_BASIC.c1023}</option> 
 				<option value="0">{$LNG_BASIC.c1024}</option>
 			{else} 
 				<option value="1">{$LNG_BASIC.c1023}</option> 
 				<option selected value="0">{$LNG_BASIC.c1024}</option>
 			{/if}
 			
 			 </select>
 			</td>
	 </tr>
	 <tr bgcolor="{#clr_content#}">
 		<td bgcolor="{#clr_content_rel#}"><b>{$LNG_BASIC.c4787}:</b></td>
 		<td> <select class="egl_select" name="display_team_details">
 			{if $clan->display_team_details}
 				<option value="1">{$LNG_BASIC.c1023}</option>
 				<option value="0">{$LNG_BASIC.c1024}</option>
 			{else}
 				<option value="1">{$LNG_BASIC.c1023}</option> 
 				<option selected value="0">{$LNG_BASIC.c1024}</option>
 			{/if}
 			 </select>
 		</td>
	 </tr>	 
	 <tr bgcolor="{#clr_content#}">
 		<td colspan="2" align="center">{include file="buttons/bt_universal.tpl" color=$GLOBAL_COLOR caption=$LNG_BASIC.c1018 link="javascript:document.f.submit();"}</td>
	 </tr>	 
	 
	 
	</table>	

{/if}