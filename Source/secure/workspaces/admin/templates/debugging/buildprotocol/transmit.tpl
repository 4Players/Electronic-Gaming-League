<h2>Protokoll senden</h2>

vielen Dank, hiermit haben Sie sich entschieden uns bei der Entwicklung zu helfen. Teilen Sie uns nur noch Ihr Problem mit, indem Sie folgendes Formular ausfüllen.

{if !$success}{$message}{/if}

{if $success}
	<br/>
	<b>Ihre Nachricht wurde dem Entwickler-Team mitgeteilt. Vielen Dank!</b>
	
	<br/><br/><br/>
	Powered by <A target="_blank" href="http://inetopia.de">Ínetopia</a>
	
{else}
<br/><br/><br/>

<form action="{$url_file}page={$url_page}&file={$buildprotocol_file}&a=send" method="POST">
<table width="100%" cellpadding="0" cellspacing="2" bgcolor="#C0C0C0">
 <tr><td bgcolor="#FFFFFF">
	<table border="0" cellpadding="5" cellspacing="1" width="100%" align="center">
	
	 <tr bgcolor="{#clr_content#}">
	 	<td width="150">
	 		<b>Überschrift:</b>
	 	</td>
	 	<td>
	 		<select class="egl_select" name="caption" style="width:400;">
	 			<option value="Probleme EGL.Configsheet">Probleme - EGL.Configsheet</option>
	 			<option value="Probleme EGL Workspaces">Probleme - EGL.Workspaces</option>
	 			<option value="Probleme EGL Module">Probleme - EGL.Services</option>
	 			<option value="Probleme EGL Module">Probleme - EGL.Module</option>
	 			<option value="Generelles Problem">Probleme - Allgemein</option>
	 			<option value="Kein Bug, nur Informativ">Keine Fehlermeldung, nur informativ</option>
	 			<option value="Andere(Bitte angeben)">Weiteres(bitte unten angeben)</option>
	 		</select>
	 	</td>
	 <tr bgcolor="{#clr_content#}">
		<td></td>
		<td><input name="caption_more" class="egl_text" type="text" value="" size="50"/></td>
	 </tr>
	 <tr bgcolor="{#clr_content#}">
		<td><b>Vor- Nachname:</b></td>
		<td><input name="name" class="egl_text" type="text" value="" size="50"/></td>
	 </tr>
	 <tr bgcolor="{#clr_content#}">
		<td><b>Kontaktmöglichkeit:</b><br/>(Nur bei Rückfragen)</td>
		<td><input name="contact" class="egl_text" type="text" value="" size="50"/></td>
	 </tr>
	 <tr bgcolor="{#clr_content#}">
		<td><b>Kurzbeschreibung:</b></td>
		<td><input name="short_text" class="egl_text" type="text" value="" style="width:100%;"/></td>
	 </tr>
	 <tr bgcolor="{#clr_content#}">
		<td valign="top"><b>Detailbeschreibung:</b></td>
		<td><textarea name="long_text" class="egl_textbox" style="width:100%;" rows="20"></textarea></td>
	 </tr>
	  <tr bgcolor="{#clr_content#}">
		<td width="200"><b>Protokoll im Anhang:</b></td>
		<td><A href="{$url_file}page=debugging.buildprotocol.protocol&file={$buildprotocol_file}" title="Protokoll anzeigen"><b>{$buildprotocol_file}</b></a></td>
	 </tr>
	  <tr bgcolor="{#clr_content#}">
		<td colspan="2"><input type="image" src="images/buttons/new/bt_send.gif"/></td>
	 </tr>
	</table>
	<input type="hidden" name="buildfile" value="{$buildprotocol_file}" />
	
 </td></tr>
</table>
</form>
{/if}
