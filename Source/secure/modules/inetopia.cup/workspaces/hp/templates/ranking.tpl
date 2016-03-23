
<table border="0" cellpadding="5" cellspacing="0" width="100%">
	<tr>
	 <td>
	 
	 	<table border="0" width="100%" cellpadding="1" cellspacing="3">
	 	 <tr>
	 	{if $ranking[1] }
	 	  <td width="33%" align="center" valign="bottom">
	 	  	<table border="0" width="100%" cellpadding="0" cellspacing="1" bgcolor="BFBFBF">
	 	  	 <tr>
				<td bgcolor="#DFDFDF" align="center">
					<table>
					 <tr><td><img src="images/spacer.gif" width="1" height="80"/></td>
					 	<td>
						{section name=r1 loop=$ranking[1]}
						{if $cup->participant_type == $smarty.const.PARTTYPE_TEAM}
					 		{if $ranking[1][r1]->participant->participant_clan_id != $smarty.const.EGL_NO_ID}
						 		<a href="{$url_file}page=clan.info&clan_id={$ranking[1][r1]->participant->participant_clan_id}">{$ranking[1][r1]->participant->participant_clan_tag|strip_tags|stripslashes}</a>
						 		{#arrow_db_right#}
						 	{/if}
					 		<A href="{$url_file}page=team.info&team_id={$ranking[1][r1]->participant->participant_id}">{$ranking[1][r1]->participant->participant_name|strip_tags|stripslashes}</a>
					 		
					 		
					 	{elseif $cup->participant_type == $smarty.const.PARTTYPE_MEMBER}
					 		<a href="{$url_file}page=member.info&member_id={$ranking[1][r1]->participant->participant_id}">{$ranking[1][r1]->participant->participant_name|strip_tags|stripslashes}</a>
					 	{/if}
					 	{/section}
					 </td></tr>
					 </table>
			 	</td></tr>
			 </table>
			 
	 	  </td>
	 	{/if}
	 	{if $ranking[0] }
	 	  <td  width="33%" valign="bottom">
	 	  
	 	  	<table border="0" width="100%" cellpadding="5" cellspacing="1" bgcolor="#FFD800">
	 	  	 <tr>
				<td  bgcolor="#FFF4B6" align="center">
					<table>
					 <tr><td><img src="images/spacer.gif" width="1" height="100"/></td>
					 	<td>
						<img src="images/cupicon_gold_small.gif"/>  
						<br/><br/>
						{section name=r1 loop=$ranking[0]}
						{if $cup->participant_type == $smarty.const.PARTTYPE_TEAM}
						 
					 		{if $ranking[0][r1]->participant->participant_clan_id != $smarty.const.EGL_NO_ID}
						 		<A href="{$url_file}page=clan.info&clan_id={$ranking[0][r1]->participant->participant_clan_id}">{$ranking[0][r1]->participant->participant_clan_tag|strip_tags|stripslashes}</a>
						 		{#arrow_db_right#}
						 	{/if}
					 		<A href="{$url_file}page=team.info&team_id={$ranking[0][r1]->participant->participant_id}">{$ranking[0][r1]->participant->participant_name|strip_tags|stripslashes}</a>
					 	 
					 	{elseif $cup->participant_type == $smarty.const.PARTTYPE_MEMBER}
					 		<A href="{$url_file}page=member.info&member_id={$ranking[0][r1]->participant->participant_id}">{$ranking[0][r1]->participant->participant_name|strip_tags|stripslashes}</a>
					 	{/if}
					 	{/section}
					</td></tr>
					</table>
			 	</td></tr>
			 </table>
			 			 	
	 	  </td>
	 	 {/if}
	 	{if $ranking[2] }
	 	<td  width="33%" valign="bottom">
	 	  	<table border="0" width="100%" cellpadding="0" cellspacing="1" bgcolor="#FF8400">
	 	  	 <tr>
				<td bgcolor="#FFC88D" align="center">
					<table>
					 <tr><td><img src="images/spacer.gif" width="1" height="50"/></td>
					 	<td>
						{section name=r2 loop=$ranking[2]}
 						{if $ranking[2][r2]->participant}
						
								{if $cup->participant_type == $smarty.const.PARTTYPE_TEAM}
								
							 		{if $ranking[2][r2]->participant->participant_clan_id != $smarty.const.EGL_NO_ID}
								 		<a href="{$url_file}page=clan.info&clan_id={$ranking[2][r2]->participant->participant_clan_id}">{$ranking[2][r2]->participant->participant_clan_tag|strip_tags|stripslashes}</a>
								 		{#arrow_db_right#}
								 	{/if}
							 		<a href="{$url_file}page=team.info&team_id={$ranking[2][r2]->participant->participant_id}">{$ranking[2][r2]->participant->participant_name|strip_tags|stripslashes}</a>
							 	<br>
							 	{elseif $cup->participant_type == $smarty.const.PARTTYPE_MEMBER}
							 		<a href="{$url_file}page=member.info&member_id={$ranking[2][r2]->participant->participant_id}">{$ranking[2][r2]->participant->participant_name|strip_tags|stripslashes}</a>
							 		{if !$smarty.section.r2.index.last} <br/>{/if}
							 	{/if}
						{/if}
						{if !$smarty.section.r2.last}<div style="padding:3px;">{include file="devs/hr_black.tpl" width="100%"}</div>{/if}
					 	{/section}
				 	</td></tr>
				 </table>
				 
			 	</td></tr>
			 </table>			 	

	 	  </td>
	 	 </tr>
	 	 {/if}
	 	 <tr>
	 	 	{if $ranking[1] }<td align="center"><b>{$LNG_MODULE.c1041}</b></td>{else}<td></td>{/if}
	 	 	{if $ranking[0] }<td align="center"><b>{$LNG_MODULE.c1040}</b></td>{else}<td></td>{/if}
	 	 	{if $ranking[2] }<td align="center"><b>{$LNG_MODULE.c1042}</b></td>{else}<td></td>{/if}
	 	 </tr>
	 	</table>
	 	 
	 	
	 </td>
	</tr>
	<!--#
	<tr>
		<td align="left">{include file="buttons/bt_universal.tpl" color=$GLOBAL_COLOR caption="Turnier Übersicht" link="javascript:OpenCupView( 'popup.php', '`$CURRENT_MODULE_ID`:cuptree', 'cup_id=`$cup->id`', 800, 600 );"}</td>
	</tr>
	#-->
</table>