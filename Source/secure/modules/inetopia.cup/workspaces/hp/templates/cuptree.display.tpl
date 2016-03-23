<table border="0" cellpadding="5" cellspacing="1" width="100%">
 <tr>
	<td align="right">{include file="buttons/bt_universal.tpl" color=$GLOBAL_COLOR  caption="Zurück"  link="`$url_file`page=`$url_page`&cup_id=`$cup->id`&r=`$cuptree_prevrnd`"}</td>
	<td align="left">{include file="buttons/bt_universal.tpl" color=$GLOBAL_COLOR  caption="Weiter"  link="`$url_file`page=`$url_page`&cup_id=`$cup->id`&r=`$cuptree_nextrnd`"}</td>
 </tr>
</table>

<br><br>

<table border="0" cellpadding="0"cellspacing="0">
 <tr>
	{section name=round loop=$cuptree_numrounds}
	{if $smarty.section.round.index <= $cuptree_maxrounds}
		{if $smarty.section.round.index == $cuptree_numrounds-1}
			<td bgcolor="#CFCFCF">
				<table border="0" width="90">
					<tr><td><font color='#000000'><b>{$LNG_MODULE.c1203}</b> </td>
				</tr></table>
			</td>
		{else}
			<td bgcolor="#CFCFCF">
				<table border="0" width="90">
					<tr><td><font color='#000000'><i><b>{$LNG_MODULE.c1202} {$cuptree_startround+$smarty.section.round.index+1}</b></i>  </td>
				</tr></table>
			</td>
		{/if}
		<td></td>
	{/if}
	{/section}
</tr>

{* RETURN *}
<tr><td><img src='images/spacer.gif' width="1"/></td></tr>

	{assign var="test" value=0}
	
	{section name=member loop=$cuptree_membermask[0]}	{*$cuptree_membermask[0] ==> NUMBER OF MEMBER-COUNT PER ROUND *}
		<tr>

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
					<td bgcolor="{#clr_content_border#}" width="33%">
				{else}
					<td bgcolor="{#clr_content#}" width="33%">
				{/if}
			
				{if $cup->participant_type == $parttype_member AND $cup_parmatches[round][$memb_cnt]->participant_id == $member->id AND $is_loggedin}
					<table bgcolor="{#clr_selected#}" width="100%" border='0' cellpadding="0" cellspacing="0" onMouseover="javascript:setbgColor( '#FFAE00', '#009900', '{$cup_parmatches[round][$memb_cnt]->participant_id}', '{$cuptree_numrounds}' );" onMouseout="javascript:setbgColor( '{#clr_selected#}', '', '{$cup_parmatches[round][$memb_cnt]->participant_id}', '{$cuptree_numrounds}' );" id="enc_{$smarty.section.round.index}_{$cup_parmatches[round][$memb_cnt]->participant_id}">
				{else}
					<table width="100%" border='0' cellpadding="0" cellspacing="0" onMouseover="javascript:setbgColor( '#FFAE00', '#009900', '{$cup_parmatches[round][$memb_cnt]->participant_id}', '{$cuptree_numrounds}' );" onMouseout="javascript:setbgColor( '', '', '{$cup_parmatches[round][$memb_cnt]->participant_id}', '{$cuptree_numrounds}' );" id="enc_{$smarty.section.round.index}_{$cup_parmatches[round][$memb_cnt]->participant_id}">
				{/if}
					 <tr><td>
						<td>
					
						<table border=0 cellpadding=4 cellspacing=0 width="100%"><tr><td>
						{****************************************
							ACHTUNG:
							"is_freeticket" ist nur bei den member true, die ein freilos bekommen haben, also muss !is_freeticket sein, damit der "nicht spielende" sekeltiert ist
						***************************************}
						
						{if (($cup_parmatches[round][$memb_cnt]->participant_id == -1) && (!$cup_parmatches[round][$memb_cnt]->is_freeticket)) &&
							($cup_parmatches[round][$memb_cnt]->winner_id != -1 ) }
								<center> <font color="#C0C0C0"><i>WILD-CARD</i></font></center>
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
								<a href="{$url_file}page=member.info&member_id={$cup_parmatches[round][$memb_cnt]->participant_id}"><b>{$cup_parmatches[round][$memb_cnt]->participant_name|strip_tags|stripslashes}</b></a>
							{else}

								<a href="{$url_file}page=member.info&member_id={$cup_parmatches[round][$memb_cnt]->participant_id}">{$cup_parmatches[round][$memb_cnt]->participant_name|strip_tags|stripslashes}</a>
							{/if}
							
						{elseif $cup->participant_type == $parttype_team && !$is_ticket }
							{if $cup_parmatches[round][$memb_cnt]->is_winner }
								{if $cup_parmatches[round][$memb_cnt]->participant_clan_id != $Smarty.const.EGL_NO_ID} <A class="href_cup" href="{$url_file}page=clan.info&clan_id={$cup_parmatches[round][$memb_cnt]->participant_clan_id}"><b> {$cup_parmatches[round][$memb_cnt]->participant_clan_tag|strip_tags|stripslashes}</b> </a> {#arrow_db_right#} {/if}
								<a class="href_cup" href="{$url_file}page=team.info&clan_id={$cup_parmatches[round][$memb_cnt]->participant_clan_id}&team_id={$cup_parmatches[round][$memb_cnt]->participant_id}"><b> {$cup_parmatches[round][$memb_cnt]->participant_name|strip_tags|stripslashes} </b></a>
							{else}
								{if $cup_parmatches[round][$memb_cnt]->participant_clan_id != $Smarty.const.EGL_NO_ID} <A class="href_cup" href="{$url_file}page=clan.info&clan_id={$cup_parmatches[round][$memb_cnt]->participant_clan_id}">{$cup_parmatches[round][$memb_cnt]->participant_clan_tag|strip_tags|stripslashes}</a>  {#arrow_db_right#}{/if}
								<a class="href_cup" href="{$url_file}page=team.info&clan_id={$cup_parmatches[round][$memb_cnt]->participant_clan_id}&team_id={$cup_parmatches[round][$memb_cnt]->participant_id}"> {$cup_parmatches[round][$memb_cnt]->participant_name|strip_tags|stripslashes} </a>
							{/if}
					
						{/if}
						
						</td></tr></table>
					
						</td></tr>
					   </table>
				
				
				</td>
			{else}
				{if $cuptree_vsmask[round][member]}
				{assign var="vs_cnt" value=$cuptree_encountcnt[round]++}
				
					<td align="right">  <a href="{$url_file}page=match.info&match_id={$cup_matches[round][$vs_cnt]->match_id}"><b>{$LNG_MODULE.c1204}</b></a> </td>
				{else}
					<td><img src='images/spacer.gif' height=10 width='1'></td>
				{/if}
				
			{/if}
			
			
			{if $cuptree_selectmask[round][member] }
					<td width="1" bgcolor="#7E7E7E"><img src="images/spacer.gif" width="2"/></td>
					
			{else}
				<td>&nbsp;</td>
			{/if}
			
		{/if}
		{/section}
		</tr>
	{/section}

 </tr>
</table>

<br><br>
