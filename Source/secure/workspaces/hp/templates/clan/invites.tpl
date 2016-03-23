<h2>{$LNG_BASIC.c4621}</h2>
{include file="devs/message.tpl"}
{if !$success}

	<table border="0" width="100%" cellpadding="5" cellspacing="1">
	 <tr bgcolor="{#clr_content_border#}">
	  	<td><b>{$LNG_BASIC.c1020}:</b></td>
	  	<td><b>{$LNG_BASIC.c4629}:</b></td>
	  	<td><b>{$LNG_BASIC.c4628}:</b></td>
	  	<td width="15%"></td>
	  </tr>
	  {section name=invite loop=$clan_invites}
	   <tr bgcolor="{#clr_content#}">
	   		<td><A href="{$url_file}page=member.info&member_id={$clan_invites[invite]->id}">{$clan_invites[invite]->nick_name|strip_tags|stripslashes}</a></td>
	   		<td>{date timestamp=$clan_invites[invite]->invite_created}</td>
	   		
	   		
	   		{if $clan_invites[invite]->processed}
		   		{if $clan_invites[invite]->accepted}
			   		<td><font color="{#clr_rank_green#}">{$LNG_BASIC.c4623}</font></td>
		   		{else}
			   		<td><font color="{#clr_rank_red#}">{$LNG_BASIC.c4622}</font></td>
		   		{/if}
	   		{else}
		   		<td>{$LNG_BASIC.c1402}</td>
	   		{/if}
	  		
	   		{if !$clan_invites[invite]->processed}
		   		<td align="center">
			   		{include file="buttons/bt_universal.tpl" color=$GLOBAL_COLOR caption=$LNG_BASIC.c4630 link="javascript:document.location.href='`$url_file`page=`$url_page`&clan_id=`$_get.clan_id`&invite_id=`$clan_invites[invite]->invite_id`&a=delete';"}
		   		</td>
	   		{else}
		   		<td></td>
		   	{/if}
	   </tr>
	   {sectionelse}
	   <tr><td colspan="4">{$LNG_BASIC.c1026}</td></tr>
	  {/section}
	 </table>
 {/if}