<script language="JavaScript" type="text/javascript" src="javascript/detail_window.js"></script>
{literal}
<script language="javascript"> 
	function load_bgcolor(obj, color ) { obj.style.backgroundColor 	= color;}
	function change_image_src( obj, pic ){obj.src = pic;}
</script>
{/literal}


<table cellpadding="5">
 <tr>
 	<td><table cellpadding="1" cellspacing="0" bgcolor="#000000"><tr><td><img src="{$PATH_GAMES}small/{$game->logo_small_file}" width="60" height="80"/></td></tr></table> </td>
 	<td valign="top">
 	<font style="font-size:15px"><b>{$game->name|stripslashes|strip_tags}</b></font> ({$game->token|stripslashes|strip_tags}) <br/>
 	<A target="_blank" href="{$game->hp}">{$game->hp}</A><br/>
 	</td>
 </tr>
</table>

<br/>
<h2>Ladderübersicht</h2>
<hr/>
<b>{$ladders|@count} Ladder</b><br/>
<br/>

  {assign var="cats_per_line" value="4"}
  {capture assign="cat_lines"}{compute_lines array=$ladders items_per_line=$cats_per_line}{/capture}
	<table border="0" cellpadding="10">
	   {section name=y loop=$cat_lines}
		 <tr>
		   {section name=x loop=$cats_per_line}
		   {assign var="index" value=$smarty.section.y.index*$cats_per_line+$smarty.section.x.index}
		   {if $index < sizeof($ladders) }
		   		<td align="center"> 
		   			<table cellpadding="1" cellspacing="4"><tr><td>
		   				<A href="{$url_file}page={$CURRENT_MODULE_ID}:admin.overview&ladder_id={$ladders[$index]->id}"><img onmousemove="javascript:detailwindow_showdiv('dwindow{$ladders[$index]->id}');" onmouseout="javascript:detailwindow_hidediv('dwindow{$ladders[$index]->id}');" border="0" src="images/modules/inetopia_ladder/logo_ladder.gif" /></a>
					</td></tr></table>		
					<b>{$ladders[$index]->name|strip_tags|stripslashes}</b>
					<br/><font style="font-size:10px;">{$ladders[$index]->num_participants|tointeger}Teilnehmer, {$ladders[$index]->num_matches|tointeger} Matches</font>
			   			
		 		</td> 
			 {/if}
			 {/section}
		</tr>
	{/section}
	</table>


<!--# DETAIL WINDOWS #-->
{section name=ladder loop=$ladders}
<div id="dwindow{$ladders[ladder]->id}" style="position:absolute; visibility:hidden; z-index:2">
	<table width="350" cellpadding="0" cellspacing="1" bgcolor="{#clr_content_border#}">
	 <tr>
	 	<td bgcolor="{#clr_content#}">
	 			<table cellpadding="5">
	 			 <tr>
	 			 	<td colspan="2"><font style="font-size:17px;"><b>{$ladders[ladder]->name|strip_tags|stripslashes}</b></font></td>
	 			 </tr>
		 		 <tr>
		 		 	<td><b>Teilnehmergenze:</b></td>
		 		 	{if $ladders[ladder]->max_participants == 0}<td>Unlimited</td>{/if}
		 		 	{if $ladders[ladder]->max_participants}<td>{$ladders[ladder]->max_participants}</td>{/if}
		 		 </tr>
		 		 <tr>
		 		 	<td><b>Teilnehmerzahl:</b></td>
		 		 	<td>{$ladders[ladder]->num_participants}</td>
		 		 </tr>
		 		 <tr>
		 		 	<td><b>Ladder-Start:</b></td>
		 		 	<td>{date timestamp=$ladders[ladder]->start_time}</td>
		 		 </tr>
		 		 <tr>
		 		 	<td><b>Challenge-Mode:</b></td>
		 		 	<td>
		 		 	{if $ladders[ladder]->challenge_types & $smarty.const.CHALLENGETYPE_SINGLE_MAP}Single-Map{/if}
		 		 	{if $ladders[ladder]->challenge_types & $smarty.const.CHALLENGETYPE_DOUBLE_MAP}Double-Map{/if}
		 		 	{if $ladders[ladder]->challenge_types & $smarty.const.CHALLENGETYPE_RANDOM_MAP}Random-Map{/if}
		 		 	{if $ladders[ladder]->challenge_types == 0}Keine ausgewählt{/if}
		 		 	</td>
		 		 </tr>
		 		 {if $ladders[ladder]->participant_type == $smarty.const.PARTTYPE_TEAM}
		 		 <tr>
					<td><b>Team Members:</b></td>	 		 
		 		 	<td>{$ladders[ladder]->num_team_members}</td>
		 		 </tr>
		 		 {/if}
		 		 <tr>
					<td><b>Check GameAccounts:</b></td>	 		 
					{if !$ladders[ladder]->check_gameacc_id}
			 		 	<td>Nein</td>
					{else}
			 		 	<td>Ja</td>
					{/if}
		 		 </tr>
		 		 <tr>
		 		 	<td><b>Teilnehmer-Art:</b></td>
		 		 	{if $ladders[ladder]->participant_type == $smarty.const.PARTTYPE_MEMBER}<td><img src="images/member.gif"><i>(Einzelspieler)</i></td>{/if}
		 		 	{if $ladders[ladder]->participant_type == $smarty.const.PARTTYPE_TEAM}<td><img src="images/clans.gif"><i>(Team)</i></td>{/if}
		 		 </tr>
		 		 <tr>
		 		 	<td><b>Öffentlich:</b></td>
		 		 	{if $ladders[ladder]->is_public}  <td>Ja</td>{/if}
		 		 	{if !$ladders[ladder]->is_public} <td>Nein</td>{/if}
		 		 </tr>
		 		 <tr>
		 		 	<td><b>Administratoren:</b></td>
		 		 	<td>
					 	{section name=admin loop=$ladders[ladder]->adminlist}
					 		{$ladders[ladder]->adminlist[admin]->nick_name|strip_tags|stripslashes}
					 		{if !$smarty.section.admin.last},{/if}
					 	{/section}
					 	{if sizeof($ladders[ladder]->adminlist)==0}Keine Admins eingetragen{/if}	
		 		 	</td>
		 		 </tr>
			</table>
	 	</td>
	 </tr>
	</table>	
</div>
{/section}
