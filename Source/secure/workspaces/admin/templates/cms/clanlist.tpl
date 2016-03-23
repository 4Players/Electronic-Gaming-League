{include file="tb/page.open.tpl"}
<h2>Clans</h2>
<br/>
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
	 	<td><b>Clan-Name:</td>
	 	<td> <input type="text" class="egl_text" name="search_name"/> </td>
	 </tr>
	 <tr>
	 	<td><b>Clan-Tag:</td>
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

<br/>
Insgesamt {$num_clans} Clans vorhanden, davon werden {$clanlist|@count} angezeigt.
<hr size="0" color="#C5C5C5" width="100%" align="left"/><br/>

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
						<td><a href="{$url_file}page={$url_page}&pos={$smarty.section.page.index*$clans_per_page}"><b><u>{$smarty.section.page.index+1}</u></b></a></td>
					{else}
						<td><a href="{$url_file}page={$url_page}&pos={$smarty.section.page.index*$clans_per_page}">{$smarty.section.page.index+1}</a></td>
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

<div align="right">
	<A href="{$url_file}page={$url_page}&a=listall"><img border=0 src="images/buttons/new/bt_listall.gif"></a>
	<A href="javascript: window.location.reload()"><img border=0 src="images/buttons/new/bt_refresh.gif"></a>
</div>


{literal}
<script language="javascript"> 
	function load_bgcolor(obj, color ) { obj.style.backgroundColor 	= color;}
</script>
{/literal}

<table border=0 cellpadding=0 cellspacing=2 bgcolor="#C5C5C5" width="100%">
 <tr><td>
	<table border="0" width="100%" bgcolor="#FFFFFF" cellpadding="5" cellspacing="1" align="center">
	 <tr bgcolor="#E8E5DE">
	 	<td width="1%"><b>C</b></td>
	 	{if $_get.order=="id"}<td bgcolor="#FFCF6F" width="1%">{else}<td width="1%">{/if}<A href="{$url_file}page={$url_page}&order=id&a={$_get.a}&order_type={if $_get.order_type=='asc' AND $_get.order=='id'}desc{else}asc{/if}"><b>ID</b></a></td>
	 	{if $_get.order=="name"}<td bgcolor="#FFCF6F">{else}<td>{/if}<A href="{$url_file}page={$url_page}&order=name&a={$_get.a}&order_type={if $_get.order_type=='asc' AND $_get.order=='name'}desc{else}asc{/if}"><b>Clan-Name</b></a></td>
	 	{if $_get.order=="tag"}<td bgcolor="#FFCF6F">{else}<td width="10%">{/if}<A href="{$url_file}page={$url_page}&order=tag&a={$_get.a}&order_type={if $_get.order_type=='asc' AND $_get.order=='tag'}desc{else}asc{/if}"><b>Kürzel</b></a></td>
	 	{if $_get.order=="num_clanmembers"}<td bgcolor="#FFCF6F">{else}<td width="10%">{/if}<A href="{$url_file}page={$url_page}&order=num_clanmembers&a={$_get.a}&order_type={if $_get.order_type=='asc' AND $_get.order=='num_clanmembers'}desc{else}asc{/if}"><b>Anz. Mitglieder</b></a></td>
	 	<td><b>Options</b></td>
	 	{if $_get.order=="created"}<td bgcolor="#FFCF6F">{else}<td width="15%">{/if}<A href="{$url_file}page={$url_page}&order=created&a={$_get.a}&order_type={if $_get.order_type=='asc' AND $_get.order=='created'}desc{else}asc{/if}"><b>Registriert am:</b></a></td>
	  </tr>
	 {section name=clan loop=$clanlist}
	  <tr bgcolor="{#clr_content#}" onmouseover="javascript:load_bgcolor(this, '#FFFFFF');" onmouseout="javascript:load_bgcolor(this, '{#clr_content#}');">
		<td>{section name=country loop=$countries}{if $countries[country]->id == $clanlist[clan]->country_id }<img src="{$path_country}{$countries[country]->image_file}" title="Land"/>{/if}{/section}</td>  
		<td>{$clanlist[clan]->id}</td>  
		<td><A href="{$url_file}page=cms.clan.profile&clan_id={$clanlist[clan]->id}">{$clanlist[clan]->name}</a></td>  
		<td>{$clanlist[clan]->tag}</td>  
		<td align="center">{$clanlist[clan]->num_clanmembers}</td>  
		<td><!--#<A href="{$url_file}page=cms.clan.permissions&clan_id={$clanlist[clan]->id}"><b>Zugriffsrechte</b></a>  &nbsp;ï¿½&nbsp;#-->
			<A href="{$url_file}page=cms.clan.profile&clan_id={$clanlist[clan]->id}"><b>Profil</b></a> &nbsp;&middot;&nbsp; 
			<A href="{$url_file}page=cms.clan.central&clan_id={$clanlist[clan]->id}"><b>Zentrale</b></a> 
		</td>	
		<td>{date timestamp=$clanlist[clan]->created}</td>  
	  </tr>
	 {/section}
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
				<table cellpadding="2">
				<tr>
				<td><b>Seite:</b> </td>
				{section name=page loop=$num_pages}
				{if ($smarty.section.page.index == $curr_page) AND !isset($_get.a) }
					{if $smarty.section.page.index > $curr_page-10  &&  $smarty.section.page.index < $curr_page+10 }
						<td><a href="{$url_file}page={$url_page}&pos={$smarty.section.page.index*$clans_per_page}"><b><u>{$smarty.section.page.index+1}</u></b></a></td>
					{else}
						<td><a href="{$url_file}page={$url_page}&pos={$smarty.section.page.index*$clans_per_page}">{$smarty.section.page.index+1}</a></td>
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

{include file="tb/page.close.tpl"}