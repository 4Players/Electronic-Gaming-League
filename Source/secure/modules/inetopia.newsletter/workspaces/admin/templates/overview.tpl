<table width="100%" cellpadding="0" cellspacing="2">
 <tr><td>
 
 		<table border="0" cellpadding="5">
 		 <tr>
 		 	<td align="center"><A title="Vorlagen öffnen" href="{$url_file}page={$CURRENT_MODULE_ID}:drafts"><img src="images/modules/inetopia_newsletter/admin/drafts.gif" border="0"/></a></td>
 		 </tr>
 		 <tr>
			<td align="center"><b>Vorlagenspeicher</b></td> 		 
 		 </tr>
 		</table>
	
 </td></tr>
</table>

<hr size="1"/>
<br/>

<table border="0" width="400" cellpadding="5" cellspacing="1">
 <tr bgcolor="{#clr_content_border#}">
	<td colspan="2"><b>Statistik</b> </td>
 </tr>
 <tr bgcolor="{#clr_content#}">
	<td width="50%"><b>Eingetragene E-Mails:</b> </td>
	<td> {$stats->num_mails} </td>
 </tr> 
 <tr bgcolor="{#clr_content#}">
	<td width="50%"><b>Verschickte E-Mails:</b> </td>
	<td> {$stats->num_sent_mails} </td>
 </tr> 
 <tr bgcolor="{#clr_content#}">
	<td width="50%"><b>Vorlagen im Speicher:</b> </td>
	<td> {$stats->num_drafts} </td>
 </tr>
</table>