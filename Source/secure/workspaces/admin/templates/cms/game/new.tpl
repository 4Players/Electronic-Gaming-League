<h2>Spiel hinzufügen</h2>
{include file="etc/message.tpl"}

{if $success}

{else}

<form action="{$url_file}page={$url_page}&a=add_game" method="POST">
<table width="100%" cellpadding="20" background="images/admin/games_new.gif" style="background-repeat:no-repeat;">
 <tr><td>
	<br/><br/><br/>
	<table width="100%" cellpadding="0" cellspacing="2" bgcolor="#C0C0C0">
	 <tr><td bgcolor="#FFFFFF">
		<table border="0" cellpadding="5" cellspacing="1" width="100%" >
		 <tr bgcolor="{#clr_content#}">
		 	<td><b>Name:</b></td>
		 	<td><input type="text" class="egl_text" name="game_name" size="50" value="Unbekannt" onclick="javascript: if( this.value == 'Unbekannt' )this.value='';"/></td>
		 </tr>
		 <tr bgcolor="{#clr_content#}">
		 	<td><b>Kürzel:</b></td>
		 	<td><input type="text" class="egl_text" name="game_token" size="50" value="Unbekannt" onclick="javascript: if( this.value == 'Unbekannt' )this.value='';"/></td>
		 </tr>
		 <tr bgcolor="{#clr_content#}">
		 	<td><b>Publisher:</b></td>
		 	<td><input type="text" class="egl_text" name="game_publisher" size="50" value="Unbekannt" onclick="javascript: if( this.value == 'Unbekannt' )this.value='';"/></td>
		 </tr>
		 <tr bgcolor="{#clr_content#}">
		 	<td><b>Release Datum:</b></td>
		 	<td><input type="text" class="egl_text" name="game_release_date" size="50" value="{date timestamp=$smarty.const.EGL_TIME format='%d.%m.%Y'}" onclick="javascript: if( this.value == 'Unbekannt' )this.value='';"/></td>
		 </tr>		 
		 <tr bgcolor="{#clr_content#}">
		 	<td><b>Entwickler(Team):</b></td>
		 	<td><input type="text" class="egl_text" name="game_developer" size="50" value="Unbekannt" onclick="javascript: if( this.value == 'Unbekannt' )this.value='';"/></td>
		 </tr>
		 <tr bgcolor="{#clr_content#}">
		 	<td><b>Homepage:</b></td>
		 	<td><input type="text" class="egl_text" name="game_hp" size="50" value="Unbekannt" onclick="javascript: if( this.value == 'Unbekannt' )this.value='';"/></td>
		 </tr>
		 <tr bgcolor="{#clr_content#}">
		 	<td valign="top"><b>Kurzbeschreibung:</b><br/>(max. 255 Zeichen)</b></td>
		 	<td><textarea class="egl_textbox" name="game_short_description" cols="50" rows="3"></textarea></td>
		 </tr>
		 <tr bgcolor="{#clr_content#}">
		 	<td valign="top"><b>Beschreibung:</b></td>
		 	<td><textarea class="egl_textbox" name="game_description" style="width:100%" rows="10"></textarea></td>
		 </tr>
		 <tr bgcolor="{#clr_content#}">
		 	<td><b>Kleines Bild:</b><br/> 60x80</td>
		 	<td>Bilder können nach dem Erstellen gesetzt werden.</td>
		 </tr>
		 <tr bgcolor="{#clr_content#}">
		 	<td><b>Großes Bild:</b><br/> ?x?</td>
		 	<td>Bilder können nach dem Erstellen gesetzt werden.</td>
		 </tr>
		 <tr bgcolor="{#clr_content#}">
		 	<td></td> 
		 	<td><input type="image" src="images/buttons/new/bt_send.gif"/></td> 
		 </tr>
		</table>

	</td></tr>
   </table>

 </td></tr>
</table>
</form>
{/if}