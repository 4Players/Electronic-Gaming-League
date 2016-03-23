<h2>ManagedCron-Services</h2>

<table cellpadding="5" cellspacing="1" width="100%">
<tr bgcolor="{#clr_content#}">
	<td><b>Service-Name</b></td>
	<td><b>MC-ID</b></td>
	<td><b>Nutzer</b></td>
	<td><b>Tick-Rate</b></td>
	<td><b>URI</b></td>
</tr>
{section name=mc loop=$managedcrons}
<tr onmouseover="this.style.backgroundColor='#E8F6FF';"
	onmouseout="this.style.backgroundColor='';">
	<td><A href="{$CURRENT_MODULE_ID}:admin_managedcron&managedcron">{$managedcrons[mc]->name|strip_tags|stripslashes}</a></td>
	<td>{$managedcrons[mc]->managedcron_id}</a></td>
	<td>{$managedcrons[mc]->num_tasks}</a></td>
	<td>{$managedcrons[mc]->ticks}</a></td>
	<td>{$managedcrons[mc]->uri}</a></td>
</tr>
{/section}
</table>