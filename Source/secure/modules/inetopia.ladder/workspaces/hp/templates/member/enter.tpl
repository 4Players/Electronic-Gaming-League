<h2>{lng_parser content=$LNG_MODULE.c9201 ladder=$ladder->name|strip_tags|stripslashes}</h2>
{include file="devs/message.tpl"}
{if $success}
{else}	
	{if $join_access}
	<br/>
	<table cellpadding="5" cellspacing="1">
	 <tr>
	 	<td>Ja, ich möchte jetzt dieser Ladder beitreten!</td>
	 	<td>
	 	{include file="buttons/bt_universal.tpl" color=$GLOBAL_COLOR link="`$url_file`page=`$url_page`&ladder_id=`$ladder->id`&a=join" caption=$LNG_BASIC.c1100}
	 	</td>
	 </tr>
	</table>
	{else}
		<!--# no join access #-->
		<b>{$LNG_MODULE.c9202}</b><br/>
		<br/>
		<table cellpadding="5" cellspacing="1">
		{section name=f loop=$failed_rules}
		 <tr>
		 	<td>&#x95;</td>
		 	<td><font color="red">{$failed_rules[f]}</font></td>
		 </tr>
		 {/section}
		</table>
		 	
	
	{/if}
{/if}