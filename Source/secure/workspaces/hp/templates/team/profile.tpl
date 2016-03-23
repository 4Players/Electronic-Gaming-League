<h2>{$LNG_BASIC.c5500} `{if $clan->id}`{$clan->name|strip_tags|stripslashes}`:{/if} {$team->name|strip_tags|stripslashes}`</h2>
{include file="devs/message.tpl"}


{if !$success && $team }
 <form name="f" action='{$url_file}page={$url_page}&clan_id={$clan->id}&team_id={$team->id}&a=change_profil' method=POST> 
	<table border="0" width="100%" cellpadding="3" cellspacing="1" bgcolor="{#clr_content_border#}">
	 <tr bgcolor="{#clr_content#}">
 		<td bgcolor="{#clr_content_rel#}" width="30%"><b>{$LNG_BASIC.c4835}:</b></td>
 		<td>{$team->id}</td>
	 </tr>
	 <tr bgcolor="{#clr_content#}">
 		<td bgcolor="{#clr_content_rel#}"><b>{$LNG_BASIC.c4831}:</b></td>
 		<td class="egl_live_td"> <input onBlur="textbox_set_style(this, '{#clr_content#}', '{#clr_content#}', '#FFFFFF');" onFocus="textbox_set_style(this, '{#clr_textbox_border#}', '{#clr_textbox_bgcolor#}', '{#clr_textbox_color#}');" class='egl_live_text' type=text name='name' value='{$team->name|stripslashes}'/> </td>
	 </tr>
	 <tr bgcolor="{#clr_content#}">
 		<td bgcolor="{#clr_content_rel#}"><b>{$LNG_BASIC.c4832}:</b></td>
 		<td class="egl_live_td"> <input onBlur="textbox_set_style(this, '{#clr_content#}', '{#clr_content#}', '#FFFFFF');" onFocus="textbox_set_style(this, '{#clr_textbox_border#}', '{#clr_textbox_bgcolor#}', '{#clr_textbox_color#}');" class='egl_live_text' type=text name='tag' value='{$team->tag|stripslashes}'/> </td>
	 </tr>
	 <tr bgcolor="{#clr_content#}">
 		<td bgcolor="{#clr_content_rel#}"><b>{$LNG_BASIC.c5501}:</b></td>
 		<td class="egl_live_td"> <input onBlur="textbox_set_style(this, '{#clr_content#}', '{#clr_content#}', '#FFFFFF');" onFocus="textbox_set_style(this, '{#clr_textbox_border#}', '{#clr_textbox_bgcolor#}', '{#clr_textbox_color#}');" class='egl_live_text' type=text name="join_password" value=""/></td>
	 </tr>
	 <tr bgcolor="{#clr_content#}">
 		<td bgcolor="{#clr_content_rel#}" valign="top"><b>{$LNG_BASIC.c5502}:</b></td>
 		<td class="egl_live_td"><textarea onBlur="textbox_set_style(this, '{#clr_content#}', '{#clr_content#}', '#FFFFFF');" onFocus="textbox_set_style(this, '{#clr_textbox_border#}', '{#clr_textbox_bgcolor#}', '{#clr_textbox_color#}');" class='egl_live_textbox' name="server" class="egl_textarea" cols="60" rows="3">{$team->server|stripslashes}</textarea><br>
 			<i>({$LNG_BASIC.c5503})</i> </td>
	 </tr>
	 <tr bgcolor="{#clr_content#}">
 		<td bgcolor="{#clr_content_rel#}"><b>{$LNG_BASIC.c5504}:</b></td>
 		<td> <select class="egl_select" name="country_id">
 			{section name=country loop=$countries}
 				{if $team->country_id == $countries[country]->id }
 					<option selected value="{$countries[country]->id}">{$countries[country]->name}</option>
 				{else}
 					<option value="{$countries[country]->id}">{$countries[country]->name}</option>
 				{/if}
 			{/section}
 			</select>
 		 </td>
	 </tr>	 
	 <tr bgcolor="{#clr_content#}">
 		<td  bgcolor="{#clr_content_rel#}" valign="top"><b>{$LNG_BASIC.c5505}:</b></td>
 		<td class="egl_live_td"> <textarea onBlur="textbox_set_style(this, '{#clr_content#}', '{#clr_content#}', '#FFFFFF');" onFocus="textbox_set_style(this, '{#clr_textbox_border#}', '{#clr_textbox_bgcolor#}', '{#clr_textbox_color#}');" class='egl_live_textbox' name="description" class="egl_textarea" cols="60" rows="10">{$team->description}</textarea> </td>
	 </tr>	 
	 
	 <tr bgcolor="{#clr_content#}">
 		<td  bgcolor="{#clr_content_rel#}"><b>{$LNG_BASIC.c5506}:</b></td>
 		<td> <select class="egl_select" name="display_player_logo">
 			{if $team->display_player_logo}	
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
 		<td></td>
 		<td>{include file="buttons/bt_universal.tpl" color=$GLOBAL_COLOR caption=$LNG_BASIC.c1018 link="javascript:document.f.submit();"}</td>
	 </tr>
	</table>	

{/if}