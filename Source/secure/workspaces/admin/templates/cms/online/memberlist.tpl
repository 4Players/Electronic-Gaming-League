<h2>Wer ist online?</h2>



<div align="right">
	<A href="javascript: window.location.reload()"><img border=0 src="images/buttons/new/bt_refresh.gif"></a>
</div>

<hr size="1"/>

{literal}
<script language="javascript"> 
	function load_bgcolor(obj, color ) { obj.style.backgroundColor 	= color;}
</script>
{/literal}


	<table cellpadding="5" cellspacing="1" bgcolor="#FFFFFF">
	 <tr bgcolor="#E8E5DE">
	 	<td></td>
	 	<td><b>Mitglied-ID</b></td>
	 	<td><b>Nickmame</b></td>
	 	<td><b>E-Mail</b></td>
	 	<td><b>Letzte Seiteaufruf</b></td>
	 	<td><b>Option</b></td>
	 </tr>
	{section name=member loop=$online_members}
		<tr bgcolor="{#clr_content#}" onmouseover="javascript:load_bgcolor(this, '#FFFFFF');" onmouseout="javascript:load_bgcolor(this, '');">
			<td><img src="images/admin/clock_icon.gif"/></td>
			<td align="center">{$online_members[member]->id}</td>
			<td>{$online_members[member]->nick_name}</td>
			<td>{$online_members[member]->email}</td>
			<td>{date timestamp=$online_members[member]->last_action}</td>
			<td>
			  	<A title="Mitglied Profile anzeigen/bearbeiten" href="{$url_file}page=cms.member.profile&member_id={$online_members[member]->id}"><b>Profil</b></a> &nbsp;·&nbsp; 
			  	<A title="Mitglied Profile anzeigen/bearbeiten" href="{$url_file}page=cms.member.central&member_id={$online_members[member]->id}"><b>Zentrale</b></a> 
			</td>
		</tr>
	{/section}
	</table>