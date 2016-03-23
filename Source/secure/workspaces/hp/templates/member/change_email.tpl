<h2>{$LNG_BASIC.c4500}</h2>
{include file="devs/message.tpl"}

{if !$change_success }

	<form name="f" action="{$url_file}page={$url_page}&a=go" method="POST">
	<table border="0" cellpadding="5" cellspacing="1" width="100%" bgcolor="{#clr_content_border#}" align="center">
	<tr bgcolor="{#clr_content#}"><td align="center">	
		<table border=0 cellpadding="5" width="100%">	
		 <tr>	
	 		<td width="200"><b>{$LNG_BASIC.c4501}:</b></td>
	 		<td>{$current_email}</td>
	 	</tr>
	 	 <tr>	
	 		<td><b>{$LNG_BASIC.c4502}:</b></td>
	 		<td><input type=text class="egl_text" name="changed_email"></td>
	 	</tr>
	 	<tr>
	 		<td></td>
	 		<td>{include file="buttons/bt_universal.tpl" color=$GLOBAL_COLOR caption=$LNG_BASIC.c1018 link="javascript:document.f.submit();"}</td>
	 	</tr>
		</table>
	</td></tr>
	</table>
	</form>
	
{/if}