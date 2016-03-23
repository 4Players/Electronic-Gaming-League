<h2>Wer ist online?</h2>

<div align="right">
	<A href="javascript: window.location.reload()"><b>Refresh</b></a>&nbsp;
</div>

<hr size="1"/>

{literal}
<script language="javascript"> 
	function load_bgcolor(obj, color ) { obj.style.backgroundColor 	= color;}
</script>
{/literal}


	<table cellpadding="5" cellspacing="0" bgcolor="{#clr_content#}" width="100%">
	 <tr bgcolor="{#clr_content_border#}">
	 	<td></td>
	 	<td><b>Mitglied-ID</b></td>
	 	<td><b>Nickmame</b></td>
	 	<td><b>E-Mail</b></td>
	 	<td><b>Letzte aktualisiert</b></td>
	 	<td><b>Welche Seite?</b></td>
	 	<td><b>Option</b></td>
	 </tr>
	{section name=member loop=$online_members}
		<tr onmouseover="javascript:load_bgcolor(this, '#FFC466');" onmouseout="javascript:load_bgcolor(this, '{#clr_content#}');">
			{if $online_members[member]->invisible}<td><img title="Dieses Mitglied hat den Invisible Mode aktiviert" src="images/invisible.gif"/></td>{else}<td></td>{/if}
			
			<td align="center">{$online_members[member]->id}</td>
			<td>{$online_members[member]->nick_name|strip_tags|stripslashes}</td>
			<td>{$online_members[member]->email}</td>
			<td>{date timestamp=$online_members[member]->last_action}</td>
			<td><A href="{$url_file}page={$online_members[member]->last_page}">Zur Seite</a></td>
			<td>
			  	<A title="Mitglied Profile anzeigen/bearbeiten" href="{$url_file}page=member.info&member_id={$online_members[member]->id}"><b>Details</b></a> &nbsp;·&nbsp; 
			  	<A title="Mitglied Profile anzeigen/bearbeiten" href="{$url_file}page=administration.member.profile&member_id={$online_members[member]->id}"><b>Profil</b></a> &nbsp;·&nbsp; 
			  	<A title="Mitglied Profile anzeigen/bearbeiten" href="{$url_file}page=administration.member.central&member_id={$online_members[member]->id}"><b>Zentrale</b></a> 
			</td>
		</tr>
	{/section}
	</table>