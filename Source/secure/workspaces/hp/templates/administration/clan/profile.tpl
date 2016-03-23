<h2>C-Profil `{$clan->name|strip_tags|stripslashes}`</h2>
{include file="administration/clan/header_menu.tpl"}
{include file="devs/hr2.tpl" width="100%"}
{include file="devs/message.tpl"}

{if !$success && $clan }
 <form name="f" action='{$url_file}page={$url_page}&clan_id={$clan->id}&a=change_profil' method=POST> 
	<table border="0" width="100%" cellpadding="3" cellspacing="1" bgcolor="{#clr_content_border#}">
	 <tr bgcolor="{#clr_content#}">
 		<td><b>ID:</b></td>
 		<td> {$clan->id} </td>
	 </tr>
	 <tr bgcolor="{#clr_content#}">
 		<td><b>Name:</b></td>
 		<td bgcolor="{$clr_no_doubleitem_name}">
 			<input type=hidden name="no_doubleitem_name" value="1"> 
 			<input class='egl_text' type=text name='name' value='{$clan->name}' size="50"> </td>
	 </tr>
	 <tr bgcolor="{#clr_content#}">
 		<td><b>Kürzel:</b></td>
 		<td> <input class='egl_text' type=text name='tag' value='{$clan->tag}' size="50"> </td>
	 </tr>
	 <tr bgcolor="{#clr_content#}">
 		<td><b>Join Passwort:</b></td>
 		<td> <input class='egl_text' type=text name='join_password'  size="50" value=""> </td>
	 </tr>
	 <tr bgcolor="{#clr_content#}">
 		<td><b>Homepage:</b></td>
 		<td> <input class='egl_text' type=text name='hp' value='{$clan->hp}' size="50"> </td>
	 </tr>
	 <tr bgcolor="{#clr_content#}">
 		<td><b>IRC:</b> (Channel@Server)</td>
 		<td> <input class='egl_text' type=text name='irc' value="{$clan->irc}" size="50"></td>
	 </tr>	 
	 <tr bgcolor="{#clr_content#}">
 		<td><b>Land:</b></td>
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
 		<td valign="top"><b>Beschreibung:</td>
 		<td> <textarea name="description" class="egl_textarea" cols="60" rows="10">{$clan->description}</textarea> </td>
	 </tr>	 
	 <tr bgcolor="{#clr_content#}">
 		<td><b>Spielerfotos anzeigen:</b></td>
 		<td> <select class="egl_select" name="display_player_logo">
 			{if $clan->display_player_logo}	
 				<option value="1">Ja</option> 
 				<option value="0">Nein</option>
 			{else} 
 				<option value="1">Ja</option> 
 				<option selected value="0">Nein</option>
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