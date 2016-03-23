<h2>Ladder `{$ladder->name|strip_tags|stripslashes}` Teilnehmer</h2>
{include file="`$page_dir`/admin/laddermenu.tpl"}

<hr size="1"/>

{include file="etc/message.tpl"}

{if $success}

{else}

{/if}