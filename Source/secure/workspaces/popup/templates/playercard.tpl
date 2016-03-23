{* SHOW MESSAGE => nur wenn eine vorhanden ist*}
{include file="devs/message.tpl"}
{if $player_card_data}
	{include file="etc/member.playercard.tpl"}
{/if}