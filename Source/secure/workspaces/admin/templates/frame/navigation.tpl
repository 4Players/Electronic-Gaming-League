<table border="0" width="100%" cellpadding="0" cellspacing="0" height="100%">
 <tr><td>

<table bgcolor="#ffffff" border="0" width="100%" cellpadding="0" cellspacing="1" height="100%">
 <tr>
 
 	<td height="1%" align="right" background="images/configsheet_navi.gif" style="background-repeat:no-repeat;">
 	
 		<b>Version {$EGL_CURRENT_VERSION}</b>
	 	<table border="0" width="100%">
	 	 <tr>
	 		<td><A target="page" href="{$url_file}page=home"><img src="images/spacer.gif" border="0" width="100" height="70"/></a><td>
	 	 </tr>
	 	</table>
	 	
 	</td>
  </tr>
  <tr>
 	<td valign="top">
 	<br/><br/>
 	{*************************** MENU Pagestore ******************************************}
	{if !isset($_session.menu_pagestore)}{session var="menu_pagestore" value="no"}{/if}
	{if $_get.navi_menu=="menu_pagestore"}
		{if $_get.a == "yes" }
			{session var="menu_pagestore" value="yes"}
		{else}
			{session var="menu_pagestore" value="no"}
		{/if}
	{/if}

	{if $_session.menu_pagestore == "yes"}
		{assign var="menu_pagestore_action" value="no"}
	{else}
		{assign var="menu_pagestore_action" value="yes"}
	{/if}	
	
	{include file="tb/dmenu_left.open.tpl" title="Bookmarks" menu_type="menu_pagestore" menu_action=$menu_pagestore_action }
	{if $_session.menu_pagestore == "yes"}
		<tr>
		 <td colspan="2">
			<table border="0" cellpadding="2" cellspacing="0" width="100%" align="right">
				{if sizeof($smarty.session.pagestore)}
				<tr>
					<td colspan="3">
						<table cellpadding="0" cellspac	ing="0"><tr>
							<td><img src="images/admin/navi/pagestore_folder.gif"/></td>
							<td><img src="images/spacer.gif" width="10" height="1"/></td>
							<td><b>Archiv</b></td>
						</tr></table>
					</td>
				</tr>
				{/if}
			 	{section name=p loop=$smarty.session.pagestore}
				 <tr onmouseover="javascript:this.style.backgroundColor='#FFFFFF';"
					 onmouseout="javascript:this.style.backgroundColor='';"
				 	>
	 				<td onclick="javascript:parent.page.location.href='{$smarty.session.pagestore[p].link}';" width="1%" align="center"><img src="images/admin/navi/pagestore.gif"></td>
	 				<td onclick="javascript:parent.page.location.href='{$smarty.session.pagestore[p].link}';">
	 					<A title="Bookmark anzeigen" target="page" href="{$smarty.session.pagestore[p].link}"><b>{$smarty.session.pagestore[p].name|strip_tags|stripslashes}</b></a><br/>
	 					<font style="font-size:10px">erstellt am {date format="%d.%m %H:%M" timestamp=$smarty.session.pagestore[p].created}</font>
	 				</td>
	 				<td align="center"><A title="Bookmark löschen" href="javascript:document.location.href='{$url_file}page={$url_page}&del_page={$smarty.section.p.index}';"><img border="0" src="images/admin/navi/button_cancel.gif"/></a></td>
				 </tr>
				{sectionelse}
				 <tr>
					<td>Keine Einträge vorhanden</td>
				 </tr>
			 	{/section}
			</table>
		</td></tr>			
	{/if}
	{include file="tb/dmenu_left.close.tpl"}	

	{*************************** MENU GENERALS ******************************************}
	{if !isset($_session.menu_generals)}{session var="menu_generals" value="no"}{/if}
	{if $_get.navi_menu=="menu_generals"}
		{if $_get.a == "yes" }
			{session var="menu_generals" value="yes"}
		{else}
			{session var="menu_generals" value="no"}
		{/if}
	{/if}

			 		
	{if $_session.menu_generals == "yes"}
		{assign var="menu_generals_action" value="no"}
	{else}
		{assign var="menu_generals_action" value="yes"}
	{/if}				 	
				 		
	{include file="tb/dmenu_left.open.tpl" title="Allgemein" menu_type="menu_generals" menu_action=$menu_generals_action}
	{if $_session.menu_generals == "yes"}
		{*include file="tb/dmenu_left.item.tpl" 	name="Übersicht" 			link="generals.overview" 		image="images/admin/navi/overview.gif"*}
		{*include file="tb/dmenu_left.item.tpl" 		name="Server Nachrichten" 	link="generals.svr_messages" 	image="images/admin/navi/server_infos.gif"*}
		{include file="tb/dmenu_left.item.tpl" 		name="Statistiken" 			link="generals.statistics" 	image="images/admin/navi/statistics.gif"}
		{include file="tb/dmenu_left.item.tpl" 		name="Paswortschutz" 		link="generals.passwords" 		image="images/admin/navi/password.gif"}
		{include file="tb/dmenu_left.item.tpl" 		name="Updates" 				link="generals.updates" 		image="images/admin/navi/updates.gif"}
		{*include file="tb/dmenu_left.item.tpl" 	name="Freischalten" 		link="generals.license" 		image="images/admin/navi/certificate.gif"*}
		{include file="tb/dmenu_left.item.tpl" 		name="Sprachen" 			link="generals.languages" 	image="images/admin/navi/language.gif"}
	{/if}
	{include file="tb/dmenu_left.close.tpl"}
	
 	{*************************** MENU E-SPORT CMS ******************************************}
	{if !isset($_session.menu_cms)}{session var="menu_cms" value="no"}{/if}
	{if $_get.navi_menu=="menu_cms"}
		{if $_get.a == "yes" }
			{session var="menu_cms" value="yes"}
		{else}
			{session var="menu_cms" value="no"}
		{/if}
	{/if}

			 		
	{if $_session.menu_cms == "yes"}
		{assign var="menu_cms_action" value="no"}
	{else}
		{assign var="menu_cms_action" value="yes"}
	{/if}				 	

	{include file="tb/dmenu_left.open.tpl" title="E-Sport CMS"  menu_type="menu_cms" menu_action=$menu_cms_action}
	{if $_session.menu_cms == "yes"}
		{*include file="tb/dmenu_left.item.tpl" name="Übersicht"		 	link="cms.overview" 					image="images/admin/navi/overview.gif"*}
		{include file="tb/dmenu_left.item.tpl" 	name="Onlineliste" 			link="cms.online.memberlist" 			image="images/admin/navi/clock.gif"}
		{include file="tb/dmenu_left.item.tpl" 	name="Spiele" 				link="cms.game.overview" 				image="images/admin/navi/games.gif"}
		{include file="tb/dmenu_left.item.tpl" 	name="Administratoren" 		link="cms.adminlist" 					image="images/admin/navi/admin.gif"}
		{include file="tb/dmenu_left.item.tpl" 	name="Mitglieder" 			link="cms.memberlist" 					image="images/admin/navi/member.gif"}
		{include file="tb/dmenu_left.item.tpl" 	name="Clans" 				link="cms.clanlist" 					image="images/admin/navi/clan.gif"}
		{include file="tb/dmenu_left.item.tpl" 	name="Teams" 				link="cms.teamlist" 					image="images/admin/navi/team.gif"}
		{include file="tb/dmenu_left.item.tpl" 	name="Matches" 				link="cms.matchlist" 					image="images/admin/navi/matches.gif"}
		{include file="tb/dmenu_left.item.tpl" 	name="Match Strukturen" 	link="cms.match_structures.overview"	image="images/admin/navi/match_structures.gif"}
		{include file="tb/dmenu_left.item.tpl" 	name="Map-Collections" 		link="cms.map_collections.overview"	image="images/admin/navi/map_collections.gif"}
		{include file="tb/dmenu_left.item.tpl" 	name="EGL.Viewer" 			link="cms.eglviewer.overview" 			image="images/admin/navi/eglviewer.gif"}
		{*include file="tb/dmenu_left.item.tpl" name="EGL.Module" 			link="cms.modules" 					image="images/admin/navi/modules_overview.gif"*}
	{/if}
	{include file="tb/dmenu_left.close.tpl"}		
	
 	{*************************** MENU E-SPORT SETTINGS ******************************************}
	{if !isset($_session.menu_esport_settings)}{session var="menu_esport_settings" value="no"}{/if}
	{if $_get.navi_menu=="menu_esport_settings"}
		{if $_get.a == "yes" }
			{session var="menu_esport_settings" value="yes"}
		{else}
			{session var="menu_esport_settings" value="no"}
		{/if}
	{/if}

			 		
	{if $_session.menu_esport_settings == "yes"}
		{assign var="menu_esport_settings_action" value="no"}
	{else}
		{assign var="menu_esport_settings_action" value="yes"}
	{/if}	

	{*
	{include file="tb/dmenu_left.open.tpl" title="E-Sport Einstellungen"  menu_type="menu_esport_settings" menu_action=$menu_esport_settings_action}
	{if $_session.menu_esport_settings == "yes"}
	{/if}
	{include file="tb/dmenu_left.close.tpl"}		
	*}
	
	
 	{*************************** MENU MODULES ******************************************}
	{if !isset($_session.menu_modules)}{session var="menu_modules" value="no"}{/if}
	{if $_get.navi_menu=="menu_modules"}
		{if $_get.a == "yes" }
			{session var="menu_modules" value="yes"}
		{else}
			{session var="menu_modules" value="no"}
		{/if}
	{/if}

			 		
	{if $_session.menu_modules == "yes"}
		{assign var="menu_modules_action" value="no"}
	{else}
		{assign var="menu_modules_action" value="yes"}
	{/if}			
	
	{include file="tb/dmenu_left.open.tpl" title="Module" menu_type="menu_modules" menu_action=$menu_modules_action }
	{if $_session.menu_modules == "yes"}
		{*include file="tb/dmenu_left.item.tpl" name="Übersicht" 				link="modules.overview" image="images/admin/navi/overview.gif"*}
		{include file="tb/dmenu_left.item.tpl" name="EGL <b>Live!</b>"	 	link="modules.live" 	image="images/admin/navi/module_live.gif"}
		{include file="tb/dmenu_left.item.tpl" name="Module verwalten" 	link="modules.admin" image="images/admin/navi/add_remove_module.gif"}
		
		<tr><td colspan="2">
		<div align="right"><font color="C5C3BF"><b>Installiert</b></font></div
		<hr size="1" color="#E5E3DF">
		<table border="0" cellpadding="4" cellspacing="0" width="90%" align="right">
		 	{section name=mod loop=$modules}
			 <tr>
		 		{if $modules[mod]->bInstalled}
	 				<td width="1%"><img src="images/admin/navi/module_overview.gif"></td><td>  <a title="Öffne {$modules[mod]->sName}" href="{$url_file}page={$modules[mod]->ID}:overview"><b>{$modules[mod]->sName}</b></a></td>
		 		{/if}
			 </tr>
		 	{/section}
		</table>
	</td></tr>
	{/if}
	{include file="tb/dmenu_left.close.tpl"}
	
 	{*************************** MENU db_storage ******************************************}
	{if !isset($_session.menu_db_storage)}{session var="menu_db_storage" value="no"}{/if}
	{if $_get.navi_menu=="menu_db_storage"}
		{if $_get.a == "yes" }
			{session var="menu_db_storage" value="yes"}
		{else}
			{session var="menu_db_storage" value="no"}
		{/if}
	{/if}

			 		
	{if $_session.menu_db_storage == "yes"}
		{assign var="menu_db_storage_action" value="no"}
	{else}
		{assign var="menu_db_storage_action" value="yes"}
	{/if}		
	
	{include file="tb/dmenu_left.open.tpl" title="Datenbank & Speicher" menu_type="menu_db_storage" menu_action=$menu_db_storage_action }
	{if $_session.menu_db_storage == "yes"}
		{*include file="tb/dmenu_left.item.tpl" name="Übersicht" 		link="db_storage.overview" image="images/admin/navi/overview.gif"*}
		{include file="tb/dmenu_left.item.tpl" name="Einstellungen" 	link="db_storage.settings" image="images/admin/navi/settings.gif"}
		{*include file="tb/dmenu_left.item.tpl" name="Storage" 			link="db_storage.storage" 	image="images/admin/navi/storage.gif"*}
		{*include file="tb/dmenu_left.item.tpl" name="Status" 			link="db_storage.dbstatus" image="images/admin/navi/db_status.gif"*}
		{*include file="tb/dmenu_left.item.tpl" name="Backups" 			link="db_storage.backup" 	image="images/admin/navi/backup.gif"*}
		{*include file="tb/dmenu_left.item.tpl" name="Import" 			link="db_storage.import" 	image="images/admin/navi/db_import.gif"*}
		{*include file="tb/dmenu_left.item.tpl" name="Export" 			link="db_storage.export" 	image="images/admin/navi/db_export.gif"*}
		{include file="tb/dmenu_left.item.tpl" name="Synchronisieren" 	link="db_storage.synchron" image="images/admin/navi/db_synchron.gif"}
	{/if}
	{include file="tb/dmenu_left.close.tpl"}
	

 	{*************************** MENU debugging ******************************************}
	{if !isset($_session.menu_debugging)}{session var="menu_debugging" value="no"}{/if}
	{if $_get.navi_menu=="menu_debugging"}
		{if $_get.a == "yes" }
			{session var="menu_debugging" value="yes"}
		{else}
			{session var="menu_debugging" value="no"}
		{/if}
	{/if}

			 		
	{if $_session.menu_debugging == "yes"}
		{assign var="menu_debugging_action" value="no"}
	{else}
		{assign var="menu_debugging_action" value="yes"}
	{/if}	
	
	{include file="tb/dmenu_left.open.tpl" title="Debugging" menu_type="menu_debugging" menu_action=$menu_debugging_action }
	{if $_session.menu_debugging == "yes"}
		{include file="tb/dmenu_left.item.tpl" 	name="Build-Protokolle" 	link="debugging.buildprotocol.overview" 			image="images/admin/navi/overview.gif"}
		{include file="tb/dmenu_left.item.tpl" 	name="Einstellungen" 		link="debugging.buildprotocol.settings" 							image="images/admin/navi/configure.gif"}
	{/if}
	{include file="tb/dmenu_left.close.tpl"}			
		
	
	<br/><br/>	
	<div align="center">
		<font size="1px">Copyright &copy;2006 <A title="Publishment & Development by Ínetopia" target="_blank" href="http://www.inetopia.de">Inetopia</a>.<br/>All rights reserved.</font>
	</div>
	
  </td> </tr>
 </table>	

 </td>
 <td  background="images/admin/menu_right_bg.gif" style="background-repeat:repeat-y;"><img src="images/spacer.gif" width="5"></td>
</tr></table>