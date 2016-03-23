{if isset($CHALLENGE)}
	<h2>{$LNG_MODULE.c1200}</h2>
	<br/>
	<form name="f" action="{$url_file}page={$url_page}&challenge_id={$smarty.get.challenge_id}&a=deny" method="POST">
	Begründung:
	<table cellpadding="5" width="100%">
	 <tr>
	 	<td><textarea name="reason" class="egl_text" style="width:100%;" rows="10"></textarea></td>
	 </tr>
	</table>
	
	<table>
	 <tr>
	 	<td>{$LNG_MODULE.c1201}</td>
	 	<td>{include file="buttons/bt_universal.tpl" caption=$LNG_BASIC.c1018 color=$GLOBAL_COLOR link="javascript:document.f.submit();"}</td>
	 </tr>
	</table>
	</form>
{/if}