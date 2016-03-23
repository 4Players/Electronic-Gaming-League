<h2>{$LNG_BASIC.c8073} `{$member_data->nick_name|strip_tags|stripslashes}`</h2>
{include file="administration/member/header_menu.tpl"}
{include file="devs/hr2.tpl" width="100%"}
{include file="devs/message.tpl"}

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