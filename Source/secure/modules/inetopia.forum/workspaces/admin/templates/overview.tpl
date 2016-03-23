{if isset($forum)}<h2>{$forum->name}</h2>
	<table>
	<tr>
		<td> > <a href="{$url_file}page={$CURRENT_MODULE_ID}:overview">Forumübersicht</a></td>
	</tr>
	{section name=fpath loop=$forum_path}
	{*if !$smarty.section.fpath.first}>{/if*}
	<tr>
	 <td>{section name=s loop=$smarty.section.fpath.index+1}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{/section} > <a href="{$url_file}page={$url_page}&forum_id={$forum_path[fpath]->id}">{$forum_path[fpath]->name}</b></a>
	</tr>
	{/section}
	</table>
	<br/>
{/if}

{if isset($forum)}
			<table border="0" cellpadding="10" cellspacing="1" width="100%">
			 <tr bgcolor="{#clr_content_border#}">
				<td colspan="2"><b>Moderatoren</b></td>
			 </tr>
		 	<tr bgcolor="{#clr_content#}">
				<td width="200"><b>Bereits eingetragen:</b></td>
			 	<td>
			 	{section name=admin loop=$forumadministrator}
			 		<a href="{$url_file}page=cms.member.central&member_id={$forumadministrator[admin]->member_id}">{$forumadministrator[admin]->nick_name}</a>[ <A href="{$url_file}page={$url_page}&forum_id={$forum->id}&permission_id={$forumadministrator[admin]->id}&a=delete_admin"><img border="0" src="images/admin/button_cancel_small.gif"/></a> ]
			 		{if !$smarty.section.admin.last},{/if}
			 	{/section}
			 	{if sizeof($forumadministrator)==0}Keine Admins eingetragen{/if}
			 	</td>
			</tr>
			<tr bgcolor="#FFF8F2">
			 	<td colspan="2>" align="right">
			 		<table>
					<form action="{$url_file}page={$url_page}&forum_id={$forum->id}&a=add_admin" method="POST">
					<input type=hidden name="permissions" value="forum.moderator"/>
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
					<form action="{$url_file}page={$url_page}&game_id={$game->id}&forum_id={$forum->id}&a=add_admin" method="POST">
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
{else}
			<table border="0" cellpadding="10" cellspacing="1" width="100%">
			 <tr bgcolor="{#clr_content_border#}">
				<td colspan="2"><b>Globale Moderatoren</b></td>
			 </tr>
		 	<tr bgcolor="{#clr_content#}">
				<td width="200"><b>Bereits eingetragen:</b></td>
			 	<td>
			 	{section name=admin loop=$globaladministrator}
			 		<a href="{$url_file}page=cms.member.central&member_id={$globaladministrator[admin]->member_id}">{$globaladministrator[admin]->nick_name}</a>[ <A href="{$url_file}page={$url_page}&forum_id={$forum->id}&permission_id={$globaladministrator[admin]->id}&a=delete_admin"><img border="0" src="images/admin/button_cancel_small.gif"/></a> ]
			 		{if !$smarty.section.admin.last},{/if}
			 	{/section}
			 	{if sizeof($globaladministrator)==0}Keine Admins eingetragen{/if}
			 	</td>
			</tr>
			<tr bgcolor="#FFF8F2">
			 	<td colspan="2>" align="right">
			 		<table>
					<form action="{$url_file}page={$url_page}&forum_id={$forum->id}&a=add_admin" method="POST">
					<input type=hidden name="permissions" value="forum.global.moderator"/>
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
					<form action="{$url_file}page={$url_page}&game_id={$game->id}&forum_id={$forum->id}&a=add_admin" method="POST">
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
{/if}


	<table cellpadding="5" border="0" cellspacing="1" width="100%">
	 <tr>
	 	<td></td>
	 	<td></td>
	 	<td></td>
	 	<td></td>
	 </tr>
	 <tr>
		<td colspan="3"><b>FORUM</b></td>
		<td width="200"><b>FUNKTIONEN</b></td>
	 </tr>
	 {if NOT ($forums[0]->section_id > 0)}
	 <tr>
	 	<td colspan="4"><hr style="border: 2px solid {#clr_content_border#};"/></td>
	 </tr>
	 {/if}	 
	 {section name=f loop=$forums}
	 {assign var="prev_forum_index" value=$smarty.section.f.index-1}
	 
	{if $smarty.section.f.index > 0 && $forums[f]->section_id != $forums[$prev_forum_index]->section_id}
	 <tr>
	 	<td></td>
	 	<td></td>
 	 	<td><form action="{$url_file}page={$url_page}&forum_id={$forum->id}&section_id={$forums[$prev_forum_index]->section_id}&a=addforum" method="POST"><input type="text" name="name" value=""/><input type=submit value="Forum hinzufügen"/></form></td>
	 </tr>
 	{/if}	 
	 
	 {if $forums[f]->section_id > 0 &&  $forums[f]->section_id != $forums[$prev_forum_index]->section_id  }
		 <tr bgcolor="{#clr_content#}">
		 	<td colspan="4">
		 	<table cellpadding="0" cellspacing="2"><tr>
		 		<td><a href="{$url_file}page={$url_page}&forum_id={$smarty.get.forum_id}&a=sup&sid={$forums[f]->section_id}"><img border="0" src="images/modules/inetopia_forum/up.gif"/></a></td>
	 			<td><a href="{$url_file}page={$url_page}&forum_id={$smarty.get.forum_id}&a=sdown&sid={$forums[f]->section_id}"><img border="0" src="images/modules/inetopia_forum/down.gif"/></a></td>
		 		<td><b>{$forums[f]->section_name}</b></td></td>
		 	</tr></table>
		 </tr>
	 {/if}
	 
	 {if $forums[f]->id}
	 <tr>
	 	<td width="20"><img src="http://www.electronicgamingleague.de/forum/templates/subSilver/images/folder_big.gif"/></td>
	 	<td width="60">
	 		<a href="{$url_file}page={$url_page}&forum_id={$smarty.get.forum_id}&a=fup&fid={$forums[f]->id}"><img border="0" src="images/modules/inetopia_forum/up.gif"/></a>
	 		<a href="{$url_file}page={$url_page}&forum_id={$smarty.get.forum_id}&a=fdown&fid={$forums[f]->id}"><img border="0" src="images/modules/inetopia_forum/down.gif"/></a>
	 	</td>
	 	<td><a href="{$url_file}page={$url_page}&forum_id={$forums[f]->id}"><b>{$forums[f]->name}</b></a><br/>{$forums[f]->description}</td>
	 		<td>
	 			<a href="">löschen</a> | <a href="">sychronisieren</a> | <a href="">bearbeiten</a>
		 	</td>
	 </tr>
	 {/if}
	 {/section}
	 <tr>
	 	<td></td>
	 	<td></td>
		 {assign var="f_lastitem" value=$forums|@count|tointeger}
		 {assign var="f_lastitem" value=$f_lastitem-1}
 	 	<td colspan="2"><form action="{$url_file}page={$url_page}&forum_id={$forum->id}&section_id={$forums[$f_lastitem]->section_id}&a=addforum" method="POST"><input type="text" name="name" value=""/><input type=submit value="Forum hinzufügen"/></form></td>
	 </tr>
	 <tr>
 	 	<td colspan="3"><form action="{$url_file}page={$url_page}&forum_id={$forum->id}&a=addsection" method="POST"><input type="text" name="name" value=""/><input type=submit value="Sektion hinzufügen"/></form></td>
	 </tr>
	</table>

	<br/><br/>

