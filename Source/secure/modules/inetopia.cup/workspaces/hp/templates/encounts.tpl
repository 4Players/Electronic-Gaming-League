<table border="0" width="100%" cellpadding="0" cellspacing="0">
 <tr><td valign="top">
	
 	<table><tr><td><img src="images/cupicon_gold_small.gif" width="50"/></td><td><font style="font-size:20px;">{$cup->name|strip_tags|stripslashes}</font><br/><b>{$LNG_MODULE.c1300}</b></td></tr></table>
 
	{if sizeof($cup_parmatches) == 0}
		<br/><br/><div align="center"><b>Die Begegnungen stehen noch nicht fest!</b></div>
	{else}
		<table width="100%" height="320" border="0" cellpadding="0" cellspacing="0" style="background-repeat:no-repeat;">
		 <tr><td valign="top">
			<table border="0" width="400" cellpadding="10"><tr><td valign="top">
			<br/>
				
				<table border="0" cellpadding="5" cellspacing="1" width="95%" align="center">
				{section name=rnd loop=$cup_parmatches}
				{if $smarty.section.rnd.index < sizeof($cup_parmatches)-1}
				 <tr>
					<td colspan="5"><font style="color:#A0A0A0;"><b>{$LNG_MODULE.c1202} {$smarty.section.rnd.index+1}</b></font></td>
				 </tr>
					
						{section name=enc loop=$cup_parmatches[rnd] step=2}
						{assign var="enc_inc" value=$smarty.section.enc.index+1}
						 <tr>
							<!--#<td width="20%"><b> {date format="%d.%m / %H:%M" timestamp=$cup_parmatches[rnd][enc]->created} </b></td>#-->
							
							{if $cup_parmatches[rnd][enc]->participant_id == $cup_parmatches[rnd][enc]->winner_id && $cup_parmatches[rnd][enc]->participant_id != $smarty.const.EGL_NO_ID}
								{if $cup->participant_type == $smarty.const.PARTTYPE_MEMBER }
									<td width="30%"> <img src="images/match.win.gif"> <a href="{$url_file}page=member.info&member_id={$cup_parmatches[rnd][enc]->participant_id}">{$cup_parmatches[rnd][enc]->participant_name|strip_tags|stripslashes}</a> </td>
								{elseif $cup->participant_type == $smarty.const.PARTTYPE_TEAM }
									<td width="30%"> <img src="images/match.win.gif"> {if $cup_parmatches[rnd][enc]->participant_clan_id}<a href="{$url_file}page=clan.info&clan_id={$cup_parmatches[rnd][enc]->participant_clan_id}">{$cup_parmatches[rnd][enc]->participant_clan_tag|strip_tags|stripslashes}</a> {#arrow_db_right#} {/if}<A href="{$url_file}page=team.info&team_id={$cup_parmatches[rnd][enc]->participant_id}">{$cup_parmatches[rnd][enc]->participant_name|strip_tags|stripslashes}</a> </td>
								{/if}
							{elseif $cup_parmatches[rnd][enc]->winner_id == $smarty.const.EGL_NO_ID}
								{if $cup->participant_type == $smarty.const.PARTTYPE_MEMBER }
									<td width="30%"> <img src="images/match.non.gif"> <a href="{$url_file}page=member.info&member_id={$cup_parmatches[rnd][enc]->participant_id}">{$cup_parmatches[rnd][enc]->participant_name|strip_tags|stripslashes}</a> </td>
								{elseif $cup->participant_type == $smarty.const.PARTTYPE_TEAM }
									<td width="30%"> <img src="images/match.non.gif"> {if $cup_parmatches[rnd][enc]->participant_clan_id}<a href="{$url_file}page=clan.info&clan_id={$cup_parmatches[rnd][enc]->participant_clan_id}">{$cup_parmatches[rnd][enc]->participant_clan_tag|strip_tags|stripslashes}</a> {#arrow_db_right#} {/if}<a href="{$url_file}page=team.info&team_id={$cup_parmatches[rnd][enc]->participant_id}">{$cup_parmatches[rnd][enc]->participant_name|strip_tags|stripslashes}</a> </td>
								{/if}
							{else}
								{if $cup->participant_type == $smarty.const.PARTTYPE_MEMBER }
									<td width="30%"> <img src="images/match.lost.gif"> <a href="{$url_file}page=member.info&member_id={$cup_parmatches[rnd][enc]->participant_id}">{$cup_parmatches[rnd][enc]->participant_name|strip_tags|stripslashes}</a> </td>
								{elseif $cup->participant_type == $smarty.const.PARTTYPE_TEAM }
									<td width="30%"> <img src="images/match.lost.gif"> {if $cup_parmatches[rnd][enc]->participant_clan_id}<a href="{$url_file}page=clan.info&clan_id={$cup_parmatches[rnd][enc]->participant_clan_id}">{$cup_parmatches[rnd][enc]->participant_clan_tag|strip_tags|stripslashes}</b></a> {#arrow_db_right#} {/if}<a href="{$url_file}page=team.info&team_id={$cup_parmatches[rnd][enc]->participant_id}">{$cup_parmatches[rnd][enc]->participant_name|strip_tags|stripslashes}</a> </td>
								{/if}
							{/if}
							<td align="center" width="2%"><b>Vs.</b></td>
							
							{if $cup_parmatches[rnd][enc]->is_freeticket}
								<td><i>WILD-CARD</i></td>
							{else}
							
								{if $cup_parmatches[rnd][$enc_inc]->participant_id == $cup_parmatches[rnd][$enc_inc]->winner_id && $cup_parmatches[rnd][$enc_inc]->participant_id != $smarty.const.EGL_NO_ID }
									{if $cup->participant_type == $smarty.const.PARTTYPE_MEMBER }
										<td width="30%"> <img src="images/match.win.gif"> <a href="{$url_file}page=member.info&member_id={$cup_parmatches[rnd][$enc_inc]->participant_id}">{$cup_parmatches[rnd][$enc_inc]->participant_name|strip_tags|stripslashes}</a> </td>
									{elseif $cup->participant_type == $smarty.const.PARTTYPE_TEAM }
										<td width="30%"> <img src="images/match.win.gif"> {if $cup_parmatches[rnd][$enc_inc]->participant_clan_id}<a href="{$url_file}page=clan.info&clan_id={$cup_parmatches[rnd][$enc_inc]->participant_clan_id}">{$cup_parmatches[rnd][$enc_inc]->participant_clan_tag|strip_tags|stripslashes}</a> {#arrow_db_right#} {/if}<a href="{$url_file}page=team.info&team_id={$cup_parmatches[rnd][$enc_inc]->participant_id}">{$cup_parmatches[rnd][$enc_inc]->participant_name|strip_tags|stripslashes}</a> </td>
									{/if}
								{elseif $cup_parmatches[rnd][$enc_inc]->winner_id == $smarty.const.EGL_NO_ID}
									{if $cup->participant_type == $smarty.const.PARTTYPE_MEMBER }
										<td width="30%"> <img src="images/match.non.gif"> <a href="{$url_file}page=member.info&member_id={$cup_parmatches[rnd][$enc_inc]->participant_id}">{$cup_parmatches[rnd][$enc_inc]->participant_name|strip_tags|stripslashes}</a></td>
									{elseif $cup->participant_type == $smarty.const.PARTTYPE_TEAM }
										<td width="30%"> <img src="images/match.non.gif"> {if $cup_parmatches[rnd][$enc_inc]->participant_clan_id}<a href="{$url_file}page=clan.info&clan_id={$cup_parmatches[rnd][$enc_inc]->participant_clan_id}">{$cup_parmatches[rnd][$enc_inc]->participant_clan_tag|strip_tags|stripslashes}</a> {#arrow_db_right#} {/if}<A href="{$url_file}page=team.info&team_id={$cup_parmatches[rnd][$enc_inc]->participant_id}">{$cup_parmatches[rnd][$enc_inc]->participant_name|strip_tags|stripslashes}</a> </td>
									{/if}
								{else}
									{if $cup->participant_type == $smarty.const.PARTTYPE_MEMBER }
										<td width="30%"> <img src="images/match.lost.gif"> <a href="{$url_file}page=member.info&member_id={$cup_parmatches[rnd][$enc_inc]->participant_id}">{$cup_parmatches[rnd][$enc_inc]->participant_name|strip_tags|stripslashes}</a> </td>
									{elseif $cup->participant_type == $smarty.const.PARTTYPE_TEAM }
										<td width="30%"> <img src="images/match.lost.gif"> {if $cup_parmatches[rnd][$enc_inc]->participant_clan_id}<a href="{$url_file}page=clan.info&clan_id={$cup_parmatches[rnd][$enc_inc]->participant_clan_id}">{$cup_parmatches[rnd][$enc_inc]->participant_clan_tag|strip_tags|stripslashes}</a> {#arrow_db_right#} {/if}<A href="{$url_file}page=team.info&team_id={$cup_parmatches[rnd][$enc_inc]->participant_id}">{$cup_parmatches[rnd][$enc_inc]->participant_name|strip_tags|stripslashes}</a> </td>
									{/if}
								{/if}
							{/if}
							
							
							<td width="1%"> <A href="{$url_file}page=match.info&match_id={$cup_parmatches[rnd][$enc_inc]->match_id}">mehr..</a> </td>
						 </tr>
						{/section}
				{/if}
				{/section}
				</table>			
			
			
			 </td></tr>
			</table>
		 </td></tr>
		</table>
	{/if}

 </td>
 <td width="100" align="center" valign="top">
 

	{include file="`$page_dir`/menu_right.tpl"} 
	
 </td></tr>
</table>


<!--


<table border="0" cellpadding="5">
 <tr>
 	<td><font style="font-size:20px;"><b>{$cup->name}</b></font><br/><b>Begegnungen</b></td>
 </tr>
</table>


<div align="right"><A href="{$url_file}page={$CURRENT_MODULE_ID}:cuptree&cup_id={$cup->id}"><img src="images/buttons/bt_tree.gif" border="0"></a></div>
{include file="devs/hr_black.tpl" width="100%"}

<table border="0" cellpadding="3" cellspacing="1" bgcolor="{#clr_content_border#}" width="100%">
{section name=rnd loop=$cup_parmatches}
{if $smarty.section.rnd.index < sizeof($cup_parmatches)-1}
 <tr>
	<td colspan="5"align="center"><b>Runde {$smarty.section.rnd.index+1}</td>
 </tr>
	
		{section name=enc loop=$cup_parmatches[rnd] step=2}
		{assign var="enc_inc" value=$smarty.section.enc.index+1}
		 <tr bgcolor="{#clr_content#}">
			<td width="20%"><b> {date format="%d.%m / %H:%M" timestamp=$cup_parmatches[rnd][enc]->created} </b></td>
			
			{if $cup_parmatches[rnd][enc]->participant_id == $cup_parmatches[rnd][enc]->winner_id && $cup_parmatches[rnd][enc]->participant_id != $smarty.const.EGL_NO_ID}
				{if $cup->participant_type == $smarty.const.PARTTYPE_MEMBER }
					<td width="30%"> <img src="images/match.win.gif"> <A href="{$url_file}page=member.info&member_id={$cup_parmatches[rnd][enc]->participant_id}"><b>{$cup_parmatches[rnd][enc]->participant_name}</b></a> </td>
				{elseif $cup->participant_type == $smarty.const.PARTTYPE_TEAM }
					<td width="30%"> <img src="images/match.win.gif"> {if $cup_parmatches[rnd][enc]->participant_clan_id}<A href="{$url_file}page=clan.info&clan_id={$cup_parmatches[rnd][enc]->participant_clan_id}"><b>{$cup_parmatches[rnd][enc]->participant_clan_tag}</b></a> {#arrow_db_right#} {/if}<A href="{$url_file}page=team.info&team_id={$cup_parmatches[rnd][enc]->participant_id}"><b>{$cup_parmatches[rnd][enc]->participant_name}</b></a> </td>
				{/if}
			{elseif $cup_parmatches[rnd][enc]->winner_id == $smarty.const.EGL_NO_ID}
				{if $cup->participant_type == $smarty.const.PARTTYPE_MEMBER }
					<td width="30%"> <img src="images/match.non.gif"> <A href="{$url_file}page=member.info&member_id={$cup_parmatches[rnd][enc]->participant_id}"><b>{$cup_parmatches[rnd][enc]->participant_name}</b></a> </td>
				{elseif $cup->participant_type == $smarty.const.PARTTYPE_TEAM }
					<td width="30%"> <img src="images/match.non.gif"> {if $cup_parmatches[rnd][enc]->participant_clan_id}<A href="{$url_file}page=clan.info&clan_id={$cup_parmatches[rnd][enc]->participant_clan_id}"><b>{$cup_parmatches[rnd][enc]->participant_clan_tag}</b></a> {#arrow_db_right#} {/if}<A href="{$url_file}page=team.info&team_id={$cup_parmatches[rnd][enc]->participant_id}"><b>{$cup_parmatches[rnd][enc]->participant_name}</b></a> </td>
				{/if}
			{else}
				{if $cup->participant_type == $smarty.const.PARTTYPE_MEMBER }
					<td width="30%"> <img src="images/match.lost.gif"> <A href="{$url_file}page=member.info&member_id={$cup_parmatches[rnd][enc]->participant_id}"><b>{$cup_parmatches[rnd][enc]->participant_name}</b></a> </td>
				{elseif $cup->participant_type == $smarty.const.PARTTYPE_TEAM }
					<td width="30%"> <img src="images/match.lost.gif"> {if $cup_parmatches[rnd][enc]->participant_clan_id}<A href="{$url_file}page=clan.info&clan_id={$cup_parmatches[rnd][enc]->participant_clan_id}"><b>{$cup_parmatches[rnd][enc]->participant_clan_tag}</b></a> {#arrow_db_right#} {/if}<A href="{$url_file}page=team.info&team_id={$cup_parmatches[rnd][enc]->participant_id}"><b>{$cup_parmatches[rnd][enc]->participant_name}</b></a> </td>
				{/if}
			{/if}
			<td align="center" width="2%"><b>Vs.</b></td>
			
			{if $cup_parmatches[rnd][enc]->is_freeticket}
				<td> WILD CARD </td>
			{else}
			
				{if $cup_parmatches[rnd][$enc_inc]->participant_id == $cup_parmatches[rnd][$enc_inc]->winner_id && $cup_parmatches[rnd][$enc_inc]->participant_id != $smarty.const.EGL_NO_ID }
					{if $cup->participant_type == $smarty.const.PARTTYPE_MEMBER }
						<td width="30%"> <img src="images/match.win.gif"> <A href="{$url_file}page=member.info&member_id={$cup_parmatches[rnd][$enc_inc]->participant_id}"><b>{$cup_parmatches[rnd][$enc_inc]->participant_name}</b></a> </td>
					{elseif $cup->participant_type == $smarty.const.PARTTYPE_TEAM }
						<td width="30%"> <img src="images/match.win.gif"> {if $cup_parmatches[rnd][$enc_inc]->participant_clan_id}<A href="{$url_file}page=clan.info&clan_id={$cup_parmatches[rnd][$enc_inc]->participant_clan_id}"><b>{$cup_parmatches[rnd][$enc_inc]->participant_clan_tag}</b></a> {#arrow_db_right#} {/if}<A href="{$url_file}page=team.info&team_id={$cup_parmatches[rnd][$enc_inc]->participant_id}"><b>{$cup_parmatches[rnd][$enc_inc]->participant_name}</b></a> </td>
					{/if}
				{elseif $cup_parmatches[rnd][$enc_inc]->winner_id == $smarty.const.EGL_NO_ID}
					{if $cup->participant_type == $smarty.const.PARTTYPE_MEMBER }
						<td width="30%"> <img src="images/match.non.gif"> <A href="{$url_file}page=member.info&member_id={$cup_parmatches[rnd][$enc_inc]->participant_id}"><b>{$cup_parmatches[rnd][$enc_inc]->participant_name}</b></a> </td>
					{elseif $cup->participant_type == $smarty.const.PARTTYPE_TEAM }
						<td width="30%"> <img src="images/match.non.gif"> {if $cup_parmatches[rnd][$enc_inc]->participant_clan_id}<A href="{$url_file}page=clan.info&clan_id={$cup_parmatches[rnd][$enc_inc]->participant_clan_id}"><b>{$cup_parmatches[rnd][$enc_inc]->participant_clan_tag}</b></a> {#arrow_db_right#} {/if}<A href="{$url_file}page=team.info&team_id={$cup_parmatches[rnd][$enc_inc]->participant_id}"><b>{$cup_parmatches[rnd][$enc_inc]->participant_name}</b></a> </td>
					{/if}
				{else}
					{if $cup->participant_type == $smarty.const.PARTTYPE_MEMBER }
						<td width="30%"> <img src="images/match.lost.gif"> <A href="{$url_file}page=member.info&member_id={$cup_parmatches[rnd][$enc_inc]->participant_id}"><b>{$cup_parmatches[rnd][$enc_inc]->participant_name}</b></a> </td>
					{elseif $cup->participant_type == $smarty.const.PARTTYPE_TEAM }
						<td width="30%"> <img src="images/match.lost.gif"> {if $cup_parmatches[rnd][$enc_inc]->participant_clan_id}<A href="{$url_file}page=clan.info&clan_id={$cup_parmatches[rnd][$enc_inc]->participant_clan_id}"><b>{$cup_parmatches[rnd][$enc_inc]->participant_clan_tag}</b></a> {#arrow_db_right#} {/if}<A href="{$url_file}page=team.info&team_id={$cup_parmatches[rnd][$enc_inc]->participant_id}"><b>{$cup_parmatches[rnd][$enc_inc]->participant_name}</b></a> </td>
					{/if}
				{/if}
			{/if}
			
			
			<td width="1%"> <A href="{$url_file}page=match.info&match_id={$cup_parmatches[rnd][$enc_inc]->match_id}"> <img border="0" src="images/buttons/bt_cup_more.gif"> </a> </td>
		 </tr>
		{/section}
{/if}
{/section}
</table>
-->