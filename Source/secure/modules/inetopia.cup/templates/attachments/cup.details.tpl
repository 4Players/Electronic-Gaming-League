<br>
<table border="0" width="100%" cellpadding="0" cellspacing="0">

 <tr><td><h2>Cups</h2></td></tr>
 <tr><td>{include file="devs/hr_black.tpl" width="100%"}</td></tr>
</table>

	<table border="0" cellpadding="3" cellspacing="1" width="100%">
	 {section name=cup loop=$attach_cupsplayed}
	 	<tr bgcolor="{#clr_content#}">
	 		<td width="80%"><A href="{$url_file}page={$ATTACH_MODULE_ID}:info&cup_id={$attach_cupsplayed[cup]->id}"><b>{$attach_cupsplayed[cup]->name}</b></a></td>
	 		<td></td>
	 	</tr>
	 {/section}
	 </table>
 
 {if sizeof($attach_cupsentered) > 0}
	 <table border="0" cellpadding="3" cellspacing="1" width="100%">
	 <tr bgcolor="{#clr_content_border#}">
	 	<td width="40%"><b>Eingetragen für</b></td>
	 	<td width="30%"><b>Start am:</b></td>
	 	<td><b>Max. Teilnehmer:</b> </td>
	 </tr>
	 {section name=cup loop=$attach_cupsentered}
	 	<tr bgcolor="{#clr_content#}">
	 		<td><A href="{$url_file}page={$ATTACH_MODULE_ID}:info&cup_id={$attach_cupsentered[cup]->id}"><b>{$attach_cupsentered[cup]->name}</b></a></td>
	 		<td><b>{date timestamp=$attach_cupsentered[cup]->start_time}</td>
	 		<td><b>{$attach_cupsentered[cup]->max_participants}</td>
	 	</tr>
	 {/section}
	 </table>
 {/if}