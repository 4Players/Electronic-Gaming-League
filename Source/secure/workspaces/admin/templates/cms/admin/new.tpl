<h2>Administrator hinzufügen</h2>
{include file="etc/message.tpl"}

{if $success}

{else}

<form action="{$url_file}page={$url_page}&a=add_admin" method="POST">
<table width="200" cellpadding="20" background="images/admin/administrator.gif" style="background-repeat:no-repeat;">
 <tr><td>
	<br/><br/><br/>
	<table width="100%" cellpadding="0" cellspacing="2" bgcolor="#C0C0C0">
	 <tr><td bgcolor="#FFFFFF">
		<table border="0" cellpadding="5" cellspacing="1" width="100%" >
		 <tr bgcolor="{#clr_content#}">
		 	<td width="200"><b>Mitglied-ID:</b></td>
		 	
		 	
		 	
		 	<td><input type="text" class="egl_text" name="member_id" size="50" value="{$smarty.get.member_id|tointeger}"/></td>
		 </tr>
		 <tr bgcolor="{#clr_content#}">
		 	<td></td> 
		 	<td><input type="image" src="images/buttons/new/bt_send.gif"/></td> 
		 </tr>
		</table>

	</td></tr>
   </table>

 </td></tr>
</table>
</form>

<font color="#A80000">Achtung: Rechte werden über die einzelnen Areale Vergeben.</font>

{/if}
