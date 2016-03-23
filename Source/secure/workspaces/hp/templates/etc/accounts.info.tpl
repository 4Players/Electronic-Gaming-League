<table width="100%" cellpadding="2" cellspacing="0">
  <tr><td>
	
	
	{****************************************************}
	{* Zeige Member Account => Nur einer vorhanden ;)*}
	{****************************************************}
	
	{section name=acc loop=$memb_accounts}
		{if $memb_accounts[acc]->type == 'member'}
		{***************************************}
		
 		<table border="0" cellpadding=0 cellspacing=0 width="100%">
		 <tr><td><div align="right"><font style="font-size:12px"><b>{$LNG_BASIC.c4351}</b></font></div></td></tr>
		 <tr><td align="left">
		 
		 		<table cellpadding="0" cellspacing="0" width="100%">
		   		 <tr><td  background="images/interruped_line.gif" width="{$width}" style="background-repeat: repeat-x;"><img src="images/spacer.gif" width="1"/></td></tr>
		   		</table>
		   		
		 </td></tr>
 		 <tr>
 		 	<td>
 		 		<table border="0" width="100%">
 		 		 <tr>
 		 		 	<td width="30%">
		 		 		<!--### IMG ###-->
 		 		 		<table border="0" cellpadding=1 cellspacing=0 bgcolor="#42454B">
 		 		 		 <tr><td> 
							{if $memb_accounts[acc]->data->photo_file != 'non' }
								<A href='{$url_file}page=member.info&member_id={$memb_accounts[acc]->data->id}'><img border="0" src='files/photo_pool/{$memb_accounts[acc]->data->photo_file}' width="70" height="94"></a>
							{else}
								<A href='{$url_file}page=member.info&member_id={$memb_accounts[acc]->data->id}'><img border="0" src='images/photo.na.jpg' width="70" height="94"></a>
							{/if}
 		 		 		 </td></tr>
 		 		 		</table>
 		 		 	
 		 		 	</td>
 		 		 	<td valign="top">
		 		 		<!--### IMG ###-->
 		 		 		<table border="0" cellpadding=1 cellspacing=4>
 		 		 		 <tr><td><b>{cutstr text=$memb_accounts[acc]->data->nick_name num=15}({$memb_accounts[acc]->data->id})</b> </td></tr>
 		 		 		</table>
 		 		 		
 		 		 		<div align="left">
 		 		 			<a href="{$url_file}page=member.center"><img src="images/eglbeta/interactive.gif" border=0 /></a>
 		 		 			<a href="{$url_file}page=member.profile"><img src="images/eglbeta/configure.gif" border=0 /></a>
 		 		 			{if $pm_unread_count > 0}
 		 		 				<a href="{$url_file}page=pm.overview"><img src="images/eglbeta/mail_activated.gif" border=0 /></a>
 		 		 			{else}
 		 		 				<a href="{$url_file}page=pm.overview"><img src="images/eglbeta/mail_deactivated.gif" border=0 /></a>
 		 		 			{/if}
 		 		 			<a title="Matches" href="{$url_file}page=match.list"><img src="images/eglbeta/matches.gif" border=0 /></a>
 		 		 			
 		 		 			{if sizeof($admin_permissions) > 0 }
 		 		 				<a href="{$url_file}page=administration.overview"><img src="images/eglbeta/bt_menu_admin.gif" border=0 /></a>
 		 		 			{/if}
 		 		 		</div>
 		 		 	</td>
 		 		 </tr>
 		 		</table>
 		 		
 		 	</td>
 		 </tr>
 		</table>
 		
 		
		{/if}
	{/section}
	
	
	{****************************************************}
	{* Zeige Clan Accounts => können mehrere vorhanden sein ;)*}
	{****************************************************}
		<table border="0" cellpadding="0" cellspacing="0" width="100%">
		 <tr><td><div align="right"><font style="font-size:12px"><b>{$LNG_BASIC.c4006}</b></font></div></td></tr>
		 <tr><td align="left">
		 
		 		<table cellpadding="0" cellspacing="0" width="100%">
		   		 <tr><td  background="images/interruped_line.gif" width="{$width}" style="background-repeat: repeat-x;"><img src="images/spacer.gif" width="1"/></td></tr>
		   		</table>
		   		
		 </td></tr>
	  	 <tr><td>
		{section name=acc loop=$memb_accounts}
			{if $memb_accounts[acc]->type == 'clan'}
			{***************************************}
			{**********    C L A N S   *************}
			{***************************************}
								
		 		<table border="0" cellpadding=0 cellspacing=0 width="100%">
		 		 <tr>
		 		 	<td>
		 		 		<table border="0" width="100%">
		 		 		 <tr>
		 		 		 	<td width="30%">
				 		 		<!--### IMG ###-->
		 		 		 		<table border="0" cellpadding=1 cellspacing=0 bgcolor="#42454B">
		 		 		 		 <tr><td> 
									{if $memb_accounts[acc]->data->logo_file != 'non' }
										<A href='{$url_file}page=clan.info&clan_id={$memb_accounts[acc]->data->id}'><img border="0" src='files/logo_pool/clans/{$memb_accounts[acc]->data->logo_file}' width="70" height="70"></a>
									{else}
										<A href='{$url_file}page=clan.info&clan_id={$memb_accounts[acc]->data->id}'><img border="0" src='images/logo.na.jpg' width="70" height="70"></a>
									{/if}
		 		 		 		 </td></tr>
		 		 		 		</table>
		 		 		 	
		 		 		 	</td>
		 		 		 	<td valign="top">
				 		 		<!--### IMG ###-->
		 		 		 		<table border="0" cellpadding=1 cellspacing=4>
		 		 		 		 <tr><td> <b> {cutstr text=$memb_accounts[acc]->data->name num=15} ({$memb_accounts[acc]->data->id}) </b></td></tr>
		 		 		 		</table>
		 		 		 		
		 		 		 		<div align="left">
		 		 		 			<a href="{$url_file}page=clan.center&clan_id={$memb_accounts[acc]->data->id}"><img src="images/eglbeta/interactive.gif" border=0 /></a>
		 		 		 			<a href="{$url_file}page=clan.profile&clan_id={$memb_accounts[acc]->data->id}"><img src="images/eglbeta/configure.gif" border=0 /></a>
		 		 		 			<!--<a title="Matches" href="{$url_file}page=match.list&clan_id={$memb_accounts[acc]->data->id}"><img src="images/eglbeta/matches.gif" border=0 /></a>-->
		 		 		 		</div>
		 		 		 	</td>
		 		 		 </tr>
		 		 		</table>
		 		 		
		 		 	</td>
		 		 </tr>
		 		</table>
		 		
						 
			{/if}
		{/section}
				
		 </td></tr>
		</table>
	
	
	<table border="0" cellpadding="0" cellspacing="0" width="100%">
	 <tr><td><div align="right"><font style="font-size:12px"><b>{$LNG_BASIC.c4007}</b></font></div></td></tr>
	 <tr><td align="left">
		 
	 		<table cellpadding="0" cellspacing="0" width="100%">
	   		 <tr><td  background="images/interruped_line.gif" width="{$width}" style="background-repeat: repeat-x;"><img src="images/spacer.gif" width="1"/></td></tr>
	   		</table>
	 </td></tr>
	  <tr><td>
		{section name=acc loop=$memb_accounts}
		 {if $memb_accounts[acc]->type == 'team'}
			{***************************************}
			{**********    T E A M S   *************}
			{***************************************}
			
			
		 		<table border="0" cellpadding=0 cellspacing=0 width="100%">
		 		 <tr>
		 		 	<td>
		 		 		<table border="0" width="100%">
		 		 		 <tr>
		 		 		 	<td width="30%">
				 		 		<!--### IMG ###-->
		 		 		 		<table border="0" cellpadding=1 cellspacing=0 bgcolor="#42454B">
		 		 		 		 <tr><td> 
									{if $memb_accounts[acc]->data->logo_file != 'non' }
										<A href='{$url_file}page=team.info&team_id={$memb_accounts[acc]->data->id}'><img border="0" src='files/logo_pool/teams/{$memb_accounts[acc]->data->logo_file}' width="70" height="70"></a>
									{else}
										<A href='{$url_file}page=team.info&team_id={$memb_accounts[acc]->data->id}'><img border="0" src='images/logo.na.jpg' width="70" height="70"></a>
									{/if}
		 		 		 		 </td></tr>
		 		 		 		</table>
		 		 		 	
		 		 		 	</td>
		 		 		 	<td valign="top">
				 		 		<!--### IMG ###-->
		 		 		 		<table border="0" cellpadding=1 cellspacing=4>
		 		 		 		 <tr><td>  <b> {cutstr text=$memb_accounts[acc]->data->name num=17} ({$memb_accounts[acc]->data->id})</b>  </td></tr>
		 		 		 		</table>
		 		 		 		
		 		 		 		<div align="left">
		 		 		 			<a href="{$url_file}page=team.center&team_id={$memb_accounts[acc]->data->id}"><img src="images/eglbeta/interactive.gif" border=0 /></a>
		 		 		 			<a href="{$url_file}page=team.profile&team_id={$memb_accounts[acc]->data->id}"><img src="images/eglbeta/configure.gif" border=0 /></a>
		 		 		 			<a href="{$url_file}page=match.list&team_id={$memb_accounts[acc]->data->id}"><img src="images/eglbeta/matches.gif" border=0 /></a>
		 		 		 		</div>
		 		 		 	</td>
		 		 		 </tr>
		 		 		</table>
		 		 		
		 		 	</td>
		 		 </tr>
		 		</table>
		 		
			
		 {/if}
	 {/section}
	
	 </td></tr>
	</table>
	
 </td></tr>
</table>
