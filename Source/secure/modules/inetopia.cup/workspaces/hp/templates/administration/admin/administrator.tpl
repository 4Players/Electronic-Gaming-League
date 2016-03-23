<table cellpadding="5"><tr>
	<td><table cellpadding="1" cellspacing="0" bgcolor="#000000"><tr><td><img src="{$PATH_GAMES}small/{$game->logo_small_file}" width="30" height="40"/></td></tr></table> </td>
	<td><h2>Turnier `{$cup->name|strip_tags|stripslashes}` Administratoren</h2></td>
 </tr></table>
{include file="`$page_dir`/cupmenu.tpl"}
<hr size="1"/>
{include file="devs/message.tpl"}

{if $success}
{else}
<table width="100%" background="images/modules/inetopia_cup/cup_administration.gif" style="background-repeat:no-repeat;" cellpadding="20">
 <tr><td>
 	<br/>
 	 <table cellpadding="0" cellspacing="2" width="100%" bgcolor="#C0C0C0">
 	  <tr><td bgcolor="#FFFFFF">
			<table border="0" cellpadding="10" cellspacing="1" width="100%">
			 <tr bgcolor="{#clr_content_border#}">
				<td colspan="2"><b>Administratoren</b></td>
			 </tr>
		 	<tr bgcolor="{#clr_content#}">
				<td width="200"><b>Bereits eingetragen:</b></td>
			 	<td>
			 	{section name=admin loop=$cupadministrator}
			 		<A title="Mehr Informationen?" href="{$url_file}page=cms.member.central&member_id={$cupadministrator[admin]->member_id}"><b>{$cupadministrator[admin]->nick_name}</b></a>[ <A title="Admin entfernen" href="{$url_file}page={$url_page}&cup_id={$cup->id}&permission_id={$cupadministrator[admin]->id}&a=delete_admin"><img border="0" src="images/admin/button_cancel_small.gif"/></a> ]
			 		{if !$smarty.section.admin.last},{/if}
			 	{/section}
			 	{if sizeof($cupadministrator)==0}Keine Admins eingetragen{/if}
			 	</td>
			</tr>
			<tr bgcolor="#FFF8F2">
			 	<td colspan="2>" align="right">
			 		<table>
					<form action="{$url_file}page={$url_page}&cup_id={$cup->id}&a=add_admin" method="POST">
			 		 <tr>
					 	<td><b>Admin</b></td>
					 	<td width="100">
					 		<select name="admin_id" style="width:180" class="egl_select">
					 			<option>-- Admin wählen --</option>
					 			{section name=admin loop=$adminlist}
					 				<option value="{$adminlist[admin]->id}">{$adminlist[admin]->nick_name}</option>
					 			{/section}
					 		</select>
					 	</td>
					 	<td><input type="image" src="images/buttons/new/bt_send.gif"/></td>
					 </tr>
					</form>
					<form action="{$url_file}page={$url_page}&game_id={$game->id}&cup_id={$cup->id}&a=add_admin" method="POST">
					 <tr>
					 	<td><b>Admin-ID</b></td>
					 	<td><input name="admin_id" type="text" size="10" class="egl_text"/></td>
					 	<td><input type="image" src="images/buttons/new/bt_send.gif"/></td>
					 </tr>
					</form>
			 		</table>
			 	</td>
			 </tr>
			</table>
			
	   </td></tr>
	  </table>
		
  </td></tr>
</table>


{/if}