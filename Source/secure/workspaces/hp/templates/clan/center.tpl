<h2>{$LNG_BASIC.c4740} `{$clan->name|strip_tags|stripslashes}`</h2>

<table border="0" cellpadding="10" cellspacing="5" width="100%">
 <tr>
 	<td valign="top" width="10%" align="center">

 	
 		<table border="0" cellpadding="0" cellspacing="1" bgcolor="{#clr_content_border#}">
 		 <tr><td>  		 	
 			{if $clan->logo_file != 'non'}
		 		<A href="{$url_file}page=clan.info&clan_id={$clan->id}"><img src="{$path_logos}clans/{$clan->logo_file}" width="100" height="100" border="0"></a>

		 	{else}
		 		<A href="{$url_file}page=clan.info&clan_id={$clan->id}"><img src="images/logo.na.jpg" width="100" height="100" border="0"></a>
	 		{/if}
	 		
		 </td></tr>
		</table>	 		
		
 	</td>
 	<td valign="top" width='40%'>
 		<font color="{#clr_header#}" face="arial" size="2"><b>{$LNG_BASIC.c4741}</b></font> <br/>
		{#arrow_db_right#} <A href='{$url_file}page=clan.profile&clan_id={$clan->id}'>{$LNG_BASIC.c4742}</a> <br/>
		{#arrow_db_right#} <A href='{$url_file}page=clan.logo&clan_id={$clan->id}'>{$LNG_BASIC.c4743}</a> <br/>
		{#arrow_db_right#} <A href='{$url_file}page=clan.delete&clan_id={$clan->id}'>{$LNG_BASIC.c4744}</a> <br/>
		<!--# {#arrow_db_right#} <A href='{$url_file}page=clan.quit&clan_id={$clan->id}'>{$LNG_BASIC.c4745}</a> <br/> #-->
		
		<br/>
		
 		<font color="{#clr_header#}" face="arial" size="2"><b>{$LNG_BASIC.c4750}</b></font> <br/>
		{#arrow_db_right#} <A href='{$url_file}page=clan.create_team&clan_id={$clan->id}'>{$LNG_BASIC.c4751}</a> <br/>
		<!--# {#arrow_db_right#} <A href='{$url_file}page=team.join&clan_id={$clan->id}'>{$LNG_BASIC.c4752}</a> <br/> #-->

		<br/>
		
	</td>
 	<td valign="top">

 		<font color="{#clr_header#}" face="arial" size="2"><b>{$LNG_BASIC.c4760}</b></font> <br/>
		{#arrow_db_right#} <A href='{$url_file}page=clan.permissions&clan_id={$clan->id}'>{$LNG_BASIC.c4761}</a> <br/>
		{#arrow_db_right#} <A href='{$url_file}page=clan.invites&clan_id={$clan->id}'>{$LNG_BASIC.c4762}</a> <br/>
		{#arrow_db_right#} <A href='{$url_file}page=clan.invite&clan_id={$clan->id}'>{$LNG_BASIC.c4763}</a> <br/>
		{#arrow_db_right#} <A href='{$url_file}page=clan.kick&clan_id={$clan->id}'>{$LNG_BASIC.c4764}</a> <br/>
		
		<br/>
	</td>
</tr>
</table>




