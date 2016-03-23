{if $success }
{include file="etc/message.tpl"}

{else}

<h1>Newsletter erstellen</h1>


<form name="form_newsletter" action="{$url_file}page={$CURRENT_MODULE_ID}:create&a=go" method="POST">

<table width="100%" cellpadding="0" cellspacing="2" bgcolor="#C0C0C0">
 <tr><td bgcolor="#FFFFFF">
	<table border="0" cellpadding="0" cellspacing="1" width="100%">
	 <tr><td>
		<table border="0" width="100%"  cellpadding="5" cellspacing="1">
		 <tr bgcolor="{#clr_content#}">
		 	<td valign="top" width="200"><b>Uhrzeit:</b></td>
		 	<td> {date format="am %d.%m.%y um %H:%M:%S Uhr"} </td>
		 </tr>
		 <tr bgcolor="{#clr_content#}">
		 	<td><b>Type:</b></td>
		 	<td>
		 	{if $draft}
		 		<select style="width:200;" class="egl_select" name="newsletter_type">
		 			{if $draft->type=="standard"}<option selected value="standard">Standart</option>{else}<option value="standard">Standart</option>{/if}
		 			{if $draft->type=="html"}<option selected value="html">HTML</option>{else}<option value="html">HTML</option>{/if}
		 		</select>
		 	{else}
		 		<select style="width:200;" class="egl_select" name="newsletter_type">
		 			<option value="standard">Standard</option>
		 			<option value="html">HTML</option>
		 		</select>
		 	{/if}
		 	</td>
		 </tr>
		 <tr bgcolor="{#clr_content#}">
		 	<td><b>MailingList:</b></td>
		 	<td>
		 		<select style="width:200;" class="egl_select" name="newsletter_mailinglist">
		 			<option selected value="newsletterlist">Newsletter-Liste</option>
		 			<option value="memberlist">Mitglieder-Liste</option>
		 			<option value="adminlist">Administrator-Liste</option>
		 		</select>
		 	</td>
		 </tr>
		 <tr bgcolor="{#clr_content#}">
		 	<td valign="top"><b>Von/Reply:</b><br><i>E-Mail:</i></td>
		 	<td>  <input type=text class="egl_text" value="{$draft->from_email}" name="newsletter_mailer_from_email" size="60"></td>
		 </tr>
		 <tr bgcolor="{#clr_content#}">
		 	<td valign="top"><b>Von:</b><br><i>Name:</i></td>
		 	<td>  <input type=text class="egl_text" value="{$draft->from_name}"  name="newsletter_mailer_from_name" size="60"></td>
		 </tr>
		 <tr bgcolor="{#clr_content#}">
		 	<td valign="top"><b>Betreff:</b></td>
		 	<td><input class="egl_text" type="text" name="newsletter_title" value="{$draft->title}" size="100"></td>
		 </tr>
		 <tr bgcolor="{#clr_content#}">
		 	<td valign="top"><b>Nachricht:</b></td>
		 	<td><textarea class="egl_textbox" style="width:100%;" name="newsletter_message" rows="20">{$draft->text}</textarea></td>
		 </tr>
		 <tr bgcolor="{#clr_content#}">
		 	<td><b>Signatur:</b></td>
		 	<td>
		 		<select style="width:200;" class="egl_select" name="newsletter_signature">
		 			<option value="non"> - Keine - </option>
		 			{section name=file loop=$mailer_signatures}
			 			{if $mailer_signatures[file] == $draft->signature}
			 				<option selected value="{$mailer_signatures[file]}">{$mailer_signatures[file]} </option>
			 			{else}
			 				<option value="{$mailer_signatures[file]}">{$mailer_signatures[file]} </option>
			 			{/if}
		 			{/section}
		 		</select>
		 	
		 	</td>
		 </tr>
		 <tr bgcolor="{#clr_content#}">
		 	<td><b>Austragen</b></td>
		 	{if isset($draft)}
		 		{if $draft->distribution_enabled}
		 			<td><input class="egl_checkbox" type=checkbox value="yes" name="newsletter_add_distribute" checked>Ja, anhängen! - <b>Nur bei Newsletter-Liste möglich!</b></td>
		 		{else}
		 			<td><input class="egl_checkbox" type=checkbox value="yes" name="newsletter_add_distribute">Ja, anhängen! - <b>Nur bei Newsletter-Liste möglich!</b></td>
		 		{/if}
		 	{else}
		 		<td><input class="egl_checkbox" type=checkbox value="yes" name="newsletter_add_distribute" checked>Ja, anhängen! - <b>Nur bei Newsletter-Liste möglich!</b></td>
		 	{/if}
		 </tr>
		 <tr bgcolor="{#clr_content#}">
		 	<td><b>Weitere Funktionen</b></td>
		 	<td>
		 		<select class="egl_select" name="newsletter_method">
		 				<option value="send_mail"> Keine </option>
		 				<option value="save_draft">Gesendeten Newsletter als Vorlage speichern </option>
		 				<option value="only_save_draft">Newsletter nur als Vorlage speichern [nicht abschicken]</option>
		 		</select>
		 	
		 	</td>
		 </tr>
		 <tr bgcolor="{#clr_content#}">
		 	<td></td>
		 	<td align="right"><input title="E-Mail verschicken" type="image" src="images/buttons/new/bt_send.gif"></td>
		 </tr>
		</table>
		
	 </td></tr>
	</table>
	
 </td></tr>
</table>
</form>
{/if}