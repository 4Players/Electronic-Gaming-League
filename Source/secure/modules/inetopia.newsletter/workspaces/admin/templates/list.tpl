<h1> Liste bearbeiten </h1>


<table cellpadding="0" cellspacing="2" bgcolor="#C0C0C0" width="100%">
 <tr><td bgcolor="#FFFFFF">

	<table border="0" cellpadding="5" cellspacing="1" width="100%">
	{section name=iN loop=$newsletter}
	 <tr bgcolor="{#clr_content#}">
	   <td> 
	   		<table border="0" cellpadding="2" cellspacing="0" width="100%">
	   		 <tr>
	   		 	<td><b>Eingetragen am {date timestamp=$newsletter[iN]->created format="%d.%m.%y / <i>%H:%M:%S Uhr</i>"}</b></td>
	   		 	<td width="130">{$newsletter[iN]->num_mails} E-Mails erhalten  </td>
	   		 </tr>
	   		 <tr>
	   		 	<td colspan="2">&#187;  <A title="Nachricht an {$newsletter[iN]->email} schicken" href="mailto:{$newsletter[iN]->email}"><b>{$newsletter[iN]->email}</b></a> </td>
	   		 </tr>
	   		 <tr>
	   		 	<td colspan="2">Code:< {$newsletter[iN]->code} </td>
	   		 </tr>
	   		 <tr>
	   		 	<td colspan="2" align="right">[ <A title="löschen" href="{$url_file}page={$CURRENT_MODULE_ID}:list&mail_id={$newsletter[iN]->id}&a=delete"><b>löschen</b></a>  ]</td>
	   		 </tr>
	   		</table>
	   
	   	</td>
	 </tr>
	{/section}
	{if sizeof($newsletter)==0}<tr><td>Keine E-Mail eingetragen.</td></tr>{/if}
	</table>
 </td></tr>
</table>