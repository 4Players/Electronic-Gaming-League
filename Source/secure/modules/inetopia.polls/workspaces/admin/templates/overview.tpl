<h2>Polls bearbeiten</h2>

<table border="0" cellpadding="0" cellspacing="2" bgcolor="#C0C0C0" width="100%">
 <tr><td bgcolor="#FFFFFF">
 
	<table border="0" cellpadding="0" cellspacing="1" width="100%">
	 <tr><td>
	 	<table border="0" cellpadding="5" cellspacing="1" width="100%">
			<tr bgcolor="#E8E5DE">
	 			<td width="1%"></td>
	 			<td><b>Umfrage:</b></td>
	 			<td><b>Anz. Antworten:</b></td>
	 		</tr>
			{section name=poll loop=$polls}
			<tr bgcolor="{#clr_content#}">
			 	<td><A title="Umfrage bearbeiten" href="{$url_file}page={$CURRENT_MODULE_ID}:admin&poll_id={$polls[poll]->id}"><img border=0 src="images/modules/inetopia_polls/small_edit.gif" border="0"/></a></td>
			 	<td><A title="Umfrage bearbeiten" href="{$url_file}page={$CURRENT_MODULE_ID}:admin&poll_id={$polls[poll]->id}"><b>{$polls[poll]->question}</b></a><br>
			 	erstellt am {date timestamp=$polls[poll]->created}, 
			 	{if $polls[poll]->lock_ip} <b>IP-Lock</b>
			 	{elseif $polls[poll]->lock_memberid} <b>MemberID-Lock</b> 
			 	{else}<b>Keine Sperre</b>	{/if},
			 	Exp. Date: {date timestamp=$polls[poll]->end_time}
			 	
			 	</td>
			 	<td>{$polls[poll]->num_pollanswers}</td>
			 </tr>
			{/section}
	 </td></tr>
	</table>
	
 </td></tr>
</table>