{include file="tb/page.open.tpl"}

<h2>Mitglieder</h2>


<br/>

<form action="{$url_file}page={$url_page}&a=search" method="POST">
<table border=0 cellpadding=0 cellspacing=1 bgcolor="#C5C5C5" align="">
 <tr><td>
 
	<table border="0" width="300" cellpadding=5 cellspacing=0 bgcolor="#F5F3EF">
	 <tr>
	 	<td bgcolor="#E8E5DE" align="center" colspan=2><h3>Schnellsuche</h3></td>
	 </tr>
	 <tr>
	 	<td><b>ID:</td>
	 	<td> <input type="text" class="egl_text" name="search_id"> </td>
	 </tr>
	 <tr>
	 	<td><b>E-Mail:</td>
	 	<td> <input type="text" class="egl_text" name="search_email"> </td>
	 </tr>
	 <tr>
	 	<td><b>Nick Name:</td>
	 	<td> <input type="text" class="egl_text" name="search_nickname"> </td>
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
Insgesamt {$num_members} Mitglieder vorhanden, davon werden {$members|@count} angezeigt.
<hr size="0" color="#C5C5C5" width="100%" align="left"><br/>
{if $_get.a == "search"}<h2>Suchergebnisse</h2>{/if}

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
						<td><a href="{$url_file}page={$url_page}&pos={$smarty.section.page.index*$members_per_page}&order={$_get.order}"><b><u>{$smarty.section.page.index+1}</u></b></a></td>
					{else}
						<td><a href="{$url_file}page={$url_page}&pos={$smarty.section.page.index*$members_per_page}&order={$_get.order}">{$smarty.section.page.index+1}</a></td>
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
	 	{if $_get.order=="banned"}<td align="center" width="1%" bgcolor="#FFCF6F">{else}<td align="center" width="1%">{/if}<A href="{$url_file}page={$url_page}&order=banned&a={$_get.a}&a={$_get.a}&order_type={if $_get.order_type=='asc' AND $_get.order=='banned'}desc{else}asc{/if}"><b>L</b></a></td> 
	 	<td align="center" width="30"><b>P</b></td>
	 	{if $_get.order=="id"}<td bgcolor="#FFCF6F">{else}<td>{/if}<A href="{$url_file}page={$url_page}&order=id&a={$_get.a}&order_type={if $_get.order_type=='asc' AND $_get.order=='id'}desc{else}asc{/if}"><b>ID</b></a></td>
	 	{if $_get.order=="nick_name"}<td bgcolor="#FFCF6F">{else}<td>{/if}<A href="{$url_file}page={$url_page}&order=nick_name&a={$_get.a}&order_type={if $_get.order_type=='asc' AND $_get.order=='nick_name'}desc{else}asc{/if}"><b>Nick-Name</b></a></td>
	 	{if $_get.order=="email"}<td bgcolor="#FFCF6F">{else}<td>{/if}<A href="{$url_file}page={$url_page}&order=email&a={$_get.a}&order_type={if $_get.order_type=='asc' AND $_get.order=='email'}desc{else}asc{/if}"><b>E-Mail</b></a></td>
	 	<td width="220"><b>Options</b></td>
	 	{if $_get.order=="last_login"}<td bgcolor="#FFCF6F">{else}<td>{/if}<A href="{$url_file}page={$url_page}&order=last_login&a={$_get.a}&order_type={if $_get.order_type=='asc' AND $_get.order=='last_login'}desc{else}asc{/if}"><b>Letzter Login</b></a></td>
	 	{if $_get.order=="created"}<td bgcolor="#FFCF6F">{else}<td>{/if}<A href="{$url_file}page={$url_page}&order=created&a={$_get.a}&order_type={if $_get.order_type=='asc' AND $_get.order=='created'}desc{else}asc{/if}"><b>Registriert am.</b></a></td>
	  </tr>
	 {section name=member loop=$members}
	  <tr bgcolor="{#clr_content#}" onmouseover="javascript:load_bgcolor(this, '#FFFFFF');" onmouseout="javascript:load_bgcolor(this, '{#clr_content#}');">
	  	{if $members[member]->banned}<td><A title="Mitglied entsperren" href="{$url_file}page=cms.member.central&member_id={$members[member]->id}"><img src="images/locked.gif" border="0"/></a></td>{/if}
	  	{if !$members[member]->banned}<td><A title="Mitglied sperren" href="{$url_file}page=cms.member.central&member_id={$members[member]->id}"><img src="images/unlocked.gif" border="0"/></a></td>{/if}
 	
	  	{if $members[member]->premium_activation > 0}<td><img src="images/premium_icon_active.gif"/></td>{/if}
	  	{if $members[member]->premium_activation == 0}<td><img src="images/premium_icon_inactive.gif"/></td>{/if}
	 	
		<td>{$members[member]->id}</td>  
		<td>{$members[member]->nick_name|strip_tags|stripslashes}</td>  
		<td><A title="E-Mail schicken" href="mailto:{$members[member]->email}">{$members[member]->email}</td>  
		<td>
		  	<A title="GameAccounts Übersicht" href="{$url_file}page=cms.member.gameaccounts&member_id={$members[member]->id}"><b>GameAccounts</b></a>  &nbsp;&middot;&nbsp; 
		  	<A title="Mitglied Profile anzeigen/bearbeiten" href="{$url_file}page=cms.member.profile&member_id={$members[member]->id}"><b>Profil</b></a> &nbsp;&middot;&nbsp; 
		  	<A title="Mitglied Profile anzeigen/bearbeiten" href="{$url_file}page=cms.member.central&member_id={$members[member]->id}"><b>Zentrale</b></a> 

		</td>
		<td>{date timestamp=$members[member]->last_login}</td>  
		<td>{date timestamp=$members[member]->created}</td>  
	  </tr>
	 {/section}
	 {if sizeof($members)==0}
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
				<table cellpadding="2">
				<tr>
				<td><b>Seite:</b> </td>
				{section name=page loop=$num_pages}
				{if $smarty.section.page.index > $curr_page-10  &&  $smarty.section.page.index < $curr_page+10 }
					{if ($smarty.section.page.index == $curr_page) AND !isset($_get.a) }
						<td><a href="{$url_file}page={$url_page}&pos={$smarty.section.page.index*$members_per_page}"><b><u>{$smarty.section.page.index+1}</u></b></a></td>
					{else}
						<td><a href="{$url_file}page={$url_page}&pos={$smarty.section.page.index*$members_per_page}">{$smarty.section.page.index+1}</a></td>
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