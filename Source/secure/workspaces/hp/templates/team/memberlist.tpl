
<table border="0" width="100%" cellpadding="0" cellspacing="0">
 <tr><td><h2>{$LNG_BASIC.c2620} `<A href="{$url_file}page=team.info&team_id={$team_id}">{$team->name|strip_tags|stripslashes}</A>`</h2></td></tr>
 <tr><td>{include file="devs/hr_black.tpl" width="100%"}</td></tr>
</table>	

<table cellpadding="5" cellspacing="1"><tr>
<td>Sortieren nach:</td>
<td><select name="option_list" ONCHANGE="document.location.href='{$url_file}page={$url_page}&team_id={$team_id}&gameacctype_id='+this.options[this.selectedIndex].value;" style="width:200;">
	{section name=gameacc loop=$gameaccounts}
	{if $smarty.get.gameacctype_id == $gameaccounts[gameacc]->id }
		<option selected value="{$gameaccounts[gameacc]->id}">{$gameaccounts[gameacc]->name}</option>	
	{else}
		<option value="{$gameaccounts[gameacc]->id}">{$gameaccounts[gameacc]->name}</option>	
	{/if}
	{/section}
</select></td>
</tr>
</table>
<br/>

<table border="0" width="100%" cellpadding="5" cellspacing="1">
 <tr bgcolor="{#clr_content#}">
	<td><b>{$LNG_BASIC.c1020}</b></td>
	<td><b>{$LNG_BASIC.c4529}</b></td>
	<td><b>{$LNG_BASIC.c4541}</b></td>
 </tr>
 {section name=member loop=$memberlist}
  <tr>
	<td width="250"><A href="{$url_file}page=member.info&member_id={$memberlist[member]->member_id}">{$memberlist[member]->nick_name|strip_tags|stripslashes}</a></td>
	{if strlen($memberlist[member]->gameacc_value) > 0}
		<td>{$memberlist[member]->gameacc_value}</td>
	{else}
		<td>{$LNG_BASIC.c4542}</td>
	{/if}
	<td width="200">{date time=$memberlist[member]->gameacc_changed}</td>
  </tr>
 {/section}
</table>