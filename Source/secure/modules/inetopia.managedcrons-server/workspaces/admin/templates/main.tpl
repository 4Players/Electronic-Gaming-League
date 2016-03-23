<table border="0" width="100%" cellpadding="5" cellspacing="1" bgcolor="{#clr_content_border#}"> 
 <tr>
 	<td width="25%" align="center"
 		bgcolor="{#clr_content#}"
		 onmouseover="javascript:this.style.backgroundColor='#FFFFFF';"
		 onmouseout="javascript:this.style.backgroundColor='{#clr_content#}';">
 		<table cellpadding="5" cellspacing="0">
 		 <tr>
 		 	<td><img src="images/managedcrons.gif" height="64"/></td>
 			<td><A href="{$url_file}page={$CURRENT_MODULE_ID}:overview"><b>Service Übersicht</b></a></td>
 		 </tr>
 		</table>
 	</td>
 	<td width="25%" align="center"
 		bgcolor="{#clr_content#}"
		 onmouseover="javascript:this.style.backgroundColor='#FFFFFF';"
		 onmouseout="javascript:this.style.backgroundColor='{#clr_content#}';">
 		<table cellpadding="5" cellspacing="0">
 		 <tr>
 		 	<td><img src="images/managedcrons_add.gif" height="64"/></td>
 			<td><A href="{$url_file}page={$CURRENT_MODULE_ID}:new_managedcron"><b>Neuer ManagedCron</b></a></td>
 		 </tr>
 		</table>
 	</td>
 	<td width="25%" align="center"
 		bgcolor="{#clr_content#}"
		 onmouseover="javascript:this.style.backgroundColor='#FFFFFF';"
		 onmouseout="javascript:this.style.backgroundColor='{#clr_content#}';">
 		<table cellpadding="5" cellspacing="0">
 		 <tr>
 		 	<td><img src="images/managedcrons_users.gif" height="64"/></td>
 			<td><A href="{$url_file}page={$CURRENT_MODULE_ID}:users"><b>Registrierte Nutzer</b></a></td>
 		 </tr>
 		</table>
 	</td>
 	<td width="25%" align="center"
 		bgcolor="{#clr_content#}"
		 onmouseover="javascript:this.style.backgroundColor='#FFFFFF';"
		 onmouseout="javascript:this.style.backgroundColor='{#clr_content#}';">
 		<table cellpadding="5" cellspacing="0">
 		 <tr>
 		 	<td><img src="images/managedcrons_settings.gif" height="64" /></td>
 			<td><A href="{$url_file}page={$CURRENT_MODULE_ID}:settings"><b>Einstellungen</b></a></td>
 		 </tr>
 		</table>
 	</td>
 </tr>
</table>
<br/>
<br/>
{include file="$module_file"}