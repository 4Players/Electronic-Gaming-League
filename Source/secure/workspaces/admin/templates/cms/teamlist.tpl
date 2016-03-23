<h2>Teams</h2>

<br>

<form action="{$url_file}page={$url_page}&a=search" method="POST">
<table border=0 cellpadding=0 cellspacing=1 bgcolor="#C5C5C5" align="">
 <tr><td>
 
	<table border="0" width="300" cellpadding=5 cellspacing=0 bgcolor="#F5F3EF">
	 <tr>
	 	<td bgcolor="#E8E5DE" align="center" colspan=2><h3>Suchfunktion</h3></td>
	 </tr>
	 <tr>
	 	<td><b>ID:</td>
	 	<td> <input type="text" class="egl_text" name="search_id"/> </td>
	 </tr>
	 <tr>
	 	<td><b>Clan-ID:</td>
	 	<td> <input type="text" class="egl_text" name="search_clanid"/> </td>
	 </tr>
	 <tr>
	 	<td><b>Team-Name:</td>
	 	<td> <input type="text" class="egl_text" name="search_name"/> </td>
	 </tr>
	 <tr>
	 	<td><b>Team-Tag:</td>
	 	<td> <input type="text" class="egl_text" name="search_tag"/> </td>
	 </tr>
	 <tr>
	 	<td></td>
	 	<td><input type="checkbox" type="egl_checkbox" name="similar_filter" value="yes"/>Ähnlichkeits Filter aktivieren</td>
	 </tr>
	 <tr>
	 	<td></td>
	 	<td><input type="image" src="images/buttons/new/bt_search.gif" ></td>
	 </tr>
	</table>
	
 </td></tr>
</table>
</form>

<br>
Insgesamt {$num_teams} Teams vorhanden, davon werden {$teamlist|@count} angezeigt.
<hr size="0" color="#C5C5C5" width="100%" align="left"/><br>

<table border="0" width="100%" cellpadding="4" cellspacing="1">
 <tr>
 	<td>
		<table border="0" width="100%">
		 <tr>
		 	<td width="50%"><b>Seite {$curr_page+1} von {$num_pages}</b></td>
		 	<td align="right">
				<table cellpadding="2">
				<tr>
				<td><b>Seite:</b> </td>
				{section name=page loop=$num_pages}
				{if $smarty.section.page.index > $curr_page-10  &&  $smarty.section.page.index < $curr_page+10 }
					{if ($smarty.section.page.index == $curr_page) AND !isset($_get.a) }
						<td><a href="{$url_file}page={$url_page}&pos={$smarty.section.page.index*$teams_per_page}"><b><u>{$smarty.section.page.index+1}</u></b></a></td>
					{else}
						<td><a href="{$url_file}page={$url_page}&pos={$smarty.section.page.index*$teams_per_page}">{$smarty.section.page.index+1}</a></td>
					{/if}
				{/if}
				{/section}
				</tr>
				</table>
			</td>
		 </tr>
		</table>
 	</td>
 </tr>
</table>

{literal}
<script language="javascript"> 
	function load_bgcolor(obj, color ) { obj.style.backgroundColor 	= color;}
</script>
{/literal}


<div align="right">
	<A href="{$url_file}page={$url_page}&a=listall"><img border=0 src="images/buttons/new/bt_listall.gif"></a>
	<A href="javascript: window.location.reload()"><img border=0 src="images/buttons/new/bt_refresh.gif"></a>
</div>

<table border=0 cellpadding=0 cellspacing=2 bgcolor="#C5C5C5" width="100%">
 <tr><td>
	<table border="0" width="100%" bgcolor="#FFFFFF" cellpadding="5" cellspacing="1" align="center">
	 <tr bgcolor="#E8E5DE">
	 	{if $_get.order=="id"}<td bgcolor="#FFCF6F" width="1%">{else}<td width="1%">{/if}<A href="{$url_file}page={$url_page}&order=id&a={$_get.a}&order_type={if $_get.order_type=='asc' AND $_get.order=='id'}desc{else}asc{/if}"><b>T-ID</b></td>
	 	<td align="center" width="30"><b>P</b></td>
	 	{if $_get.order=="name"}<td bgcolor="#FFCF6F">{else}<td>{/if}<A href="{$url_file}page={$url_page}&order=name&a={$_get.a}&order_type={if $_get.order_type=='asc' AND $_get.order=='name'}desc{else}asc{/if}"><b>T-Name</b></a></td>
	 	{if $_get.order=="tag"}<td bgcolor="#FFCF6F">{else}<td>{/if}<A href="{$url_file}page={$url_page}&order=tag&a={$_get.a}&order_type={if $_get.order_type=='asc' AND $_get.order=='tag'}desc{else}asc{/if}"><b>T-Tag</b></a></td>
	 	{if $_get.order=="clan_tag"}<td bgcolor="#FFCF6F">{else}<td>{/if}<A href="{$url_file}page={$url_page}&order=clan_tag&a={$_get.a}&order_type={if $_get.order_type=='asc' AND $_get.order=='clan_tag'}desc{else}asc{/if}"><b>C-Name</b></a></td>
	 	{if $_get.order=="clan_id"}<td bgcolor="#FFCF6F">{else}<td>{/if}<A href="{$url_file}page={$url_page}&order=clan_id&a={$_get.a}&order_type={if $_get.order_type=='asc' AND $_get.order=='clan_id'}desc{else}asc{/if}"><b>C-ID</b></a></td>
	 	{if $_get.order=="num_teammembers"}<td bgcolor="#FFCF6F">{else}<td>{/if}<A href="{$url_file}page={$url_page}&order=num_teammembers&a={$_get.a}&order_type={if $_get.order_type=='asc' AND $_get.order=='num_teammembers'}desc{else}asc{/if}"><b>Anz. Mitglieder</b></a></td>
	 	<td width="200"><b>Options</b></td>
	 	{if $_get.order=="created"}<td bgcolor="#FFCF6F" width="150">{else}<td width="150">{/if}<A href="{$url_file}page={$url_page}&order=created&a={$_get.a}&order_type={if $_get.order_type=='asc' AND $_get.order=='created'}desc{else}asc{/if}"><b>Registriert am.</b></a></td>
	  </tr>
	 {section name=team loop=$teamlist}
	  <tr bgcolor="{#clr_content#}" onmouseover="javascript:load_bgcolor(this, '#FFFFFF');" onmouseout="javascript:load_bgcolor(this, '{#clr_content#}');">
		<td>{$teamlist[team]->id}</td>  

		{if $teamlist[team]->premium_activation > 0}<td><img src="images/premium_icon_active.gif"/></td>{/if}
	  	{if $teamlist[team]->premium_activation == 0}<td><img src="images/premium_icon_inactive.gif"/></td>{/if}

		<td>{$teamlist[team]->name|strip_tags|stripslashes}</td>  
		<td>{$teamlist[team]->tag|strip_tags|stripslashes}</td>  
				
		<td>{if isset($teamlist[team]->clan_id)}<a href="{$url_file}page=cms.clan.central&clan_id={$teamlist[team]->clan_id}">{$teamlist[team]->clan_name|strip_tags|stripslashes}</a>({$teamlist[team]->clan_tag|strip_tags|stripslashes}){/if}</td>
		<td align="center">{if isset($teamlist[team]->clan_id)}{$teamlist[team]->clan_id}{/if}</td>
		<td align="center">{$teamlist[team]->num_teammembers}</td>  
		<td>
		  	<A title="Mitglied Profile anzeigen/bearbeiten" href="{$url_file}page=cms.team.profile&team_id={$teamlist[team]->id}"><b>Profil</b></a> &nbsp;&middot;&nbsp; 
		  	<A title="Mitglied Profile anzeigen/bearbeiten" href="{$url_file}page=cms.team.central&team_id={$teamlist[team]->id}"><b>Zentrale</b></a> 

		</td>
		<td>{date timestamp=$teamlist[team]->created}</td>  
	  </tr>
	 {/section}
	 {if sizeof($teamlist)==0}
	 	<tr><td colspan="8">Keine Einträge gefunden</td></tr>
	 {/if}
	 
	 </table>
	 
 </td></tr>
</table>	

<div align="right">
	<A href="{$url_file}page={$url_page}&a=listall"><img border=0 src="images/buttons/new/bt_listall.gif"></a>
	<A href="javascript: window.location.reload()"><img border=0 src="images/buttons/new/bt_refresh.gif"></a>
</div>


<table border="0" width="100%" cellpadding="4" cellspacing="1">
 <tr>
 	<td>
		<table border="0" width="100%">
		 <tr>
		 	<td width="50%"><b>Seite {$curr_page+1} von {$num_pages}</b></td>
		 	<td align="right">
				<table>
				<tr>
				<td><b>Seite:</b> </td>
				{section name=page loop=$num_pages}
					{if ($smarty.section.page.index == $curr_page) AND !isset($_get.a) }
						<td><A href="{$url_file}page={$url_page}&pos={$smarty.section.page.index*$teams_per_page}"><b><u>{$smarty.section.page.index+1}</u></b></a></td>
					{else}
						<td><A href="{$url_file}page={$url_page}&pos={$smarty.section.page.index*$teams_per_page}"><b>{$smarty.section.page.index+1}</b></a></td>
					{/if}
				{/section}
				</tr>
				</table>
			</td>
		 </tr>
		</table>
 	</td>
 </tr>
</table>