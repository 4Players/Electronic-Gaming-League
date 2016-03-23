{**********************************************}
{* ONLY SHOW => $msg_title/$msg_text FILLED *}
{**********************************************}

{if $msg_title || $msg_text }
<br>
<table border="0" cellpadding="5" cellspacing="1" width="100%" align="center" bgcolor="{#clr_content_header#}">
 <tr><td bgcolor="#FFFFFF" valign="top">
 	<table border=0  border="0" cellpadding="0" cellspacing="15" ><tr>
 		<td valign='top' width=15% align='center'>
 				{*Zeige das richtige Bild an *}
 				{if $msg_type == 'success'}<img src='images/success2.gif'>{/if}
 				{if $msg_type == 'warning'}<img src='images/warning3.gif'>{/if}
 				{if $msg_type == 'error'}<img src='images/error4.gif'>{/if}
 				{if $msg_type == 'info'}<img src='images/info2.gif'>{/if}
 			</td>
 		<td><font color="#000000">

 		<b>{eval var=$msg_text}</b>
		
 		{* ONLY SHOW ERRORS => ARRAY WAS FILLED *}
 		{if $msg_errors}	<br><br>
 		
	 		{* LOOP Schleife *}
 			{section name=index loop=$msg_errors}
 				<li> {$msg_errors[index]} </li>
 			{/section}
 		{/if}
 		<br/><br/><div><a href="JavaScript:history.back(1)"><b>Zur&uuml;ck</b></a></div>
 		</font>
	 </td>
 	</tr>
 	</table>
 </td></tr>
</table>
<br><br>
{/if}