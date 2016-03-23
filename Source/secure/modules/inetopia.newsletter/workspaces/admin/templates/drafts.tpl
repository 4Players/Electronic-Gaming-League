{if isset($draft)}
<h1>Vorlage</h1>

{if $draft_deleted}
	Vorlage wurde erfolgreich gelöscht.
{else}

<table width="100%" cellpadding="0" cellspacing="2" bgcolor="#C0C0C0">
 <tr><td bgcolor="#FFFFFF">
 
	<table border="0" cellpadding="0" cellspacing="1" width="100%">
	 <tr><td>
	 
		<table border="0" width="100%"  cellpadding="5" cellspacing="1">
		 <tr bgcolor="{#clr_content#}">
		 	<td valign="top" width="200"><b>Uhrzeit:</b></td>
		 	<td>{date format="am %d.%m.%y um %H:%M:%S Uhr"}</td>
		 </tr>
		 <tr bgcolor="{#clr_content#}">
		 	<td><b>Type:</b></td>
		 	<td>
		 		{if $draft->type == "standard"}Standard{/if}
		 		{if $draft->type == "html"}HTML{/if}
		 	</td>
		 </tr>
		 <tr bgcolor="{#clr_content#}">
		 	<td valign="top"><b>Von/Reply:</b><br><i>E-Mail:</i></td>
		 	<td> {$draft->from_email}</td>
		 </tr>
		 <tr bgcolor="{#clr_content#}">
		 	<td valign="top"><b>Von:</b><br><i>Name:</i></td>
		 	<td> {$draft->from_name}</td>
		 </tr>
		 <tr bgcolor="{#clr_content#}">
		 	<td valign="top"><b>Betreff:</b></td>
		 	<td> {$draft->title}</td>
		 </tr>
		 <tr bgcolor="{#clr_content#}">
		 	<td valign="top"><b>Nachricht:</b></td>
		 	<td>

			 	<table width="100%" cellpadding="0" cellspacing="0">
			 	 <tr>
			 	 	<td valign="top">{$draft->text|nl2br}</td>	 	
			 	 	<td><img src="images/spacer.gif" width="1" height="200"/></td>	 	
		 		 </tr>
		 		</table>
			 	 	
		 	</td>
		 </tr>
		 <tr bgcolor="{#clr_content#}">
		 	<td><b>Signatur:</b></td>
		 	<td>{$draft->signature}</td>
		 </tr>
		 <tr bgcolor="{#clr_content#}">
		 	<td><b>Austragen anhängen?</b></td>
		 	{if $draft->distribution_enabled}<td>Ja</td>{/if}
		 	{if NOT $draft->distribution_enabled}<td>Nein</td>{/if}
		 </tr>
		 <tr bgcolor="{#clr_content#}">
		 	<td></td>
		 	<td align="right">[ <A title="Mit dieser Vorlage einen Newsletter schicken" href="{$url_file}page={$CURRENT_MODULE_ID}:create&draft_id={$draft->id}"><b>Vorlage als Newsletter benutzen</b></a> ]</td>
		 </tr>
		</table>
		
	 </td></tr>
	</table>
	
 </td></tr>
</table>
{/if}


{elseif isset($draftlist)}
<h1>Vorlagen</h1>
<table width="100%" cellpadding="0" cellspacing="2" bgcolor="#C0C0C0">
 <tr><td bgcolor="#FFFFFF">

 		<table border="0" cellpadding="7" cellspacing="1" width="100%">
		 <tr bgcolor="{#clr_content_border#}">
		 	<td  colspan="1" width="1%"><img src="images/spacer.gif" width="25"/></td>
		 	<td><b>Betreff / Titel</b></td>
		 	<td width="200"><b>erstellt am:</b></td>
		 	<td width="1%"></td>
		 </tr>
			<tr background="images/admin/list_header_bg" style="background-repeat:repeat-y;" bgcolor="#EAE7E0">
				<td colspan="5"><b>Vorlagen</b></td>
			</tr>
		{section name=draft loop=$draftlist}
		 <tr bgcolor="{#clr_content#}" onclick="javascript:document.location='{$url_file}page={$CURRENT_MODULE_ID}:drafts&draft_id={$draftlist[draft]->id}&a=show';" onmouseover="textbox_set_style(this, 'unknown', '#F9F9F9', '#000000');" onmouseout="textbox_set_style(this, '#A80000', '', '#000000');">
		 	<td><A title="Vorlage als Newsletter benutzen" href="{$url_file}page={$CURRENT_MODULE_ID}:create&draft_id={$draftlist[draft]->id}&a=show"><img border="0" src="images/modules/inetopia_newsletter/admin/email_small.gif"/></a></td>
		 	{if strlen($draftlist[draft]->title) > 0}<td><A title="Vorlage anschauen"  href="{$url_file}page={$CURRENT_MODULE_ID}:drafts&draft_id={$draftlist[draft]->id}">{$draftlist[draft]->title}</a></td>{/if}
		 	{if strlen($draftlist[draft]->title) == 0}<td><A title="Vorlage anschauen"  href="{$url_file}page={$CURRENT_MODULE_ID}:drafts&draft_id={$draftlist[draft]->id}"><i>Kein Betreff / Titel vorhanden</i></a></td>{/if}
		 	<td>{date timestamp=$draftlist[draft]->created}</td>
		 	<td><A title="Vorlage löschen" href="{$url_file}page={$CURRENT_MODULE_ID}:drafts&draft_id={$draftlist[draft]->id}&a=delete"><img border="0" src="images/admin/small_delete.gif"/></a></td>
		 </tr>
		{/section}
		{if sizeof($draftlist) == 0}
			<tr bgcolor="{#clr_content#}">
				<td colspan="5">Keine Vorlagen gespeichert</td>
			</tr>
		{/if}
		</table>
  </td></tr>
 </table>
{else}
	Unbekannte Seite aufgerufen
{/if}