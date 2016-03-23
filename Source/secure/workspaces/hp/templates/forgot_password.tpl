<h2>{$LNG_BASIC.c2301}</h2>
{include file="devs/message.tpl"}


{if !$success}
<form name="f" method="POST" action="{$url_file}page={$url_page}&a=go">
	<table border="0" cellpadding="5" cellspacing="1" bgcolor="{#clr_content_border#}" width="100%">
	 <tr bgcolor="{#clr_content#}">
	 	<td width="30%"><b>{$LNG_BASIC.c1007} *</b></td>
	 	<td><input type="text" class="egl_text" size="50" name="fp_email"></td>
	 </tr>
	 <tr bgcolor="{#clr_content_rel#}">
		<td colspan="2" align="center">
			<table>
			<tr>
			<td>{include file="buttons/bt_universal.tpl" color=$GLOBAL_COLOR caption=$LNG_BASIC.c1018 link="javascript:document.f.submit();"}</td>
			<td>{include file="buttons/bt_universal.tpl" color=$GLOBAL_COLOR caption=$LNG_BASIC.c9804 link="javascript:document.f.reset();"}</td>
			</tr>
			</table>
		</td>
	 </tr>
	 </table>
 </form>
 {/if}