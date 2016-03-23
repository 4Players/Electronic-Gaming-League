<table border="0" cellpadding="0"cellspacing="0">
 <tr>
	{section name=round loop=$cuptree_numrounds}
	{if $smarty.section.round.index <= $cuptree_maxrounds}
		{if $smarty.section.round.index == $cuptree_numrounds-1}
			<td bgcolor="{#clr_content_border#}">
				<table border='0' cellpadding="3" width='90'>
					<tr><td><font color='#000000'><b>Winner</b> </td>
				</tr></table>
			</td>
		{else}
			<td bgcolor="{#clr_content_border#}">
				<table border='0' cellpadding="3" width='90'>
					<tr><td><font color='#000000'>Round {$cuptree_startround+$smarty.section.round.index+1}  </td>
				</tr></table>
			</td>
		{/if}
		<td></td>
	{/if}
	{/section}
</tr>

{* RETURN *}
<tr><td><img src='images/spacer.gif' width='20'></td></tr>

	{assign var="test" value=0}
	{section name=member loop=$cuptree_membermask[0]}	{*$cuptree_membermask[0] ==> COUNT OF MEMBER COUNT PER ROUND *}
		<tr onmouseover="javascript:this.style.backgroundColor='#DCF2FC';"
			onmouseout="javascript:this.style.backgroundColor='';">

		{section name=round loop=$cuptree_numrounds}
		{if $smarty.section.round.index <= $cuptree_maxrounds}
		
		
			{if $cuptree_membermask[round][member]}
				{assign var="memb_cnt" value=$cuptree_membercnt[round]++}
				<!--
				{if $cup_parmatches[round][$memb_cnt]->is_winner}<td bgcolor="#990000">{/if}
				{if !$cup_parmatches[round][$memb_cnt]->is_winner}<td bgcolor="#000000">{/if}
				-->
				
				{if (($cup_parmatches[round][$memb_cnt]->participant_id == -1) && (!$cup_parmatches[round][$memb_cnt]->is_freeticket)) &&
					($cup_parmatches[round][$memb_cnt]->winner_id != -1 ) }
					<td bgcolor="{#clr_content#}">
				{else}
					<td bgcolor="{#clr_content_border#}">
				{/if}
	
					<table width="100%" border='0' cellpadding="0" cellspacing="0" onMouseover="javascript:setbgColor( '#FFD6D6', '#D6EBFF', {$cup_parmatches[round][$memb_cnt]->participant_id}, {$cuptree_numrounds} );" onMouseout="javascript:setbgColor( '', '', {$cup_parmatches[round][$memb_cnt]->participant_id}, {$cuptree_numrounds} );" id="enc_{$smarty.section.round.index}_{$cup_parmatches[round][$memb_cnt]->participant_id}">
					 <tr><td>
						<td>
					
						<table border="0" cellpadding="4" cellspacing="0" width="100%">
						 <tr><td>
							{****************************************
								ACHTUNG:
								"is_freeticket" ist nur bei den member true, die ein freilos bekommen haben, also muss !is_freeticket sein, damit der "nicht spielende" sekeltiert ist
							***************************************}
							{if (($cup_parmatches[round][$memb_cnt]->participant_id == -1) && (!$cup_parmatches[round][$memb_cnt]->is_freeticket)) &&
								($cup_parmatches[round][$memb_cnt]->winner_id != -1 ) }
								<center> <font color="#535353"><i>WILD-CARD</i></font></center>
								{assign var="is_ticket" value=1}
							{else}
								<i>{$memb_cnt+1}.</i>
								
								{section name=country loop=$countries}
									{if $countries[country]->id == $cup_parmatches[round][$memb_cnt]->participant_country_id }
										<img src="{$path_country}{$countries[country]->image_file}">
									{/if}
								{/section}
								{assign var="is_ticket" value=0}
							{/if}			
								
							{if $cup->participant_type == $parttype_member && !$is_ticket }
								{if $cup_parmatches[round][$memb_cnt]->is_winner}
									<A href="{$url_file}page=member.profile&member_id={$cup_parmatches[round][$memb_cnt]->participant_id}"><b> {$cup_parmatches[round][$memb_cnt]->participant_name} </b></a>
								{else}
									<A href="{$url_file}page=member.profile&member_id={$cup_parmatches[round][$memb_cnt]->participant_id}"> {$cup_parmatches[round][$memb_cnt]->participant_name} </a>
								{/if}
								
								<A name="{$cup_parmatches[round][$memb_cnt]->participant_id}_{$cup_parmatches[round][$memb_cnt]->match_id}">&nbsp;&nbsp;</a>
								{if $cup_parmatches[round][$memb_cnt]->participant_id != -1}
									<A title="Spieler in die nächste Runde" href="{$url_file}page={$url_page}&cup_id={$cup->id}&match_id={$cup_parmatches[round][$memb_cnt]->match_id}&participant_id={$cup_parmatches[round][$memb_cnt]->participant_id}&a=tree_evaluator#{$cup_parmatches[round][$memb_cnt]->participant_id}_{$cup_parmatches[round][$memb_cnt]->match_id}"><b>&rArr;</b></a>
								{/if}
								
							{elseif $cup->participant_type == $parttype_team && !$is_ticket }
							
								{if $cup_parmatches[round][$memb_cnt]->is_winner }
									{if $cup_parmatches[round][$memb_cnt]->participant_clan_id != $Smarty.const.EGL_NO_ID} <A class="href_cup" href="{$url_file}page=clan.profile&clan_id={$cup_parmatches[round][$memb_cnt]->participant_clan_id}"><b> {$cup_parmatches[round][$memb_cnt]->participant_clan_tag}</b> </a> {#arrow_db_right#} {/if}
									<A class="href_cup" href="{$url_file}page=team.profile&team_id={$cup_parmatches[round][$memb_cnt]->participant_id}"><b> {$cup_parmatches[round][$memb_cnt]->participant_name} </b></a>
								{else}
									{if $cup_parmatches[round][$memb_cnt]->participant_clan_id != $Smarty.const.EGL_NO_ID} <A class="href_cup" href="{$url_file}page=clan.info&clan_id={$cup_parmatches[round][$memb_cnt]->participant_clan_id}">{$cup_parmatches[round][$memb_cnt]->participant_clan_tag}</a> {#arrow_db_right#} {/if}
									<A class="href_cup" href="{$url_file}page=team.profile&team_id={$cup_parmatches[round][$memb_cnt]->participant_id}"> {$cup_parmatches[round][$memb_cnt]->participant_name} </a>
								{/if}
								
								<A name="{$cup_parmatches[round][$memb_cnt]->participant_id}_{$cup_parmatches[round][$memb_cnt]->match_id}">&nbsp;&nbsp;</a>
								{if $cup_parmatches[round][$memb_cnt]->participant_id != -1}
									<A title="Spieler in die nächste Runde" href="{$url_file}page={$url_page}&cup_id={$cup->id}&match_id={$cup_parmatches[round][$memb_cnt]->match_id}&participant_id={$cup_parmatches[round][$memb_cnt]->participant_id}&a=tree_evaluator#{$cup_parmatches[round][$memb_cnt]->participant_id}_{$cup_parmatches[round][$memb_cnt]->match_id}"><b>&rArr;</b></a>
								{/if}
								
								{*$cup_parmatches[round][$memb_cnt]->id*}
							{/if}
							
						  </td></tr>
						</table>
					
						</td></tr>
					   </table>
				
				
				</td>

			{else}
				{if $cuptree_vsmask[round][member]}
					{assign var="vs_cnt" value=$cuptree_encountcnt[round]++}
					<td align='right'>  <A href='{$url_file}page=administration.match.admin&match_id={$cup_matches[round][$vs_cnt]->match_id}'><b>VS.</b></a> </td>
					
				{else}
					<td><img src='images/spacer.gif' height=10 width='1'></td>
				{/if}
				
			{/if}
			
			
			{if $cuptree_selectmask[round][member] }
					<td bgcolor='{#clr_content_border#}'><img src='images/spacer.gif' width=1></td>
					
			{else}
				<td></td>
			{/if}
			
		{/if}
		{/section}
		</tr>
	{/section}

 </tr>
</table>

<br/><br/>
