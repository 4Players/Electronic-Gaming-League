<h2>{$LNG_BASIC.c8002}</h2>

<table width="100%">
 <tr>
 	<td><b>{$LNG_BASIC.c8003}</b></td>
 </tr>
 <tr>
 	<td>
 		<!--# SYSTEM # -->
 		<table cellpadding="10" cellspacing="5">
 			<tr>
 			{if in_array( "master", $admin_permissions) OR 
 				in_array( "members", $admin_permissions) OR
 				in_array( "cms", $admin_permissions) }
 				<td><A href="{$url_file}page=administration.member.search"><img title="Mitglieder" src="images/hpadmin/members.gif" width="50" border="0"/></a></td>
 			{else}
 				<td><img src="images/hpadmin/members_deactivated.gif" width="50" border="0"/></td>
 			{/if}
 				
 				
 			{if in_array( "master", $admin_permissions) OR 
 				in_array( "clans", $admin_permissions) OR
 				in_array( "cms", $admin_permissions) }
 				<td><A href="{$url_file}page=administration.clan.search"><img title="Clans"	   src="images/hpadmin/clans.gif" width="50" border="0" width="50"/></a></td>
 			{else}
 				<td><img src="images/hpadmin/clans_deactivated.gif" width="50" border="0" width="50"/></td>
 			{/if}
 			
 			
 			{if in_array( "master", $admin_permissions) OR 
 				in_array( "teams", $admin_permissions) OR
 				in_array( "cms", $admin_permissions) }
 				<td><A href="{$url_file}page=administration.team.search"><img title="Teams"	   src="images/hpadmin/teams.gif" width="50" border="0" width="50"/></a></td>
 			{else}
 				<td><img src="images/hpadmin/teams_deactivated.gif" width="50" border="0" width="50"/></td>
 			{/if}
 			
 						
 			{if in_array( "master", $admin_permissions) OR 
 				in_array( "matches", $admin_permissions) OR
 				in_array( "cms", $admin_permissions) }
 				<td><A href="{$url_file}page=administration.match.search"><img title="Matches"	   src="images/hpadmin/matches.gif" width="50" border="0" width="50"/></a></td>
 			{else}
 				<td><img src="images/hpadmin/matches_deactivated.gif" width="50" border="0" width="50"/></td>
 			{/if}

 			{if in_array( "master", $admin_permissions) OR 
 				in_array( "protests", $admin_permissions) OR
 				in_array( "cms", $admin_permissions) }
 				<td><A href="{$url_file}page=administration.protests.overview"><img title="Proteste"   src="images/hpadmin/protests.gif" width="50" border="0" width="50"/></a></td>
 			{else}
 				<td><img src="images/hpadmin/protests_deactivated.gif" width="50" border="0" width="50"/></td>
 			{/if}

 			{if in_array( "master", $admin_permissions) OR 
 				in_array( "onlinelist", $admin_permissions) OR
 				in_array( "cms", $admin_permissions) }
 				<td><A href="{$url_file}page=administration.online.memberlist"><img title="Onlineliste"src="images/hpadmin/onlinelist.gif" width="50" border="0" width="50"/></a></td>
 			{else}
 				<td><img src="images/hpadmin/onlinelist_deactivated.gif" width="50" border="0" width="50"/></td>
 			{/if}

 						
 			</tr>
 			<tr>
 				<td align="center">{$LNG_BASIC.c1015}</td> <!--# Members #-->
 				<td align="center">{$LNG_BASIC.c1013}</td> <!--# Clans #-->
 				<td align="center">{$LNG_BASIC.c1011}</td> <!--# Teams #-->
 				<td align="center">{$LNG_BASIC.c8009}</td> <!--# Matches #-->
 				<td align="center">{$LNG_BASIC.c2800}</td> <!--# Protests #-->
 				<td align="center">{$LNG_BASIC.c8000}</td> <!--# Onlinelist #-->
 			
 			</tr>
 		</table>
		
 	</td>
 </tr>
 <tr><td>{include file="devs/hr2.tpl" width="100%"}</td></tr>
 <tr>
 	<td><b>{$LNG_BASIC.c8004}</b></td>
 </tr>
 <tr>
 	<td>
 		<!--# Inetopia.Cups # -->
 		<table cellpadding="10" cellspacing="5">
 			{if in_array( "master", $admin_permissions) OR 
 				in_array( "cup", $admin_permissions) OR
 				in_array( "cms", $admin_permissions) }
 				<td align="center"><A href="{$url_file}page=61A47C28-FE74-488d-B8E4-A11FEDBB935A:administration.overview"><img title="Turniere" src="images/modules/inetopia_cup/hp_admin_icon.gif" width="50" border="0" width="50"/></a></td>
 			{else}
 				<td align="center"><img src="images/modules/inetopia_cup/hp_admin_icon_deactivated.gif" width="50" border="0" width="50"/></td>
 			{/if} 		
 			{if in_array( "master", $admin_permissions) OR 
 				in_array( "ladder", $admin_permissions) OR
 				in_array( "cms", $admin_permissions) }
 				<td align="center"><A href="{$url_file}page=A9CCDCBF-C696-422c-A0D8-91223A9C22E6:administration.overview"><img title="Ladder" src="images/modules/inetopia_ladder/hp_admin_icon.gif" width="50" border="0" width="50"/></a></td>
 			{else}
 				<td align="center"><img src="images/modules/inetopia_ladder/hp_admin_icon_deactivated.gif" width="50" border="0" width="50"/></td>
 			{/if} 		
 			{if in_array( "master", $admin_permissions) OR 
 				in_array( "news", $admin_permissions) OR
 				in_array( "cms", $admin_permissions) }
 				<td align="center"><A href="{$url_file}page=28D4D051-E0BE-4328-8D85-C6074695FE16:administration.overview"><img title="News" src="images/hpadmin/news.gif" width="50" border="0" width="50"/></a></td>
 			{else}
 				<td align="center"><img src="images/hpadmin/news_deactivated.gif" width="50" border="0" width="50"/></td>
 			{/if} 		
 			{if in_array( "master", $admin_permissions) OR 
 				in_array( "polls", $admin_permissions) OR
 				in_array( "cms", $admin_permissions) }
 				<td align="center"><A href="{$url_file}page=080EB2A4-10F7-4b54-AB0B-870870CC6072:administration.overview"><img title="Umfragen" src="images/hpadmin/polls.gif" width="50" border="0" width="50"/></a></td>
 			{else}
 				<td align="center"><img src="images/hpadmin/polls_deactivated.gif" width="50" border="0" width="50"/></td>
 			{/if} 		
 			<tr>
 				<td align="center">{$LNG_BASIC.c8005}</td> <!--# Tournaments #-->
 				<td align="center">{$LNG_BASIC.c8006}</td> <!--# Ladders #-->
 				<td align="center">{$LNG_BASIC.c8007}</td> <!--# News #-->
 				<td align="center">{$LNG_BASIC.c8008}</td> <!--# Polls #-->
 			</tr>
 		</table>
 		
 	</td>
 </tr> 
</table>