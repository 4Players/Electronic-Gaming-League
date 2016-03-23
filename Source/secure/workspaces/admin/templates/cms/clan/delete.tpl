<h2>Clan löschen</h2>
{include file="cms/clan/header_menu.tpl"}
<hr size="1"/>
{include file="etc/message.tpl"}


{if !$success}
	<table border="0">
	{section name=mod loop=$response_messages}
	<tr><td><font style="font-size:14px;"><b>{$response_messages[mod].module_name}</b></font></td></tr>
		{section name=msg loop=$response_messages[mod].responses }
		<tr><td>{$response_messages[mod].responses[msg]}</td></tr>
		{sectionelse}
		<tr><td><i>KEINE NACHRICHTEN</i></td></tr>
		{/section}
	{/section}
	</table>
	
	<br/>
	<div>
		<table cellpadding="5">
		 <tr>
			<td><b>Bitte Clan `{$clan->name|strip_tags|stripslashes}` jetzt löschen</b></td>
			<td>{include file="buttons/bt_universal.tpl" caption="weiter" link="javascript:document.location.href='`$url_file`page=`$url_page`&clan_id=`$clan->id`&a=delete';"}</td>
		 </tr>
		</table>
	</div>
{/if}