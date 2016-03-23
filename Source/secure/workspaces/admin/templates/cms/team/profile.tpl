<h2>T-Profil `{$team->name|strip_tags|stripslashes}`</h2>
{include file="cms/team/header_menu.tpl"}

{if !$success && $team }

<hr size="1"/>
 <form action='{$url_file}page={$url_page}&team_id={$team->id}&a=change_profil' method=POST> 
	<table border="0" width="100%" cellpadding="5" cellspacing="1">
	 <tr bgcolor="{#clr_content#}">
 		<td><b>ID:</b></td>
 		<td><b> {$team->id} </b></td>
	 </tr>
	 <tr bgcolor="{#clr_content#}">
 		<td><b>Name:</b></td>
 		<td bgcolor="{$clr_no_doubleitem_name}">
 			<input type=hidden name="no_doubleitem_name" value="1"> 
 			<input class="egl_text" type="text" name="name" value='{$team->name|stripslashes}' size="50"> </td>
	 </tr>
	 <tr bgcolor="{#clr_content#}">
 		<td><b>Kürzel:</b></td>
 		<td> <input class="egl_text" type="text" name="tag" value='{$team->tag}' size="50"> </td>
	 </tr>
	 <tr bgcolor="{#clr_content#}">
 		<td><b>Join Passwort:</b></td>
 		<td> <input class="egl_text" type="text" name="join_password" value="" size="50"> </td>
	 </tr>
	 <tr bgcolor="{#clr_content#}">
 		<td><b>Homepage:</b></td>
 		<td> <input class='egl_text' type="text" name="hp" value="{$team->hp}" size="50"> </td>
	 </tr>
	 <tr bgcolor="{#clr_content#}">
 		<td><b>IRC:</b> (Channel@Server)</td>
 		<td> <input class="egl_text" type="text" name="irc" value="{$team->irc}" size="50"></td>
	 </tr>	 
	 <tr bgcolor="{#clr_content#}">
 		<td><b>Land:</b></td>
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
 		<td valign="top"><b>Beschreibung:</td>
 		<td> <textarea name="description" class="egl_textbox" cols="60" rows="10">{$team->description}</textarea> </td>
	 </tr>	 
	 <tr bgcolor="{#clr_content#}">
 		<td><b>Spielerfotos anzeigen:</b></td>
 		<td> <select class="egl_select" name="display_player_logo">
 			{if $team->display_player_logo}	
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
 		<td><input type="image" src="images/buttons/new/bt_send.gif"/></td>
	 </tr>	 
	 
	 
	</table>	

{/if}