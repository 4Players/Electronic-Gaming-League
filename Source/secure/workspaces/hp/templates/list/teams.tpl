<h2>Team Suchen</h2>

<form name="fmsearch" method="POST">	
<table border="0" width="100%" cellpadding="4" cellspacing="1" bgcolor="{#clr_content_border#}">
 <tr bgcolor="{#clr_content#}"><td valign="top">

	<table border="0" width="50%">
	 <tr>
	 	<td width="40%"><B>ID: </b></td>
	 	<td><input name="id" type="text" class="egl_text"></td>
	 </tr>
	 <tr>
	 	<td><B>Name: </b></td>
	 	<td><input name="name" type="text" class="egl_text"></td>
	 </tr>
	 <tr>
	 	<td><B>Kürzel: </b></td>
	 	<td><input name="tag" type="text" class="egl_text"></td>
	 </tr>
	</table> 
	
	 
 </td></tr>
 <tr bgcolor="{#clr_content#}" align="right">
 	<td colspan="2">{include file="buttons/bt_universal.tpl" color=$GLOBAL_COLOR caption="Suche starten" link="javascript:document.fmsearch.submit();"}</td>
 </tr>
 	
</table>
</form>





{if $search_success}
<br>

<table border="0" width="100%" cellpadding="4" cellspacing="1" bgcolor="{#clr_content_border#}">
 <tr><td colspan="2" align="center"> <b>Suchergebnisse ({$num_results})</b> </td></tr>
	<tr bgcolor="{#clr_content#}"><td valign="top">
		
		<table border="0" width="100%">
			<tr>
				<td><b><u>ID</td>
				<td><b><u>Clan</td>
				<td><b><u>Team</td>
			</tr>
			{section name=clan loop=$results}
			<tr>
				<td>{$results[clan]->id}</td>
				<td><A href="{$url_file}page=clan.info&clan_id={$results[clan]->clan_id}">{$results[clan]->clan_name|strip_tags}</a></td>
				<td><A href="{$url_file}page=team.info&team_id={$results[clan]->id}">{$results[clan]->name|strip_tags}</a></td>
			</tr>
			{/section}
		
		</table>
		 

 	</td>
 </tr>
</table>

{/if}