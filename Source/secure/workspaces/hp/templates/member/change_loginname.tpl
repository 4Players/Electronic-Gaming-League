<h2>Login Name ändern</h2>


{* SHOW MESSAGE => nur wenn eine vorhanden ist*}
{include file="devs/message.tpl"}

{* Anzeigen, wenn nicht erfolreich *}
{if !$change_success }
	<form name="f" action="{$url_file}page={$url_page}&a=go" method="POST">
	
	<table border="0" cellpadding="5" cellspacing="1" width="50%" bgcolor="{#clr_content_border#}" align="center">
	<tr bgcolor="{#clr_content#}"><td>
		<table border="0" cellpadding="5">	
	 	 <tr>	
	 		<td><b>Neuer Login-Name:</b></td>
	 		<td><input type=text class="egl_text" name="changed_name"></td>
	 	</tr>
	 	<tr>
	 		<td></td>
	 		<td>{include file="buttons/bt_universal.tpl" color=$GLOBAL_COLOR caption="Abschicken" link="javascript:document.f.submit();"}</td>
	 	</tr>
		</table>
	</td></tr>
	</table>
	
	</form>
{/if}