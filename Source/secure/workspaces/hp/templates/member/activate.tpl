<h2>{$LNG_BASIC.c1008}</h2>
{include file="devs/message.tpl"}

{if !$SUCCESS}
	<form name="f" action="{$url_file}page={$url_page}&member_id={$smarty.get.member_id}&code={$smarty.get.code}&a=activate" method="POST">
	<table cellpadding="5">
	 <tr>
	 	<td>{$LNG_BASIC.c2306}:</td>
	 	<td><input name="newpassword" type="password" class="egl_text"/>
	 </tr>
	 <tr>
	 	<td>{$LNG_BASIC.c2307}:</td>
	 	<td><input name="re_newpassword" type="password" class="egl_text"/>
	 </tr>
	 <tr>
	 	<td colspan="2">{include file="buttons/bt_universal.tpl" color=$GLOBAL_COLOR caption=$LNG_BASIC.c1018 link="javascript:document.f.submit();"}
	 </tr>
	</table>
	</form>
{/if}