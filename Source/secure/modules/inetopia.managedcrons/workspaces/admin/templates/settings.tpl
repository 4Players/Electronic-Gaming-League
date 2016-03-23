{include file="devs/message.tpl"}

<form name="remoteaccess" action="{$url_file}page={$url_page}&a=change" method="POST">
<table cellpadding="5" cellspacing="1" bgcolor="{#clr_content_border#}" width="100%">
 <tr bgcolor="{#clr_content_border#}">
 	<td colspan="2"><b>ManagedCron Service konfigurieren:</b></td>
 </tr>
 <tr bgcolor="{#clr_content#}">
 	<td width="200"><b>Key:</b></td>
 	<td><input type="text" class="egl_text" style="width:100%;" name="key" value="{$key}"/></td>
 </tr>
 <tr bgcolor="{#clr_content#}">
 	<td><b>Server-URL:</b></td>
 	<td><input type="text" class="egl_text" style="width:100%;" name="server_url" value="{$server_url}"/></td>
 </tr>
 <tr bgcolor="{#clr_content#}">
 	<td colspan="2">{include file="buttons/bt_universal.tpl" caption="übernehmen" link="javascript:document.remoteaccess.submit();"}</td>
 </tr>
</table>
</form>