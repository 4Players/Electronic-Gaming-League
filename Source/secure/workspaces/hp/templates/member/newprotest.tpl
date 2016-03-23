{include file="devs/message.tpl"}
<form name="f" action="{$url_file}page={$url_page}&a=go" method="POST">
<table border="0" width="100%" cellpadding="0" cellspacing="0">
 <tr><td><h2>{$LNG_BASIC.c8200}</h2></td></tr>
 <tr><td>{include file="devs/hr_black.tpl" width="100%"}</td></tr>
</table>	
<table width="100%" cellpadding="5" cellspacing="1">
 <tr bgcolor="{#clr_content#}">
 	<td width="100"><b>{$LNG_BASIC.c1029}:</b></td>
 	<td><input name="match_id" type="text" value="{$MATCH_ID}" class="egl_text" style="width:100px;"/></td>
 </tr>
 <tr bgcolor="{#clr_content#}">
 	<td width="100"><b>{$LNG_BASIC.c8201}:</b></td>
 	<td><input name="subject" type="text" value="{if isset($smarty.post.subject)}{$smarty.post.subject}{/if}" class="egl_text" style="width:100%;"/></td>
 </tr>
 <tr bgcolor="{#clr_content#}">
 	<td valign="top"><b>{$LNG_BASIC.c8202}:</b></td>
 	<td><textarea name="text" class="egl_textbox" rows="20" style="width:100%;"/>{if isset($smarty.post.text)}{$smarty.post.text}{/if}</textarea></td>
 </tr>
 <tr bgcolor="{#clr_content#}">
 	<td align="center" colspan="2">{include file="buttons/bt_universal.tpl" color=$GLOBAL_COLOR caption=$LNG_BASIC.c1018 link="javascript:document.f.submit();"}</td>
 </tr>
</table>
</form>