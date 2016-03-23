{include file="devs/message.tpl"}
{if !$success && $cups }


<table border="0" cellpadding="0">
 <tr>
 	<td><img src="images/cbl.cup_small.jpg"></td>
 	<td><h2>Upcoming Cups</h2></td>
 </tr>
</table>

{include file="devs/hr_black.tpl" width="100%"}


<table border="0" cellpadding="5" cellspacing="1" width="95%"  align="center">
 {section name=cup loop=$cups}
 	<tr>
 		<td>
 			<table border="0" cellpadding="0" cellspacing="5" width="100%" align="center">
 			 <tr>
 				<td width="80%" valign="top">
 					<h2>{$cups[cup]->name|strip_tags|stripslashes}</h2>
 				</td>
 			  </tr>
 			  <tr>
 			  	<td>
 					
 					<table border="0" width="100%" align="right">
 					 <tr>
 					 	<td width="30%"> <b>Start am: </td>
 					 	<td> <b>{date timestamp=$cups[cup]->start_time format="%d.%m.%Y %H:%M"}</b> </td>
 					 </tr>
 					 <tr>
 					 	<td> <b>Teilnehmeranzahl: </td>
 					 	<td> <b>{$cups[cup]->max_participants}</b> </td>
 					 </tr>
 					 <tr>
 					 	<td> <b>Bereits eingetragen:</td>
 					 	<td> <b>{int value=$cups[cup]->num_participants}</b> </td>
 					 </tr>
 					</table>
 				</td>
 				<td>
 				</tr>
 				<tr>
 				 <td>
 					<br><br>
					<A href="{$url_file}page={$CURRENT_MODULE_ID}:info&cup_id={$cups[cup]->id}"><img align="left" border=0 src="{$path_games}small/{$cups[cup]->game_logo}" width="80" height="110"></a>
 					
 					{if strlen($cups[cup]->description) > 0}
 						{cutstr num=500 text=$cups[cup]->description|stripslashes|nl2br}
 					{else}
 						Keine Beschreibung
 					{/if}
 				 </td>
 				</tr><tr>
 				 <td>
 					
 				 	
 					
 				</td>
 			 </tr>
 			 <tr>
 			 	<td colspan="2" align="right"> 
 			 	
 			 	
 			 	{*IF CHECKIN TIME ? => 1h *}
 			 	
 			 	{if $smarty.const.EGL_TIME >= $cups[cup]->start_time- ($cups[cup]->checkin_time*60) }
 			 	
 			 		{if $cups[cup]->participant_id  }
	 			 		{if $cups[cup]->checked  }
	 			 			[ <a href="{$url_file}page={$url_page}&cup_id={$cups[cup]->id}&{$url_clanteam}&a=check_out"><b>Check Out</b> </a>]
	 			 		{else}
	 			 			[ <a href="{$url_file}page={$url_page}&cup_id={$cups[cup]->id}&{$url_clanteam}&a=check_in"><b>Check In</b> </a>]
	 			 		{/if}
	 			 	{/if}
 			 	{else}
 			 		{if $cups[cup]->participant_id  }
 			 			[ <a href="{$url_file}page={$url_page}&cup_id={$cups[cup]->id}&{$url_clanteam}&a=quit"><b>Austragen</b> </a>]
 			 		{else}
 			 			[ <a href="{$url_file}page={$url_page}&cup_id={$cups[cup]->id}&{$url_clanteam}&a=enter"><b>Einschreiben</b> </a>]
 			 		{/if}
 			 	{/if}
 			 	[ <a href="{$url_file}page={$CURRENT_MODULE_ID}:info&cup_id={$cups[cup]->id}"><b>Details</b></a>]
 			 	</td>
 			 </tr>
 			</table>
 		
 		</td>
 	</tr>
 	
 	{if !$smarty.section.cup.last}	<tr><td>{include file="devs/hr_black.tpl" width="100%"}</td></tr> {/if}
  {/section}
</table>


{/if}