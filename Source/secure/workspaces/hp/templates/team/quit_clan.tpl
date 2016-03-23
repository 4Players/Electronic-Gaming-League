<h2>Clan verlassen</h2>
{include file="devs/message.tpl"}

{if isset($clan)}
<table cellpadding="10">
 <tr><td>Hiermit möchte wir, das Team `<A href="{$url_file}page=team.info&team_id={$team->id}">{$team->name|strip_tags|stripslashes}</a>`, den Clan `<A href="{$url_file}page=clan.info&clan_id={$clan->id}">{$clan->name|strip_tags|stripslashes}</a>` verlassen.</td>
 	 <td>{include file="buttons/bt_universal.tpl" color=$GLOBAL_COLOR caption="bestätigen" link="javascript:document.location.href='`$url_file`page=`$url_page`&team_id=`$team->id`&a=confirm';" }</td></tr>
</table>
{/if}