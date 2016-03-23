<table border="0" width="100%" cellpadding="0" cellspacing="0">
 <tr><td valign="top">
	
	<table><tr><td><img src="images/cupicon_gold_small.gif" width="50"/></td><td><font style="font-size:20px;">{$cup->name|strip_tags|stripslashes}</font><br/><b>{$LNG_MODULE.c1100}</b></td></tr></table>
 
	<br/>
	<table cellpadding="2" align="center" width="95%">
	 <tr>
	 	<td width="100"><b>{$LNG_MODULE.c1002}:</b></td><td>{date timestamp=$cup->start_time}</td>
	 </tr>
	 <tr>
	 	<td><b>{$LNG_MODULE.c1001}:</b></td><td>{if $cup->is_public}Ja{else}Nein{/if}</td>
	 </tr>
	 <tr>
	 	<td><b>{$LNG_MODULE.c1101}:</b></td><td>{$num_participants}/{$cup->max_participants} {$LNG_MODULE.c1100}</td>
	 </tr>	 
	</table>
	<br/>
			
		<table width="100%" height="320" border="0" cellpadding="0" cellspacing="0"  style="background-repeat:no-repeat;">
		 <tr><td valign="top">
			<table border="0" width="400" cellpadding="10"><tr><td valign="top">
			<h2>{$LNG_MODULE.c1102}</h2>
			
			<table border="0" cellpadding="0" cellspacing="1" width="95%">
			 <tr><td>
				 <table border="0" cellpadding="5" cellspacing="1" width="100%">
					{section name=part loop=$participants}
					
					 {if $cup->participant_type == $smarty.const.PARTTYPE_MEMBER }
						<td><a href="{$url_file}page=member.info&member_id={$participants[part]->participant_id}">{$participants[part]->participant_name|strip_tags|stripslashes}</a></td>
					 {elseif $cup->participant_type == $smarty.const.PARTTYPE_TEAM }
						<td>{if $participants[part]->participant_clan_id}<a href="{$url_file}page=clan.info&clan_id={$participants[part]->participant_clan_id}">{$participants[part]->participant_clan_tag|strip_tags|stripslashes}</a> <B>{#arrow_db_right#}</b> {/if}<A title="{$participants[part]->participant_clan_name}" href="{$url_file}page=team.info&clan_id={$participants[part]->participant_clan_id}&team_id={$participants[part]->participant_id}"> {$participants[part]->participant_name|strip_tags|stripslashes} </a></td>
					 {/if}
						<td>{date timestamp=$participants[part]->created}</td>
						{if $participants[part]->checked}
						
							<td align="center"><img src="images/button_ok.gif"/></td>
						{else}
							<td align="center"><img src="images/button_cancel.gif"/></td>
						{/if}
						
					 </tr>
					{/section}
					<tr>
						<td colspan="3">{include file="devs/hr_black.tpl" width="100%"}</td>
					</tr>
					<tr>
						<td colspan="3" align="right">{$num_participants}/{$cup->max_participants} {$LNG_MODULE.c1100}</td>
					</tr>
				</table>
			 
			 </td></tr>
			</table>
			
		 </td></tr>
		</table>
	 </td></tr>
	</table>

 </td>
 <td width="100" align="center" valign="top">
 
	{include file="`$page_dir`/menu_right.tpl"} 
 	
 </td></tr>
</table>