<h2>{$LNG_MODULE.c1303}</h2>
{include file="devs/message.tpl"}

{if !$SUCCESS}
{$LNG_MODULE.c1302}
<br/><br/>
<form name="f" action="{$url_file}page={$url_page}&team_id={$smarty.get.team_id}&a=quit" method="POST">
<table cellpadding="5">
 <tr>
 	<td colspan="2">
 		<select class="egl_select" style="width:300px;" name="ladder_id">
 		{section name=ladder loop=$LADDERS}
 			<option value="{$LADDERS[ladder]->id}">{$LADDERS[ladder]->name|strip_tags|stripslashes} ({$LADDERS[ladder]->points})</option>
 		{/section}
 		</select>
 	</td>
 </tr>
 <tr>
 	<td>{$LNG_MODULE.c1304}</td>
	<td>{include file="buttons/bt_universal.tpl" color=$GLOBAL_COLOR caption=$LNG_BASIC.c1018 link="javascript:document.f.submit();"}</td> 
 </tr>
</table>
</form>
{/if}