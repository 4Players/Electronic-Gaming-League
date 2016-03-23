
<hr>

<A href="{$url_file}page={$url_page}&cup_id={$cup.id}&r={$cuptree_prevrnd}">Prev</a> |
<A href="{$url_file}page={$url_page}&cup_id={$cup.id}&r={$cuptree_nextrnd}">Next</a>

<br><br>


<table border="0" cellpadding="0"cellspacing="0">
 <tr>
	{section name=round loop=$cuptree_numrounds}
	{if $smarty.section.round.index <= $cuptree_maxrounds}
		{if $smarty.section.round.index == $cuptree_numrounds-1}
			<td bgcolor="#CFCFCF">
				<table border='0' width='90'>
					<tr><td><font color='#000000'><b>Gewinner</b> </td>
				</tr></table>
			</td>
		{else}
			<td bgcolor="#CFCFCF">
				<table border='0' width='90'>
					<tr><td><font color='#000000'><i><b>Runde {$cuptree_startround+$smarty.section.round.index+1}</b></i>  </td>
				</tr></table>
			</td>
		{/if}
		<td></td>
	{/if}
	{/section}
</tr>

{* RETURN *}
<tr><td><img src='images/spacer.gif' width='20'></td></tr>

	{assign var="counter" value="0"}		

	
	
	{section name=member loop=$cuptree_membermask[0]}	{*$cuptree_membermask[0] ==> COUNT OF MEMBER COUNT PER ROUND *}
		<tr>

		
		{section name=round loop=$cuptree_numrounds}
		{if $smarty.section.round.index <= $cuptree_maxrounds}
		
		
			{if $cuptree_membermask[round][member]}
				{assign var="__cnt" value=$cuptree_membercnt[round]++}
			
				{if $cup_parmatches[round][$__cnt].is_winner}<td bgcolor="#990000">{/if}
				{if !$cup_parmatches[round][$__cnt].is_winner}<td bgcolor="#000000">{/if}
							
					<table border='0' cellpadding="0" cellspacing="0"><tr><td>
					
						<table border=0 cellpadding=4 cellspacing=0><tr><td>

						<i>{$__cnt+1}.</i>
	
						<img src="images/country/germany.gif">
						
			
						
						{if $cup.participant_type == $parttype_member }
							{if $cup_parmatches[round][$__cnt].is_winner}

								<A href="{$url_file}page=member.info&member_id={$cup_parmatches[round][$__cnt].participant_id}"><b> {$cup_parmatches[round][$__cnt].participant_name} </b></a>
							{else}

								<A href="{$url_file}page=member.info&member_id={$cup_parmatches[round][$__cnt].participant_id}"> {$cup_parmatches[round][$__cnt].participant_name} </a>
							{/if}
						{elseif $cup.participant_type == $parttype_team }
							{if $cup_parmatches[round][$__cnt].is_winner}
								<A class="href_cup" href="{$url_file}page=clan.info&clan_id={$cup_parmatches[round][$__cnt].participant_clan_id}"><b> {$cup_parmatches[round][$__cnt].participant_clan_tag}</b> </a>
								{#arrow_db_right#}
								<A class="href_cup" href="{$url_file}page=team.info&clan_id={$cup_parmatches[round][$__cnt].participant_clan_id}&team_id={$cup_parmatches[round][$__cnt].participant_id}"><b> {$cup_parmatches[round][$__cnt].participant_name} </b></a>
							{else}
								<A class="href_cup" href="{$url_file}page=clan.info&clan_id={$cup_parmatches[round][$__cnt].participant_clan_id}">{$cup_parmatches[round][$__cnt].participant_clan_tag}</a>
								{#arrow_db_right#}
								<A class="href_cup" href="{$url_file}page=team.info&clan_id={$cup_parmatches[round][$__cnt].participant_clan_id}&team_id={$cup_parmatches[round][$__cnt].participant_id}"> {$cup_parmatches[round][$__cnt].participant_name} </a>
							{/if}

							
							
						{/if}
						
						</td></tr></table>
					
						</td></tr>
					   </table>
				
				
				</td>
			{else}
				{if $cuptree_vsmask[round][member]}
				{assign var="vs_cnt" value=$cuptree_encountcnt[round]++}
				
					<td align='right'>  <A href='{$url_file}page=match.info&match_id={$cup_matches[round][$vs_cnt].match_id}'><b>VS.</b></a> </td>
				{else}
					<td><img src='images/spacer.gif' height=10 width='1'></td>
				{/if}
				
			{/if}
			{if $cuptree_selectmask[round][member]}
				<td bgcolor='#FF9000'><img src='images/spacer.gif' width=1></td>
			{else}
				<td></td>
			{/if}
			
		{/if}
		{/section}
		</tr>
	{/section}

 </tr>
</table>

<br><br><br>