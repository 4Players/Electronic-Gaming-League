 <h2>{$LNG_BASIC.c4621}</h2>
{include file="devs/message.tpl"}

{if !$success}

  <table border=0 cellpadding="1" cellspacing="0" bgcolor="{#clr_content_border#}" width="100%">
   <tr><td>
   
 	<table border="0" cellpadding="6" cellspacing="1" bgcolor="{#clr_content#}" width="100%">
	{section name=invite loop=$clan_invites}
	 <tr><td colspan="2"><A href="{$url_file}page=clan.info&clan_id={$clan_invites[invite]->id}"><b>{$clan_invites[invite]->name|strip_tags}</b></a></td></tr>
	 <tr>
	 
	 	{if $clan_invites[invite]->logo_file != 'non'}
	 		<td width="1%" valign="top"> <table border="0" cellpadding="0" cellspacing="1" bgcolor="{#clr_content_border#}"><tr><td>	<img width="100" heigth="100" src="{$path_logos}clans/{$clan_invites[invite]->logo_file}"></td></tr></table></td>
	 	{else}
	 		<td width="1%" valign="top"> <table border="0" cellpadding="0" cellspacing="1" bgcolor="{#clr_content_border#}"><tr><td>	<img width="100" heigth="100" src="images/logo.na.jpg"> </td></tr></table></td>
	 	{/if}

	 	{if strlen($clan_invites[invite]->invite_text) > 0}
	 		<td valign="top">{$clan_invites[invite]->invite_text|strip_tags|bbcode2html|nl2br}</td
	 	{else}
	 		<td align="center" valign="center">{$LNG_BASIC.c4640}</td>
	 	{/if}
	 </tr>
	 <tr>
	 	<td></td>
	 	{if $clan_invites[invite]->processed}
	 		{if $clan_invites[invite]->accepted} <td align="right"><b><font color="">{$LNG_BASIC.c4622}!</font></b></td> {/if}
	 		{if !$clan_invites[invite]->accepted} <td align="right"><b><font color="#A80000">{$LNG_BASIC.c4623}!</font></b></td> {/if}
	 	{else}
	 		<td align="right">
	 			<table cellpadding="0" cellspacing="0"><tr>
	 			<td>{include file="buttons/bt_universal.tpl" color=$GLOBAL_COLOR caption=$LNG_BASIC.c4624 link="javascript:document.location.href='`$url_file`page=`$url_page`&invite_id=`$clan_invites[invite]->invite_id`&a=accept';"}</td>
	 			<td>{include file="buttons/bt_universal.tpl" color=$GLOBAL_COLOR caption=$LNG_BASIC.c4625 link="javascript:document.location.href='`$url_file`page=`$url_page`&invite_id=`$clan_invites[invite]->invite_id`&a=deny';"}</td>
	 			</table>
	 		</td>
 		{/if}
	 </tr>
	 <tr><td colspan="2"><hr size=1 color="{#clr_content_border#}"></td></tr>
	 {/section}
	</table>
	
   </td></tr>
 </table>

{/if}