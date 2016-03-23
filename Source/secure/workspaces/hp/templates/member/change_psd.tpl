<h2>{$LNG_BASIC.c4510}</h2>
{include file="devs/message.tpl"}

{if !$change_success }
	<form name="f" action="{$url_file}page={$url_page}&a=go" method="POST">
 	<table border="0" cellpadding="4" cellspacing="1" width="450" bgcolor="{#clr_content_border#}" align="center">
 	 <tr bgcolor="{#clr_content#}"><td>
		<table border="0" cellpadding="5" width="100%">	
	 	 <tr>	
	 		<td><b>{$LNG_BASIC.c4511}:</b></td>
	 		<td><input type=password class="egl_text" name="old_psd"></td>
	 	</tr>
	 	 <tr>	
	 		<td><b>{$LNG_BASIC.c4512}:</b></td>
	 		<td><input type=password class="egl_text" name="new_psd"></td>
	 	</tr>
	 	 <tr>	
	 		<td><b>{$LNG_BASIC.c4513}:</b></td>
	 		<td><input type=password class="egl_text" name="re_new_psd"></td>
	 	</tr>
	 	<tr>
	 		<td colspan="2" align="left">{include file="buttons/bt_universal.tpl" color=$GLOBAL_COLOR caption=$LNG_BASIC.c1018 link="javascript:document.f.submit();"}</td>
	 	</tr>
		</table>
	 </td></tr>
	</table>
	</form>
{/if}