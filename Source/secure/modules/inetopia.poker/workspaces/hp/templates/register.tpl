{include file="devs/message.tpl"}
<h2>{$LNG_BASIC.c2400}</h2>


{if $signin_success }


{else}

	<form name="f" action="{$url_file}page={$url_page}&a=go" method="POST">
	<table border="0" cellpadding="4" cellspacing="1" align="center" bgcolor="{#clr_content_border#}" width="90%">
	 <tr bgcolor="{#clr_content#}">
		<td><b>{$LNG_BASIC.c1007}:</b></td>
	 	<td><input class="egl_text" type="text" name="email" value="{$_post.email}" style="width:200px;"></td>
	 </tr>
	 <tr bgcolor="{#clr_content#}">
	 	<td><b>Display Name:</b> </td>
	 	<td><input class="egl_text" type="text" name="display_name" value="{$_post.display_name}" style="width:200px;"></td>
	</tr>
	 <tr bgcolor="{#clr_content#}">
	 	<td><b>Kennwort eingeben:</b> </td>
	 	<td><input class="egl_text" type="password" name="password" value="" style="width:200px;"></td>
	</tr>
	 <tr bgcolor="{#clr_content#}">
	 	<td><b>Kenntwort erneut eingeben:</b> </td>
	 	<td><input class="egl_text" type="password" name="repassword" value="" style="width:200px;"></td>
	</tr>
	<tr bgcolor="{#clr_content_rel_border#}">
	 	<td colspan="2" align="center">{include file="buttons/bt_universal.tpl" color=$GLOBAL_COLOR caption=$LNG_BASIC.c1018 link="javascript:document.f.submit();"}</td>
	</tr>
	</form>
	</table>
{/if}