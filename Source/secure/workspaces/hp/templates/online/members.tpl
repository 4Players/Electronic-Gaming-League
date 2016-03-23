<h2>{$LNG_BASIC.c4700}</h2>
{lng_parser content=$LNG_BASIC.c4701 num_members=$num_onlineuser num_invisible=$num_invisible_onlineuser}

<br/><br/>
<table width="100%" cellpadding="5" cellspacing="1">
 <tr>
 	<td><b>{$LNG_BASIC.c1020}</b></td>
 	<td><b>{$LNG_BASIC.c4702}</b></td>
 </tr>
<tr><td colspan="3">{include file="devs/hr_black.tpl" width="100%"}</td></tr>
{section name=m loop=$online_member}
{if !$online_member[m]->invisible}
 <tr>
 	<td><A href="{$url_file}page=member.info&member_id={$online_member[m]->member_id}">{$online_member[m]->nick_name|strip_tags|stripslashes}</a></td>
 	<td>{date timestamp=$online_member[m]->last_action}</td>
 </tr>
{/if}
{/section}
</table>