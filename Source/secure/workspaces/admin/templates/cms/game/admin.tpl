<h2>Spiel bearbeiten</h2>
{include file="etc/message.tpl"}

{if $success}
{else}
	
	<form action="{$url_file}page={$url_page}&game_id={$game->id}&a=change_game" method="POST">
	<table width="100%" cellpadding="20" background="images/admin/games_admin.gif" style="background-repeat:no-repeat;">
	 <tr><td>
		<br/><br/><br/>
		<table width="100%" cellpadding="0" cellspacing="2" bgcolor="#C0C0C0">
		 <tr><td bgcolor="#FFFFFF">
			<table border="0" cellpadding="5" cellspacing="1" width="100%" >
			 <tr bgcolor="{#clr_content#}">
			 	<td></td>
			 	<td align="right"><A title="Spiel löschen" href="{$url_file}page={$url_page}&game_id={$game->id}&a=delete_game"><img border="0" src="images/admin/small_delete.gif"/></td>
			 </tr>
			 <tr bgcolor="{#clr_content#}">
			 	<td><b>Name:</b></td>
			 	<td><input type="text" class="egl_text" name="game_name" size="50"  value="{$game->name|strip_tags|stripslashes}"/></td>
			 </tr>
			 <tr bgcolor="{#clr_content#}">
			 	<td><b>Kürzel:</b></td>
			 	<td><input type="text" class="egl_text" name="game_token" size="50" value="{$game->token|strip_tags|stripslashes}"/></td>
			 </tr>
			 <tr bgcolor="{#clr_content#}">
			 	<td><b>Publisher:</b></td>
			 	<td><input type="text" class="egl_text" name="game_publisher" size="50" value="{$game->publisher}" onclick="javascript: if( this.value == 'Unbekannt' )this.value='';"/></td>
			 </tr>
			 <tr bgcolor="{#clr_content#}">
			 	<td><b>Release Datum:</b></td>
			 	<td><input type="text" class="egl_text" name="game_release_date" size="50" value="{date timestamp=$game->release_date format='%d.%m.%Y'}" onclick="javascript: if( this.value == 'Unbekannt' )this.value='';"/></td>
			 </tr>		 
			 <tr bgcolor="{#clr_content#}">
			 	<td><b>Entwickler(Team):</b></td>
			 	<td><input type="text" class="egl_text" name="game_developer" size="50" value="{$game->developer|strip_tags|stripslashes}" onclick="javascript: if( this.value == 'Unbekannt' )this.value='';"/></td>
			 </tr>			 
			 <tr bgcolor="{#clr_content#}">
			 	<td><b>Homepage:</b></td>
			 	<td><input type="text" class="egl_text" name="game_hp" size="50" value="{$game->hp|strip_tags|stripslashes}"/></td>
			 </tr>
			 <tr bgcolor="{#clr_content#}">
			 	<td valign="top"><b>Kurzbeschreibung:</b><br/>(max. 255 Zeichen)</b></td>
			 	<td><textarea class="egl_textbox" name="game_short_description" cols="50" rows="3">{$game->short_description|strip_tags|stripslashes}</textarea></td>
			 </tr>
			 <tr bgcolor="{#clr_content#}">
			 	<td valign="top"><b>Beschreibung:</b></td>
			 	<td><textarea class="egl_textbox" name="game_description" style="width:100%" name="game_description" rows="10">{$game->description|strip_tags|stripslashes}</textarea></td>
			 </tr>
			 <tr bgcolor="{#clr_content#}">
			 	<td><b>Kategorie:</b></td>
				<td><select style="width:300;" name="game_cat_id" class="egl_select">
						<option value="-1">Keine Kategorie ausgewählt</option>					
						<option disabled >------------------------------------</option>					
						{defun name="testrecursion" catroot=$categoryroot level="0"}
						    <option value="{$catroot->oProperties->id}" {if $catroot->oProperties->id == $game->cat_id}selected{/if} >{section name=c loop=$level}&nbsp;&nbsp;&nbsp;{/section} {$catroot->oProperties->name}</option>
							{foreach from=$catroot->aNodes item=node} 
								{fun name="testrecursion" catroot=$node level=$level+1 }
							{/foreach}
						{/defun}
				 </select>		
				</td>	 
		 	 </tr>
			 <tr bgcolor="{#clr_content#}">
			 	<td><b>FORUM:</b></td>
				<td><select style="width:300;" name="forum_id" class="egl_select">
						<option value="-1">Kein Forum ausgewählt</option>					
						<option disabled >------------------------------------</option>
						
						{defun name="testrecursion2" catroot=$forumtree level="0"}
						    <option value="{$catroot->oProperties->id}" {if $catroot->oProperties->id == $game->forum_id}selected{/if} >{section name=c loop=$level}&nbsp;&nbsp;&nbsp;{/section} {$catroot->oProperties->name}</option>
							{foreach from=$catroot->aNodes item=node} 
								{fun name="testrecursion2" catroot=$node level=$level+1 }
							{/foreach}
						{/defun}
												
				 </select>		
				</td>	 
		 	 </tr>
			 <tr bgcolor="{#clr_content#}">
			 	<td></td> 
			 	<td><input type="image" src="images/buttons/new/bt_send.gif"/></td> 
			 </tr>
			 <tr bgcolor="{#clr_content#}"><td colspan="2"></form></td></tr>
			 <tr bgcolor="{#clr_content#}">
			 	<td valign="top"><b>GameAccount(ID) Einstellungen:</td>
			 	<td>
			 	<form enctype="multipart/form-data" action="{$url_file}page={$url_page}&game_id={$game->id}&a=update_gameaccount" method="POST">
			 		<table cellpadding="5">
			 		 <tr>
			 		 	<td valign="top">Account wählen:</td>
			 		 	<td valign="top">
			 		 	 <select name="selected_gameacctype" style="width:200;" class="egl_select">
			 		 	 	<optgroup label="Funktionen"></optgroup>
			 		 	 	<option value="-1">&nbsp;&nbsp;Kein Type gewählt</option>
			 		 	 	<option value="0">&nbsp;&nbsp;Neu erstellen</option>
			 		 	 	<optgroup label="GameAccount Types"></optgroup>
			 		 	 {section name=ga loop=$gameaccounts}
			 		 	 	<option value="{$gameaccounts[ga]->id}" {if $game->gameacctype_id == $gameaccounts[ga]->id}selected{/if}>&nbsp;&nbsp;{$gameaccounts[ga]->name|strip_tags|stripslashes}</option>
			 		 	 {/section}
			 		 	 </select>
			 		 	</td>
			 		 </tr>
			 		 <tr>
			 		 	<td valign="top">ID-Name:</td>
			 		 	<td valign="top"><input type="text" class="egl_text" name="name" value="{$gameaccount->name|strip_tags|stripslashes}"/></td>
			 		 </tr>
			 		 <tr>
			 		 	<td valign="top">ID-Länge:</td>
			 		 	<td valign="top"><input type="text" class="egl_text" size="20" name="length" value="{$gameaccount->length}"/></td>
			 		 	<td valign="top"><input type="submit" value="Abschicken"/></td>
			 		 </tr>
			 		 <tr>
			 		 	<td colspan="3"><font color="red"><b>Beachte:</b> Zum löschen, bitte alle Felder leer lassen!</font></td>
			 		 </tr>
			 		</table>

			 	</form>
			 	</td>
			 </tr>
			 
			 <tr bgcolor="{#clr_content#}">
			 	<td valign="top"><b>Kleines Bild:</b><br/> 60x80</td>
			 	<td>
			 	<form enctype="multipart/form-data" action="{$url_file}page={$url_page}&game_id={$game->id}&a=upload_image" method="POST">
			 		<table width="100%">
			 		 <tr>
			 		 	<td valign="top" width="1%"><input type="file" name="upload_file"/><br/>Max. 3.000 KB</td>
			 		 	<td valign="top" width="1%"><input type="submit" value=" Hochladen "/></td>
			 		 	<td align="right">
			 		 	<input type="hidden" name="MAX_FILE_SIZE" value="30000" />
			 		 	<input type="hidden" name="image_size" value="small" />
							{if $game->logo_small_file != 'non'}
								<A title="{$game->name}" href="{$url_file}page=cms.game.admin&game_id={$game->id}"><img border="1" style="border-color:#000000;" alt="{$game->name}" src="{$path_games}small/{$game->logo_small_file}" width="60" height="80"></a>
							{else}
								<A title="{$game->name}" href="{$url_file}page=cms.game.admin&game_id={$game->id}"><img border="1" style="border-color:#000000;" alt="{$game->name}" src="images/logo.na.jpg" width="60" height="80"></a>
							{/if}
			 		 	</td>
			 		 </tr>
			 		</table>
			 	</form>
			 	</td>
			 </tr>
			 <tr bgcolor="{#clr_content#}">
			 	<td valign="top"><b>Großes Bild:</b><br/> ?x?</td>
			 	<td>
			 	<form enctype="multipart/form-data" action="{$url_file}page={$url_page}&game_id={$game->id}&a=upload_image" method="POST">
			 		<table width="100%">
			 		 <tr>
			 		 	<td valign="top" width="1%"><input type="file" name="upload_file"/><br/>Max. 3.000 KB</td>
			 		 	<td valign="top" width="1%"><input type="submit" value=" Hochladen "/></td>
			 		 	<td align="right">
			 		 	<input type="hidden" name="MAX_FILE_SIZE" value="30000" />
			 		 	<input type="hidden" name="image_size" value="big" />
							{if $game->logo_big_file != 'non'}
								<A title="{$game->name}" href="{$url_file}page=cms.game.admin&game_id={$game->id}"><img border="1" style="border-color:#000000;" alt="{$game->name}" src="{$path_games}big/{$game->logo_big_file}" width="60" height="80"></a>
							{else}
								<A title="{$game->name}" href="{$url_file}page=cms.game.admin&game_id={$game->id}"><img border="1" style="border-color:#000000;" alt="{$game->name}" src="images/logo.na.jpg" width="60" height="80"></a>
							{/if}
			 		 	</td>
			 		 </tr>
			 		</table>
			 	</form>
			 	</td>
			 </tr>		
 
		</table>
	
		</td></tr>
	   </table>
	
	 </td></tr>
	</table>
	
{/if}