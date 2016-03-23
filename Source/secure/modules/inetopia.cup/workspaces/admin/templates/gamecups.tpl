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

<br/><h2>Turnierübersicht</h2>
<hr size="1"/>
<b>{$cups|@count} Turniere</b><br/><br/>

  {assign var="cats_per_line" value="4"}
  {capture assign="cat_lines"}{compute_lines array=$cups items_per_line=$cats_per_line}{/capture}
	<table border="0" cellpadding="10">
	   {section name=y loop=$cat_lines}
		 <tr>
		   {section name=x loop=$cats_per_line}
		   {assign var="index" value=$smarty.section.y.index*$cats_per_line+$smarty.section.x.index}
		   {if $index < sizeof($cups) }
		   		<td align="center"> 
		   			<table cellpadding="1" cellspacing="0"><tr><td>
		   				<A href="{$url_file}page={$CURRENT_MODULE_ID}:admin.overview&cup_id={$cups[$index]->id}"><img onmousemove="javascript:detailwindow_showdiv('dwindow{$cups[$index]->id}');" onmouseout="javascript:detailwindow_hidediv('dwindow{$cups[$index]->id}');" border="0" src="images/modules/inetopia_cup/cup_icon.gif" /></a>
					</td></tr></table>		
					<b>{$cups[$index]->name|strip_tags|stripslashes}</b> <br/>
					<font style="font-size:10px;">Cupstart {date timestamp=$cups[$index]->start format="%d.%m.%y"}</font> <br/>
					<font style="font-size:10px;">{$cups[$index]->num_participants}/{$cups[$index]->max_participants} Teilnehmer eingetragen</font>
			   			
		 		</td> 
			 {/if}
			 {/section}
		</tr>
	{/section}
	</table>


<!--# DETAIL WINDOWS #-->
{section name=cup loop=$cups}
<div id="dwindow{$cups[cup]->id}" style="position:absolute; visibility:hidden; z-index:2">
	<table width="350" cellpadding="0" cellspacing="1" bgcolor="{#clr_content_border#}">
	 <tr>
	 	<td bgcolor="{#clr_content#}">
	 			<table cellpadding="5">
	 			 <tr>
	 			 	<td colspan="2"><font style="font-size:17px;"><b>{$cups[cup]->name|strip_tags|stripslashes}</b></font></td>
	 			 </tr>
		 		 <tr>
		 		 	<td><b>Teilnehmer:</b></td>
		 		 	<td>{$cups[cup]->max_participants}</td>
		 		 </tr>
		 		 <tr>
		 		 	<td><b>Eingetragen:</b></td>
		 		 	<td>{$cups[cup]->num_participants}</td>
		 		 </tr>
		 		 <tr>
		 		 	<td><b>Turnierstart:</b></td>
		 		 	<td>{date timestamp=$cups[cup]->start_time}</td>
		 		 </tr>
		 		 <tr>
		 		 	<td><b>Mode:</b></td>
		 		 	<td>Single-Elimination</td>
		 		 </tr>
		 		 {if $cups[cup]->participant_type == $smarty.const.PARTTYPE_TEAM}
		 		 <tr>
					<td><b>Team Members:</b></td>	 		 
		 		 	<td>{$cups[cup]->num_team_members}</td>
		 		 </tr>
		 		 {/if}
		 		 <tr>
					<td><b>Check GameAccounts:</b></td>	 		 
					{if !$cups[cup]->check_gamacc_id}
			 		 	<td>Nein</td>
					{else}
			 		 	<td>Ja</td>
					{/if}
		 		 </tr>
		 		 <tr>
		 		 	<td><b>Teilnehmer-Art:</b></td>
		 		 	{if $cups[cup]->participant_type == $smarty.const.PARTTYPE_MEMBER}<td><img src="images/member.gif"><i>(Einzelspieler)</i></td>{/if}
		 		 	{if $cups[cup]->participant_type == $smarty.const.PARTTYPE_TEAM}<td><img src="images/clans.gif"><i>(Team)</i></td>{/if}
		 		 </tr>
		 		 <tr>
		 		 	<td><b>Öffentlich:</b></td>
		 		 	{if $cups[cup]->is_public} 	<td>Ja</td>{/if}
		 		 	{if !$cups[cup]->is_public} <td>Nein</td>{/if}
		 		 </tr>
		 		 <tr>
		 		 	<td><b>Administratoren:</b></td>
		 		 	<td>
					 	{section name=admin loop=$cups[cup]->adminlist}
					 		{$cups[cup]->adminlist[admin]->nick_name|strip_tags|stripslashes}
					 		{if !$smarty.section.admin.last},{/if}
					 	{/section}
					 	{if sizeof($cups[cup]->adminlist)==0}Keine Admins eingetragen{/if}	
		 		 	</td>
		 		 </tr>
			</table>
	 	</td>
	 </tr>
	</table>	
</div>
{/section}
