{if !$admin}

	<h2>Dieses Mitglied hat keine Adminrechte</h2>
		
	<table><tr>
	<td>{include file="buttons/bt_universal.tpl" caption="Rechte vergeben" link="`$url_file`page=cms.admin.new&member_id=`$smarty.get.member_id`"}</td>
	<td>{include file="buttons/bt_universal.tpl" caption="Mitglieder Zentrale" link="`$url_file`page=cms.member.profile&member_id=`$smarty.get.member_id`"}</td>
	</tr></table>
	
{else}
	
	<h2>A-Zentrale `{$admin->nick_name|strip_tags|stripslashes}`</h2>
	
	<table><tr>
	<td>{include file="buttons/bt_universal.tpl" caption="Zentrale" link="`$url_file`page=cms.member.central&member_id=`$admin->member_id`"}</td>
	<!--#<td>{include file="buttons/bt_universal.tpl" caption="Profil" link="`$url_file`page=cms.member.profile&member_id=`$admin->member_id`"}</td>#-->
	</tr></table>
	
	<hr size="1"/>
	{include file="etc/message.tpl"}
	
	{if $success}
	{else}
	<table width="100%" border="0" cellpadding="5" cellspacing="10">
	 <tr>
		<td valign="top" width="50%">
			<!--## PAGE LEFT ##-->
			<form action="{$url_file}page={$url_page}&admin_id={$admin->id}&a=attribute" method="POST">
	 		<table border="0" cellpadding="5" cellspacing="1" width="100%">
	 		 <tr bgcolor="{#clr_content_border#}">
	 		 	<td colspan="2"><img src="images/admin/administrator_small_headerbg.gif"/> &nbsp;<b>Verwaltungs-Attribute</b></td>
	 		 </tr>
	 		 <tr bgcolor="{#clr_content#}">
			 	<td><b>Master Rechte</b></td>
			 	<td width="1%"><input type="checkbox" class="egl_checkbox" name="adminattribute_master" {section name=perm loop=$admin_permissions}{if $admin_permissions[perm]->permissions == 'master'}checked{/if}{/section} value="yes"/></td>
	 		 </tr>
	 		 <tr bgcolor="{#clr_content#}">
			 	<td><b>CMS</b></td>
			 	<td width="1%"><input type="checkbox" class="egl_checkbox" name="adminattribute_cms" {section name=perm loop=$admin_permissions}{if $admin_permissions[perm]->permissions == 'cms'}checked{/if}{/section} value="yes"/></td>
	 		 </tr>
	 		 <tr bgcolor="{#clr_content#}">
			 	<td><b>Mitglieder</b></td>
			 	<td width="1%"><input type="checkbox" class="egl_checkbox" name="adminattribute_members" {section name=perm loop=$admin_permissions}{if $admin_permissions[perm]->permissions == 'members'}checked{/if}{/section} value="yes"/></td>
	 		 </tr>
	 		 <tr bgcolor="{#clr_content#}">
			 	<td><b>Clans</b></td>
			 	<td width="1%"><input type="checkbox" class="egl_checkbox" name="adminattribute_clans" {section name=perm loop=$admin_permissions}{if $admin_permissions[perm]->permissions == 'clans'}checked{/if}{/section} value="yes"/></td>
	 		 </tr>
	 		  <tr bgcolor="{#clr_content#}">
			 	<td><b>Teams</b></td>
			 	<td width="1%"><input type="checkbox" class="egl_checkbox" name="adminattribute_teams" {section name=perm loop=$admin_permissions}{if $admin_permissions[perm]->permissions == 'teams'}checked{/if}{/section} value="yes"/></td>
	 		 </tr>
	 		 <!--#
	 		  <tr bgcolor="{#clr_content#}">
			 	<td><b>Onlinelist</b></td>
			 	<td width="1%"><input type="checkbox" class="egl_checkbox" name="adminattribute_onlinelist" {section name=perm loop=$admin_permissions}{if $admin_permissions[perm]->permissions == 'onlinelist'}checked{/if}{/section} value="yes"/></td>
	 		 </tr>
	 		 #-->
	 		  <tr bgcolor="{#clr_content#}">
			 	<td><b>Proteste</b></td>
			 	<td width="1%"><input type="checkbox" class="egl_checkbox" name="adminattribute_protests" {section name=perm loop=$admin_permissions}{if $admin_permissions[perm]->permissions == 'protests'}checked{/if}{/section} value="yes"/></td>
	 		 </tr>
	 		  <tr bgcolor="{#clr_content#}">
			 	<td><b>Matches</b></td>
			 	<td width="1%"><input type="checkbox" class="egl_checkbox" name="adminattribute_matches" {section name=perm loop=$admin_permissions}{if $admin_permissions[perm]->permissions == 'matches'}checked{/if}{/section} value="yes"/></td>
	 		 </tr>
	 		 <!--##
	 		 <tr bgcolor="{#clr_content#}">
			 	<td><b>Master?</b></td>
			 	<input type="checkbox" class="egl_checkbox" name="" value="yes"/>
	 		 </tr>
	 		 ##-->
	 		 <tr bgcolor="{#clr_content#}">
			 	<td align="right" colspan="2"><input type="image" src="images/buttons/new/bt_send.gif"/></td>
	 		 </tr>
			</table>
			</form>
		
		</td>
		<td valign="top">
			<!--## PAGE RIGHT ##-->
	
			<form action="{$url_file}page={$url_page}&admin_id={$admin->id}&a=permissions" method="POST">
	 		<table border="0" cellpadding="5" cellspacing="1" width="100%">
	 		 <tr bgcolor="{#clr_content_border#}">
	 		 	<td colspan="4"><img src="images/admin/adminpermissions_small_headerbg.gif"/> &nbsp;<b>Rechte Übersicht</b></td>
	 		 </tr>
		 	{section name=perm loop=$admin_permissions}
	 		 <tr bgcolor="{#clr_content#}">
		 		<td>{$admin_permissions[perm]->permissions|strtoupper}</td>
		 		<td>{$admin_permissions[perm]->data}</td>
		 		{if $admin_permissions[perm]->module_id != -1}<td> {$admin_permissions[perm]->module->sName}&nbsp;[ <b>{$admin_permissions[perm]->module_id}</b> ]</td>{/if}
		 		{if $admin_permissions[perm]->module_id == -1}<td>SYSTEM</td>{/if}
		 		<td width="1%"><a title="löschen?" href="{$url_file}page={$url_page}&admin_id={$admin->id}&a=delete_permission&permission_id={$admin_permissions[perm]->id}"><img src="images/admin/small_delete.gif" border="0"/></a></td>
	 		 </tr>
		 	{/section}
		 	{if sizeof($admin_permissions)==0}
	 		 <tr bgcolor="{#clr_content#}">
		 		<td colspan="4">Keine Rechte vorhanden</td>
			</tr>	 		
		 	{/if}
			</table>
			</form>	
		
	
		</td>
	  </tr>
	</table>
	{/if}
{/if}