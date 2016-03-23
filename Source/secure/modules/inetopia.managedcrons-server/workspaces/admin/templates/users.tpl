<h2>Nutzer</h2>

<table cellpadding="5" cellspacing="1" width="100%">
<tr bgcolor="{#clr_content#}">
	<td><b>ID</b></td>
	<td><b>Nick-Name</b></td>
	<td><b>Anz. Dienste</b></td>
	<td><b>URL</b></td>
</tr>
{section name=u loop=$users}
<tr onmouseover="this.style.backgroundColor='#E8F6FF';"
	onmouseout="this.style.backgroundColor='';">
	<td>{$users[u]->member_id}</td>
	<td>{$users[u]->nick_name|strip_tags|stripslashes}</td>
	<td>{$users[u]->num_tasks}</td>
	<td>{$users[u]->url}</td>
</tr>
{/section}
</table>