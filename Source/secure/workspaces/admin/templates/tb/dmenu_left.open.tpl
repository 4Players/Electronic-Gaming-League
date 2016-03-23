
{if $not_available == 'yes'}
	<table border="0" bgcolor="#A80000" cellpadding="0" cellspacing="1" width="95%" align="center">
{else}
	<table border="0" bgcolor="#C0C0C0" cellpadding="0" cellspacing="1" width="95%" align="center">
{/if}
 <tr><td>
	<table width="100%" border="0" cellpadding="4" cellspacing="0" bgcolor="#F5F3EF" background="{$background}" style="background-repeat: no-repeat; background-position:center right;">
	<tr>
		<td bgcolor="#E8E5DE" colspan="2" background="images/admin/menu_bg.gif" style="background-repeat:repeat-y;">	
			<table width="100%" cellpadding="0" cellspacing="0" width="100%">
				<tr onmousedown="javascript:document.location='{$url_file}page={$url_page}&navi_menu={$menu_type}&a={$menu_action}';">
			 	<td> <A class="base_navi" href="{$url_file}page={$url_page}&navi_menu={$menu_type}&a={$menu_action}"><b>{$title}</b></a> </td>
			 	{if $menu_action == "no"} <td width="1%"><A title="Menu schließen" href="{$url_file}page={$url_page}&navi_menu={$menu_type}&a={$menu_action}"> <img src="images/admin/menu_down.gif" border="0"/></a>	</td> {/if}
			 	{if $menu_action == "yes"} <td width="1%"><A title="Menu öffnen" href="{$url_file}page={$url_page}&navi_menu={$menu_type}&a={$menu_action}"> <img src="images/admin/menu_up.gif" border="0"/></a>	</td> {/if}
			  </tr>
			 </table>
		</td>
	</tr>