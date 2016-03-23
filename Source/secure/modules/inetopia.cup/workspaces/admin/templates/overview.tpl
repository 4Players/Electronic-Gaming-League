<script language="JavaScript" type="text/javascript" src="javascript/detail_window.js"></script>
{literal}
<script language="javascript"> 
	function load_bgcolor(obj, color ) { obj.style.backgroundColor 	= color;}

	function change_image_src( obj, pic ){obj.src = pic;}
</script>
{/literal}

<br/>

  {assign var="cats_per_line" value="5"}
  {capture assign="cat_lines"}{compute_lines array=$games items_per_line=$cats_per_line}{/capture}
	<table border="0"  cellpadding="10">
	   {section name=y loop=$cat_lines}
		 <tr>
		   {section name=x loop=$cats_per_line}
		   {assign var="index" value=$smarty.section.y.index*$cats_per_line+$smarty.section.x.index}
		   {if $index < sizeof($games) }
		   		<td align="center"> 
		   			<table bgcolor="#000000" cellpadding="1" cellspacing="0"><tr><td>
		   				<A href="{$url_file}page={$CURRENT_MODULE_ID}:gamecups&game_id={$games[$index]->id}"><img onmousemove="javascript:detailwindow_showdiv('dwindow{$games[$index]->id}');" onmouseout="javascript:detailwindow_hidediv('dwindow{$games[$index]->id}');" border="0" src="{$PATH_GAMES}small/{$games[$index]->logo_small_file}" width="90" height="120"/></a>
					</td></tr></table>		
					<br/><font style="font-size:10px;">{$games[$index]->name}</font>
			   			
		 		</td> 
			 {/if}
			 {/section}
		</tr>
	{/section}
	</table>


<!--# DETAIL WINDOWS #-->
{section name=game loop=$games}
<div id="dwindow{$games[game]->id}" style="position:absolute; visibility:hidden; z-index:2">
	<table width="250" cellpadding="0" cellspacing="1" bgcolor="{#clr_content_border#}">
	 <tr>
	 	<td bgcolor="{#clr_content#}">
	 	<table><tr><td>
		<b>{$games[game]->name|strip_tags|stripslashes}</b> <br/>
		<br/>
		Eingetragene Turniere: {$games[game]->num_gamecups}</b> <br/>
		<br/>
		<!--#<font style="font-size:10px;">erstellt am {date timestamp=$games[game]->created format="%d.%m.%y %H:%M:%S"}</font> <br/>#-->
		
		</td></tr>
		</table>
	 	</td>
	 </tr>
	</table>	
</div>
{/section}


<!--
<table border="0" cellpadding="0" cellspacing="2" bgcolor="#C0C0C0" width="100%">
 <tr><td bgcolor="#FFFFFF">
	<table border="0" width="100%" width="100%" cellpadding="5" cellspacing="1" bgcolor="{#clr_content#}">
	
	{section name=cup loop=$cups}
	 <tr onClick="if (tableShowHide{$smarty.section.cup.index}.style.display == 'none') tableShowHide{$smarty.section.cup.index}.style.display = 'block'; else tableShowHide{$smarty.section.cup.index}.style.display = 'none';">
	 	<td colspan="2"><h3>{$cups[cup]->name}</h3> [ 	<A href="{$url_file}page={$CURRENT_MODULE_ID}:cuptree&cup_id={$cups[cup]->id}"><B>Turnierbaum</b></a> | 
	 													<A href="{$url_file}page={$CURRENT_MODULE_ID}:participants&cup_id={$cups[cup]->id}"><B>Teilnehmer</b></a> ]
		</td>
	 	<td><font color="">Erstellt  {date timestamp=$cups[cup]->created}</font></td>
	 </tr>
	 <tr>
	 	<td>
	 		<div id="tableShowHide{$smarty.section.cup.index}" style="display:none;">
	 
		 <table width="100%"><tr>
		 	<td width="1%" valign="top">
		 	
				 	<table border="0" cellpadding="0" cellspacing="1" bgcolor="{#clr_content_border#}">
				 	 <tr><td>
					 	{section name=game loop=$games}
					 		{if $games[game]->id == $cups[cup]->game_id}
					 			<img src="{$path_games}small/{$games[game]->logo_small_file}" width="60">
					 		{/if}
					 	{/section}
					 </td></tr>
					</table>
				
		 	</td>
		 	<td valign="top">
		 	
		 		<table border="0" cellpadding="5">
		 		 <tr>
		 		 	<td><b>Spiel:</b></td>
		 		 	<td>
				 	{section name=game loop=$games}
				 		{if $games[game]->id == $cups[cup]->game_id}{$games[game]->name}{/if}
				 	{/section}
		 		 	</td>
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
		 		 	{if $cups[cup]->participant_type == $smarty.const.PARTTYPE_TEAM}<td><img src="images/clans.gif"><i>(Clan)</i></td>{/if}
		 		 </tr>
		 		 <tr>
		 		 	<td><b>Öffentlich:</b></td>
		 		 	{if $cups[cup]->is_public} 	<td>Ja</td>{/if}
		 		 	{if !$cups[cup]->is_public} <td>Nein</td>{/if}
		 		 </tr>
		 		</table>
		 	
		 	</td>
		 	<td valign="top">
		 	
		 		<table border="0" cellpadding="5">
		 		 <tr>
		 		 	<td><b>Zuständige Administratoren:</b></td>
		 		 </tr>
		 		 <tr>
		 		 	<td>
				 	{section name=admin loop=$cups[cup]->adminlist}
				 		<A title="Mehr Informationen?" href="{$url_file}page=cms.member.central&member_id={$cups[cup]->adminlist[admin]->member_id}"><b>{$cups[cup]->adminlist[admin]->nick_name}</b>
				 		{if !$smarty.section.admin.last},{/if}
				 	{/section}
				 	{if sizeof($cups[cup]->adminlist)==0}Keine Admins eingetragen{/if}		 		 	
				 	</td>
		 		 </tr>
		 		</table>	 	
		 	
		 	</td>
		  </tr>
		  <tr><td colspan="3" align="right">	
			  {if !$cups[cup]->encounts_created} <a href="{$url_file}page={$url_page}&cup_id={$cups[cup]->id}&a=start"><img border=0 src="images/buttons/new/bt_start.gif">{/if}
		  		<a href="{$url_file}page={$CURRENT_MODULE_ID}:admin&cup_id={$cups[cup]->id}"><img border=0 src="images/buttons/new/bt_admin.gif">
		  		
		  </td></tr>
		</table>
		
	 </td></tr>
		  
	 {if !$smarty.section.cup.last}<tr><td colspan="3"><hr size="1" color="{#clr_content_border#}"></td></tr>{/if}
	{/section}
	</table>
 </td></tr>
</table>
-->