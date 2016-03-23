<table border=0 width="100%" cellpadding="3" cellspacing="1">
{section name=tp  loop=$teams_members[team] }
  <tr>
  	<td width="50%"><b>{$tpl[tp]->name}:</b></td>
	<td>
	
	<b>
	{section name=team_member loop=$teams_members[team][tp] }
		<A href="{$url_file}page=member.info&member_id={$teams_members[team][tp][team_member]->member_id}">{$teams_members[team][tp][team_member]->nick_name|strip_tags}</a>
		
	 	{if !$smarty.section.team_member.last }, {/if}
	{/section}
	</b>
	
	{if !sizeof($teams_members[team][tp]) } <i>Keines</i>	{/if}

	
			
   </td>
 </tr>
{/section}
</table>