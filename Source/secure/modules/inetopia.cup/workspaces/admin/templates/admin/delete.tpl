<table cellpadding="5"><tr>
	<td><table cellpadding="1" cellspacing="0" bgcolor="#000000"><tr><td><img src="{$PATH_GAMES}small/{$game->logo_small_file}" width="30" height="40"/></td></tr></table> </td>
	<td><h2>Turnier `{$cup->name|strip_tags|stripslashes}` L�schen</h2></td>
 </tr></table>
{include file="`$page_dir`/admin/cupmenu.tpl"}
<hr size="1"/>
{include file="etc/message.tpl"}

{if $success}
{else}

<form name="f" action="{$url_file}page={$url_page}&cup_id={$cup->id}&a=delete" method="post">
<table width="100%" background="images/modules/inetopia_cup/cup_delete.gif" style="background-repeat:no-repeat;" cellpadding="20">
 <tr><td>
 	<br/>
 	 <table cellpadding="0" cellspacing="2" width="100%" bgcolor="#C0C0C0">
 	  <tr><td bgcolor="#FFFFFF">
			<table border="0" cellpadding="10" cellspacing="1" width="100%">
			 <tr bgcolor="{#clr_content_border#}">
				<td colspan="2"><b>Turnierdaten unwiderruflich l�schen?</b></td>
			 </tr>
			 <tr bgcolor="{#clr_content#}">
			 	<td colspan="2">
			 		<table>
			 		 <tr>
			 		 	<td><input type="radio" name="delete_mode" value="all"/></td>
			 		 	<td><b>Komplettes Turnier l�schen</b></td>
					 </tr>
					</table>
			 	</td>
			 </tr>
			 <tr bgcolor="{#clr_content#}">
			 	<td colspan="2">
			 		<table>
			 		 <tr>
			 		 	<td><input type="radio" name="delete_mode" value="patches"/></td>
			 		 	<td><b>Einzelne Turnierdaten l�schen</b></td>
					 </tr>
					 <tr>
					 	<td></td>
					 	<td>
					 		<table cellpadding="5">
					 			<tr>
					 				<td><input type="checkbox" class="egl_checkbox" name="delete_matches" value="yes"/></td>
					 				<td>Alle Matches l�schen</td>
					 			</tr>
					 			<tr>
					 				<td><input type="checkbox" class="egl_checkbox" name="delete_encounts" value="yes"/></td>
					 				<td>Alle Begegnungen & Turnierstruktur l�schen</td>
					 			</tr>
					 			<tr>
					 				<td><input type="checkbox" class="egl_checkbox" name="delete_participants" value="yes"/></td>
					 				<td>Alle Teilnehmer l�schen</td>
					 			</tr>
					 		</table>
					 	</td>
					 </tr>
					</table>
			 	</td>
			 </tr>
			 <tr bgcolor="{#clr_content#}">
				<td colspan="2">
					<font color="red">Hiermit werden die ausgw�hlten Turnierdaten gel�scht!</font>
				</td
			 </tr>
			 <tr bgcolor="{#clr_content#}">
				<td colspan="2">{include file="buttons/bt_universal.tpl" link="javascript:document.f.submit();" caption="abschicken"}</td
			 </tr>
			</table>
			
	   </td></tr>
	  </table>
		
  </td></tr>
</table>
</form>
{/if}