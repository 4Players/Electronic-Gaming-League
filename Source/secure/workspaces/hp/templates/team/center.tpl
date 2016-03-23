<h2>{$LNG_BASIC.c2600} `{$team->name|strip_tags|stripslashes}`</h2>

<table border="0" cellpadding="10" cellspacing="5" width="100%">
 <tr>
 	<td valign="top" width="10%" align="center">

 	
			 		<table border="0" cellpadding="0" cellspacing="1" bgcolor="{#clr_content_border#}">
			 		 <tr><td>  		 	
			 			{if $team->logo_file != 'non'}
					 		<A title="{$LNG_BASIC.c2500}" href="{$url_file}page=team.info&team_id={$team->id}"><img src="{$path_logos}teams/{$team->logo_file}" width="100" height="100" border="0"/></a>
					 	{else}
					 		<A title="{$LNG_BASIC.c2500}" href="{$url_file}page=team.info&team_id={$team->id}"><img src="images/logo.na.jpg" width="100" height="100" border="0"></a>
				 		{/if}
				 		
					 </td></tr>
					</table>	 		
		
 	</td>
	<td valign="top">
 						<font color="{#clr_header#}" face="arial" size="2"><b>{$LNG_BASIC.c2601}</b></font> <br/>
						<A href='{$url_file}page=team.profile&team_id={$team->id}'>{$LNG_BASIC.c2602}</a> <br/>
			 			<A href='{$url_file}page=team.select_games&team_id={$team->id}'>{$LNG_BASIC.c2603}</a>	<br/>
			 			<A href='{$url_file}page=team.logo&team_id={$team->id}'>{$LNG_BASIC.c2604}</a>	<br/>
			 			<A href='{$url_file}page=team.delete&team_id={$team->id}'>{$LNG_BASIC.c2605}</a>	<br/>
			 			<A href='{$url_file}page=team.join_clan&team_id={$team->id}'>{$LNG_BASIC.c2606}</a>	<br/>
			 			<A href='{$url_file}page=team.quit_clan&team_id={$team->id}'>{$LNG_BASIC.c2607}</a>	<br/>
			 			
			 			<br/>
			 			
 						<font color="{#clr_header#}" face="arial" size="2"><b>{$LNG_BASIC.c2608}</b></font> <br/>
			 			<A href='{$url_file}page=team.permissions&team_id={$team->id}'>{$LNG_BASIC.c2610}</a> <br/>
			 			<A href='{$url_file}page=team.memberlist&&team_id={$team->id}'>{$LNG_BASIC.c2619}</a> <br/>
			 			<A href='{$url_file}page=team.kick&team_id={$team->id}'>{$LNG_BASIC.c2617}</a> <br/>
		 			
			 			
	</td>
	<td valign="top">
 						<font color="{#clr_header#}" face="arial" size="2"><b>{$LNG_BASIC.c2611}</b></font> <br/>
			 			<!--#<A href='{$url_file}page=match.list&team_id={$team->id}'>{$LNG_BASIC.c2612}</a #-->
			 			<A href='{$url_file}page=match.list&team_id={$team->id}'>{$LNG_BASIC.c2613}</a> <br/>
			 			
						<br/>
						
						<!--# COMING SOON #-->
						<!--# <font color="{#clr_header#}" face="arial" size="2"><b>{$LNG_BASIC.c2614}</b></font> <br/> #-->
						<!--# <A href='{$url_file}page=team.support&team_id={$team->id}'>{$LNG_BASIC.c2615}</a> <br/> #-->
						<!--# <A href='{$url_file}page=team.protests&team_id={$team->id}'>{$LNG_BASIC.c2616}</a> <br/> #-->

						
	</td>
	<td valign="top" width="25%">
			 		
					{section name=mod loop=$modules_links }
						<font color="{#clr_header#}" face="arial" size="2"><b> {$modules_links[mod]->sCaption} </b></font> <br/>
						{section name=link loop=$modules_links[mod]->aLinks}
							<A href="{eval var=$modules_links[mod]->aLinks[link]->sURL}&team_id={$team->id}">{$modules_links[mod]->aLinks[link]->sName}</a><br/> 
						{/section}
						<br/>
					{/section}			 		
	</td>
</tr>
</table>