<h2>{$LNG_BASIC.c1000}</h2>
{include file="devs/message.tpl"}

{if $login_success}
	{forwarding url="`$url_file`page=member.center" sec="5"}	
{/if}

{*Falls nicht eingeloggt, oder Login-Fehler => formular anzeigen*}
{if !($is_loggedin) AND !($login_success) }

	<table width="100%" border="0" cellpadding="4" cellspacing="1" align="center" bgcolor="{#clr_content_border#}">
	
	 <tr bgcolor="{#clr_content#}"><td align="center">
		 
		<form name="f" action="{$url_file}page={$url_page}&a=go" method="POST">
		 <table class='egl_base' border=0 cellpadding="5" cellspacing="5" width="100%">
	 	 <tr>
	 		<td width="100"><b>{$LNG_BASIC.c1002}:</b></td>
	 		<td><input class="egl_text" type="text" name="login_id" size="50"/></td>
	 	 </tr>
	 	 <tr>
	 		<td><b>{$LNG_BASIC.c1003}:</b></td>
	 		<td><input class="egl_text" type="password" name="login_psd" size="50" /></td>
	 	 </tr>
	 	 <tr>
	 	 	<td colspan="2">{include file="devs/hr_black.tpl" width="100%"}</td>
	 	 </tr>
	 	 <tr>
	 	 	<td colspan="2" align="center"> <b>{$LNG_BASIC.c1004}: </b> <input type="checkbox" name="login_cookies" value="yes" class="egl_checkbox"></td>
	 	 </tr>
	 	 <tr>
	 		<td colspan="2" align="center">{include file="buttons/bt_universal.tpl" color=$GLOBAL_COLOR caption=$LNG_BASIC.c1001 link="javascript:document.f.submit();"}</td>
	 	 </tr>
	 	 <tr>
	 	 	<td colspan="2" align="center"><A href="{$url_file}page=forgot_password"><b>{$LNG_BASIC.c1005}</b></a></td>
	 	 </tr>
	 	 <tr>
	 	 	<td colspan="2" align="center"><A href="{$url_file}page=signin"><b>{lng_parser content=$LNG_BASIC.c1006}</b></a></td>
	 	 </tr>
	 	 </table>
		</form>
	 </td></tr>
	</table>
	
{/if}

{*Bereits eingeloggt ?*}
{if ($is_loggedin)  }
	{* mach dies und das ;) => normaler HTML code *}
{/if}
