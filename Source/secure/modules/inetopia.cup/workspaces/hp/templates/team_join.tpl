{include file="devs/message.tpl"}
{if !$success && $cups }


<table border="0" cellpadding="10">
 <tr>
 	<td><img src="images/eglbeta/cups.gif"/>
 	<td><h2>Anstehende Turniere</h2></td>
 </tr>
</table>

{include file="devs/hr_black.tpl" width="100%"}


<table border="0" cellpadding="5" cellspacing="1" width="95%"  align="center">
 {section name=cup loop=$cups}
 	<tr><td>
		<table border="0" cellpadding="0" cellspacing="5" width="100%" align="center">
		 <tr>
			<td colspan="2" width="80%" valign="top"><h2>{$cups[cup]->name|strip_tags|stripslashes}</h2></td>
		 </tr>
		 <tr><td width="1%">
			<table border="0" cellpadding="1" cellspacing="0" bgcolor="#000000"><tr><td><img border="0" src="{$path_games}small/{$cups[cup]->game_logo}" width="80" height="110"/></td></tr></table>
			  </td><td valign="top">
 					<table border="0" cellpadding="5" width="100%" align="right">
 					 <tr>
 					 	<td width="150"> <b>Turnier startet am: </td>
 					 	<td>{date timestamp=$cups[cup]->start_time format="%d.%m.%Y %H:%M"}</td>
 					 </tr>
 					 <tr>
 					 	<td><b>Max. Teilnehmer: </td>
 					 	<td>{$cups[cup]->max_participants}</td>
 					 </tr>
 					 <tr>
 					 	<td><b>Bereits eingetragen:</td>
 					 	<td>{int value=$cups[cup]->num_participants}</td>
 					 </tr>
 					</table>
 										
 			</td>
			<td colspan="2" align="right"> 
 			 	{*IF CHECKIN TIME ? => 1h *}
 			 	
 			 	{if $smarty.const.EGL_TIME >= $cups[cup]->start_time- ($cups[cup]->checkin_time*60) }
 			 	
 			 		{if $cups[cup]->participant_id  }
	 			 		{if $cups[cup]->checked  }
	 			 			{include file="buttons/bt_universal.tpl" color=$GLOBAL_COLOR caption="Check-OUT" link="`$url_file`page=`$url_page`&cup_id=`$cups[cup]->id`&team_id=`$participant_id`&a=check_out"}
	 			 		{else}
							{include file="buttons/bt_universal.tpl" color=$GLOBAL_COLOR caption="Check-IN"  selected="true"  link="`$url_file`page=`$url_page`&cup_id=`$cups[cup]->id`&team_id=`$participant_id`&a=check_in"}
	 			 		{/if}
	 			 	{/if}
 			 	{else}
 			 		{if $cups[cup]->participant_id  }
 			 			{include file="buttons/bt_universal.tpl" color=$GLOBAL_COLOR caption="Austragen"  link="`$url_file`page=`$url_page`&cup_id=`$cups[cup]->id`&team_id=`$participant_id`&a=quit"}
 			 		{else}
 			 			{include file="buttons/bt_universal.tpl" color=$GLOBAL_COLOR caption="Einschreiben" selected="true"   link="`$url_file`page=`$url_page`&cup_id=`$cups[cup]->id`&team_id=`$participant_id`&a=enter"}
 			 		{/if}
 			 	{/if}
		 		{include file="buttons/bt_universal.tpl" color=$GLOBAL_COLOR caption="Übersicht"  link="`$url_file`page=`$CURRENT_MODULE_ID`:info&cup_id=`$cups[cup]->id`&team_id=`$participant_id`&a=quit"}
 			 	
 			 	</td>
 			 </tr>
 			</table>
 		
 		</td>
 	</tr>
 	
 	{if !$smarty.section.cup.last}	<tr><td>{include file="devs/hr2.tpl" width="100%"}</td></tr> {/if}
  {/section}
</table>



<!--#
<table border="0" cellpadding="5" cellspacing="1" width="95%"  align="center">
 {section name=cup loop=$cups}
 	<tr>
 		<td>
 			<table border="0" cellpadding="0" cellspacing="5" width="100%" align="center">
 			 <tr>
 				<td width="80%" valign="top">
 					<h2>{$cups[cup]->name}</h2>
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
 						{cutstr num=500 text=$cups[cup]->description|nl2br}
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
	 			 			[ <a href="{$url_file}page={$url_page}&cup_id={$cups[cup]->id}&team_id={$participant_id}&a=check_out"><b>Check Out</b> </a>]
	 			 		{else}
	 			 			[ <a href="{$url_file}page={$url_page}&cup_id={$cups[cup]->id}&team_id={$participant_id}&a=check_in"><b>Check In</b> </a>]
	 			 		{/if}
	 			 	{/if}
 			 	{else}
 			 		{if $cups[cup]->participant_id  }
 			 			[ <a href="{$url_file}page={$url_page}&cup_id={$cups[cup]->id}&team_id={$participant_id}&a=quit"><b>Austragen</b> </a>]
 			 		{else}
 			 			[ <a href="{$url_file}page={$url_page}&cup_id={$cups[cup]->id}&team_id={$participant_id}&a=enter"><b>Einschreiben</b> </a>]
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
#-->

{/if}