<h2>Permission Tree</h2>

In this version, not administrateable
<br><br>

<table border=0 cellpadding=0 cellspacing=1 bgcolor="#C5C5C5" width="95%" align="center">
 <tr><td>
	 <table border="0" cellpadding="5" cellspacing="1" bgcolor="#F5F3EF" width="100%">
	    <tr>
	   		<td colspan="5"><b>Clan</b> </td>
	   	</tr>
	  {include file="page_setup/permissiontree_displaynode.tpl" node=$clan}
	 </table>
 </td></tr>
</table>


<table border=0 cellpadding=0 cellspacing=1 bgcolor="#C5C5C5" width="95%" align="center">
 <tr><td>
	 <table border="0" cellpadding="5" cellspacing="0" bgcolor="#F5F3EF" width="100%">
	    <tr>
	   		<td colspan="5"><b>Team</b> </td>
	   	</tr>
	{include file="page_setup/permissiontree_displaynode.tpl" node=$team}
	</table>
 </td></tr>
</table>

<table border=0 cellpadding=0 cellspacing=1 bgcolor="#C5C5C5" width="95%" align="center">
 <tr><td>
	 <table border="0" cellpadding="5" cellspacing="0" bgcolor="#F5F3EF" width="100%">
	    <tr>
	   		<td colspan="5"><b>Admin</b> </td>
	   	</tr>
	{include file="page_setup/permissiontree_displaynode.tpl" node=$admin}
	</table>
 </td></tr>
</table>