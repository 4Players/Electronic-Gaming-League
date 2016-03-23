<h2>Ladder `{$ladder->name|strip_tags|stripslashes}` Administratoren</h2>
{include file="`$page_dir`/admin/laddermenu.tpl"}
<hr size="1"/>
{include file="etc/message.tpl"}

{if $success}
{else}
<table width="100%" background="images/modules/inetopia_ladder/ladder_administrator.gif" style="background-repeat:no-repeat;" cellpadding="20">
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
			 	{section name=admin loop=$ladderadministrator}
			 		<A title="Mehr Informationen?" href="{$url_file}page=cms.member.central&member_id={$ladderadministrator[admin]->member_id}"><b>{$ladderadministrator[admin]->nick_name}</b></a>[ <A title="Admin entfernen" href="{$url_file}page={$url_page}&ladder_id={$ladder->id}&permission_id={$ladderadministrator[admin]->id}&a=delete_admin"><img border="0" src="images/admin/button_cancel_small.gif"/></a> ]
			 		{if !$smarty.section.admin.last},{/if}
			 	{/section}
			 	{if sizeof($ladderadministrator)==0}Keine Admins eingetragen{/if}
			 	</td>
			</tr>
			<tr bgcolor="#FFF8F2">
			 	<td colspan="2>" align="right">
			 		<table cellpadding="5">
					<form name="f_add_adminname" action="{$url_file}page={$url_page}&game_id={$game->id}&ladder_id={$ladder->id}&a=add_admin" method="POST">
			 		 <tr>
					 	<td><b>Admin:</b></td>
					 	<td width="100">
					 		<select name="admin_id" style="width:180" class="egl_select">
					 			<option>---- Bitte wählen ---- </option>
					 			{section name=admin loop=$adminlist}
					 				<option value="{$adminlist[admin]->id}">{$adminlist[admin]->nick_name|strip_tags|stripslashes}</option>
					 			{/section}
					 		</select>
					 	</td>
					 	<td>{include file="buttons/bt_universal.tpl" link="javascript:document.f_add_adminname.submit();" caption="hinzufügen"}</td>
					 </tr>
					</form>
					<form name="f_add_adminid" action="{$url_file}page={$url_page}&game_id={$game->id}&ladder_id={$ladder->id}&a=add_admin" method="POST">
					 <tr>
					 	<td><b>Admin-ID:</b></td>
					 	<td><input name="admin_id" type="text" size="10" class="egl_text"/></td>
					 	<td>{include file="buttons/bt_universal.tpl" link="javascript:document.f_add_adminid.submit();" caption="hinzufügen"}</td>
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