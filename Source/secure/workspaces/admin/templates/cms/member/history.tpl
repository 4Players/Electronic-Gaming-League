<h2>History `{$member_data->nick_name|strip_tags|stripslashes}`</h2>
<table>
<tr>
	<td>{include file="buttons/bt_universal.tpl" caption="Zentrale" link="`$url_file`page=cms.member.central&member_id=`$member_data->id`"}</td>
	<td>{include file="buttons/bt_universal.tpl" caption="Profil" link="`$url_file`page=cms.member.profile&member_id=`$member_data->id`"}</td>
	<td>{include file="buttons/bt_universal.tpl" caption="GameAccounts" link="`$url_file`page=cms.member.gameaccounts&member_id=`$member_data->id`"}</td>
	<td>{include file="buttons/bt_universal.tpl" caption="History" link="`$url_file`page=cms.member.history&member_id=`$member_data->id`"}</td>
	<td>{include file="buttons/bt_universal.tpl" caption="Adminrechte" link="`$url_file`page=cms.admin.central&member_id=`$member_data->id`"}</td>
</tr>
<tr>
	<td>{include file="buttons/bt_universal.tpl" caption="Löschen" link="`$url_file`page=cms.member.delete&member_id=`$member_data->id`"}</td>
</tr>
</table>
<hr size="1"/>

{include file="etc/message.tpl"}

{if $success}

{else}


<table border="0" cellpadding="5" cellspacing="1" width="100%">
  <tr bgcolor="{#clr_content_border#}">
		<td width="1%"><img src="images/spacer.gif" width="20"/></td>
		<td><b>Nachricht</b></td>
		<td width="200"><b>erstellt am</b></td>
  </tr>
  {section name=history loop=$historylist}
  <tr bgcolor="{#clr_content#}">
 	 	<td><A href="{$url_file}page={$url_page}&member_id={$member_data->id}&history_id={$historylist[history]->id}&a=delete"><img src="images/admin/small_delete.gif" border="0"/></a></td>
 	 	<td>{$historylist[history]->message}</td>
 	 	<td>{date timestamp=$historylist[history]->created}</td>
  </tr>
  {/section}
  {if sizeof($historylist)==0}<tr bgcolor="{#clr_content#}"><td colspan="3">Keine Eingräge vorhanden</td></tr>{/if}
 </table> 
{/if}