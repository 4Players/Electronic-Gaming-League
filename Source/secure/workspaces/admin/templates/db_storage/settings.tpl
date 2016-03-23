<h2>Einstellungen</h2>
{include file="etc/message.tpl"}

{if $success}

{else}

	<form action="{$url_file}page={$url_page}&&a=change" method="POST">
	<table width="100%" cellpadding="20" background="images/admin/db_settings_big.gif" style="background-repeat:no-repeat;">
	 <tr><td>
		<br/><br/><br/>
		<table width="100%" cellpadding="0" cellspacing="2" bgcolor="#C0C0C0">
		 <tr><td bgcolor="#FFFFFF">
			<table border="0" cellpadding="5" cellspacing="1" width="100%" >
			 <tr bgcolor="{#clr_content#}">
			 	<td><b>DB-Bibliothek:</b></td>
			 	<td><select class="egl_select" style="width:200;" name="db_bib">
			 			{section name=bib loop=$db_bibs}
			 			{if $db_bibs[bib] == $db.dbbib}
			 				<option selected value='{$db_bibs[bib]}'>{$db_bibs[bib]}</option>
			 			{else}
			 				<option value='{$db_bibs[bib]}'>{$db_bibs[bib]}</option>
			 			{/if}
			 			{/section}
			 		</select>
			 	</td>
			 </tr>
			 <tr bgcolor="{#clr_content#}">
			 	<td><b>Server:</b></td>
			 	<td><input type="text" class="egl_text" name="db_server" size="50"  value="{$db.server}"/></td>
			 </tr>
			 <tr bgcolor="{#clr_content#}">
			 	<td><b>Datenbank:</b></td>
			 	<td><input type="text" class="egl_text" name="db_database" size="50"  value="{$db.database}"/></td>
			 </tr>
			 <tr bgcolor="{#clr_content#}">
			 	<td><b>Benutzer:</b></td>
			 	<td><input type="text" class="egl_text" name="db_username" size="50"  value="{$db.username}"/></td>
			 </tr>
			 <tr bgcolor="{#clr_content#}">
			 	<td><b>Passwort:</b></td>
			 	<td><input type="text" class="egl_text" name="db_password" size="50" value="{$db.password}"/></td>
			 </tr>	
			  <tr bgcolor="{#clr_content#}">
			 	<td></td>
			 	<td><input type="image" src="images/buttons/new/bt_send.gif"/></td>
			 </tr>
		</table>
	
		</td></tr>
	   </table>
	   {if strlen($db_lasterror) > 0}
		   <br/><br/>
		   <b>Fehlermeldung:</b><br/>
		   <font color="#FF0000">{$db_lasterror}</font>
	   {/if}
	 </td></tr>
	</table>
 </form>
 
 {/if}